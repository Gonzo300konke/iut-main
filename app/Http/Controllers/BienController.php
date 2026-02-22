<?php

namespace App\Http\Controllers;

use App\Enums\EstadoBien;
use App\Enums\TipoBien;
use App\Models\Bien;
use App\Models\Dependencia;
use App\Models\Organismo;
use App\Models\UnidadAdministradora;
use App\Services\CodigoUnicoService;
use App\Services\FpdfReportService;
use App\Models\BienElectronico;
use App\Models\BienVehiculo;
use App\Models\BienMobiliario;
use App\Models\BienOtro;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\BienTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Codedge\Fpdf\Fpdf\Fpdf;

class BienController extends Controller
{
    private BienTypeService $bienTypeService;

    public function __construct(BienTypeService $bienTypeService)
    {
        $this->bienTypeService = $bienTypeService;
    }
    /**
     * Listar todos los bienes.
     */
    public function index(Request $request)
{
    // 1. Validación de entrada
    $validated = $request->validate([
        'search'         => ['nullable', 'string', 'max:255'],
        'organismo_id'   => ['nullable', 'integer', 'exists:organismos,id'],
        'unidad_id'      => ['nullable', 'integer', 'exists:unidades_administradoras,id'],
        'dependencias'   => ['nullable', 'array'],
        'dependencias.*' => ['integer', 'exists:dependencias,id'],
        'estado'         => ['nullable', 'array'],
        'estado.*'       => ['string', Rule::in(array_map(fn($e) => $e->value, EstadoBien::cases()))],
        'fecha_desde'    => ['nullable', 'date'],
        'tipo_bien' => ['nullable', 'string'],
        'fecha_hasta'    => ['nullable', 'date', 'after_or_equal:fecha_desde'],
        'sort'           => ['nullable', 'string', Rule::in(['codigo', 'descripcion', 'precio', 'fecha_registro', 'estado'])],
        'direction'      => ['nullable', 'string', Rule::in(['asc', 'desc'])],
    ]);

    // 2. Construcción de la consulta con relaciones
    $query = Bien::with([
        'dependencia.responsable',
        'dependencia.unidadAdministradora.organismo',
    ]);

    // 🔎 Filtros dinámicos
    if (!empty($validated['search'])) {
        $query->search($validated['search']);
    }

    if (!empty($validated['estado'])) {
        $query->whereIn('estado', $validated['estado']);
    }
    if ($request->filled('tipo_bien')) {
    $query->where('tipo_bien', $request->tipo_bien);
}

    // Filtrado por Fechas
    $query->when($validated['fecha_desde'] ?? null, fn($q, $f) => $q->whereDate('fecha_registro', '>=', $f))
          ->when($validated['fecha_hasta'] ?? null, fn($q, $f) => $q->whereDate('fecha_registro', '<=', $f));

    // Filtrado por Relaciones (Jerarquía)
    if (!empty($validated['dependencias'])) {
        $query->whereIn('dependencia_id', $validated['dependencias']);
    } elseif (!empty($validated['unidad_id'])) {
        $query->whereHas('dependencia', fn($q) => $q->where('unidad_administradora_id', $validated['unidad_id']));
    } elseif (!empty($validated['organismo_id'])) {
        $query->whereHas('dependencia.unidadAdministradora', fn($q) => $q->where('organismo_id', $validated['organismo_id']));
    }

    // ⚡️ Ordenamiento y Paginación
    $sort = $validated['sort'] ?? 'fecha_registro';
    $direction = $validated['direction'] ?? 'desc';

    $bienes = $query->orderBy($sort, $direction)
                    ->paginate(10)
                    ->appends($request->query());

    // 3. Respuesta AJAX (Solo la tabla)
    if ($request->ajax()) {
        return view('bienes.partials.table', compact('bienes'))->render();
    }

    // 4. Carga de datos para selectores (Solo para carga inicial no-AJAX)
    $organismos = Organismo::orderBy('nombre')->get();

    $unidades = UnidadAdministradora::query()
        ->when($validated['organismo_id'] ?? null, fn($q, $id) => $q->where('organismo_id', $id))
        ->orderBy('nombre')
        ->get();

    $dependencias = Dependencia::query()
        ->with('unidadAdministradora')
        ->when($validated['unidad_id'] ?? null, fn($q, $id) => $q->where('unidad_administradora_id', $id))
        ->when(($validated['organismo_id'] ?? null) && empty($validated['unidad_id']),
            fn($q) => $q->whereHas('unidadAdministradora', fn($sub) => $sub->where('organismo_id', $validated['organismo_id']))
        )
        ->orderBy('nombre')
        ->get();

    $estados = collect(EstadoBien::cases())->mapWithKeys(
        fn(EstadoBien $estado) => [$estado->value => $estado->label()]
    );
    $tiposBien = [
    'mueble'      => 'Bien Mueble',
    'vehiculo'    => 'Vehículo',
    'electronico' => 'Bien Electrónico', // 🆕 Agregado
];

    return view('bienes.index', [
        'bienes'       => $bienes,
        'filters'      => $validated,
        'organismos'   => $organismos,
        'unidades'     => $unidades,
        'dependencias' => $dependencias,
        'estados'      => $estados,
        'tiposBien' => $tiposBien,
    ]);
}

    /**
     * Mostrar formulario de creación con lógica de código secuencial.
     */
    public function create()
    {
        // Uso del servicio para sugerir el código real disponible
        $codigoSugerido = CodigoUnicoService::obtenerSiguienteCodigo();

        $dependencias = Dependencia::with('responsable')->get();

        $tiposBien = collect(TipoBien::cases())->mapWithKeys(
            fn(TipoBien $tipo) => [$tipo->value => $tipo->label()]
        );

        return view('bienes.create', compact('dependencias', 'tiposBien', 'codigoSugerido'));
    }

    /**
     * Guardar un nuevo bien.
     */
    public function store(Request $request)
    {
        // Construir reglas base
        $rules = [
            'dependencia_id' => ['nullable', 'exists:dependencias,id'],
            'codigo' => [
                'required',
                'string',
                'size:8',
                'regex:/^[0-9]+$/',
                function ($attribute, $value, $fail) {
                    if (CodigoUnicoService::codigoExiste($value)) {
                        $info = CodigoUnicoService::obtenerUbicacionCodigo($value);
                        $fail("El código ya está asignado a: " . $info['tabla'] . " (" . $info['nombre'] . ")");
                    }
                }
            ],
            'descripcion' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0'],
            'fotografia' => ['nullable', 'image', 'max:2048'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estado' => ['required', Rule::enum(EstadoBien::class)],
            'tipo_bien' => ['required', Rule::enum(TipoBien::class)],
            'fecha_registro' => ['required', 'date'],
            'acta_desincorporacion' => ['nullable', 'required_if:estado,DESINCORPORADO', 'file', 'mimes:pdf', 'max:2048'],
            'motivo_desincorporacion' => ['nullable', 'required_if:estado,DESINCORPORADO', 'string', 'max:500'],
        ];

        // Reglas específicas según tipo de bien
        $tipo = $request->input('tipo_bien');
        $rules = array_merge($rules, $this->reglasEspecificasPorTipo($tipo));

        $validated = $request->validate($rules);

        // Procesar fotografía
        if ($request->hasFile('fotografia')) {
            // Evitar fotos duplicadas: comparar hash del archivo subido con fotos existentes
            $file = $request->file('fotografia');
            $uploadedHash = md5_file($file->getRealPath());

            $existing = Bien::whereNotNull('fotografia')->get(['id', 'fotografia']);
            foreach ($existing as $ex) {
                try {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($ex->fotografia)) {
                        $path = \Illuminate\Support\Facades\Storage::disk('public')->path($ex->fotografia);
                        if (file_exists($path) && md5_file($path) === $uploadedHash) {
                            return back()->withErrors(['fotografia' => 'La fotografía ya está asociada a otro bien (ID: ' . $ex->id . ').'])->withInput();
                        }
                    }
                } catch (\Throwable $e) {
                    // En caso de problemas leyendo algún archivo remoto/antiguo, ignoramos y continuamos
                    continue;
                }
            }

            $foto = $this->procesarFotografia($request);
            if ($foto) $validated['fotografia'] = $foto;
        }

        // Separar datos que NO pertenecen a la tabla bienes
        $actaFile = $request->file('acta_desincorporacion');
        $motivoDesincorporacion = $validated['motivo_desincorporacion'] ?? null;
        $datosBien = collect($validated)->except([
            'acta_desincorporacion', 'motivo_desincorporacion',
            // Campos de subtablas
            'subtipo', 'procesador', 'memoria', 'almacenamiento', 'pantalla', 'serial', 'garantia',
            'marca', 'modelo', 'anio', 'placa', 'motor', 'chasis', 'combustible', 'kilometraje',
            'material', 'dimensiones', 'color', 'capacidad', 'cantidad_piezas', 'acabado',
            'especificaciones', 'cantidad', 'presentacion',
        ])->toArray();

        $bien = Bien::create($datosBien);

        // Guardar datos específicos del tipo con datos validados
        if ($tipo) {
            $this->bienTypeService->sync($bien, $tipo, $validated);
        }

        // Crear registro de desincorporación si aplica
        if ($bien->estado === EstadoBien::DESINCORPORADO && $actaFile) {
            $actaPath = $actaFile->store('actas_desincorporacion', 'public');
            $bien->desincorporado()->create([
                'motivo_desincorporacion' => $motivoDesincorporacion ?? 'Sin motivo especificado',
                'acta_desincorporacion' => $actaPath,
            ]);
        }

        return redirect()->route('bienes.index')->with('success', 'Bien creado correctamente.');
    }

    /**
     * Mostrar un bien específico.
     */
    public function show(Bien $bien)
    {
        $bien->load(['dependencia.responsable', 'movimientos']);
        return view('bienes.show', compact('bien'));
    }

    /**
     * Exportar detalle a PDF.
     */
    public function exportPdf(Bien $bien)
    {
        $bien->loadMissing(['dependencia.responsable', 'movimientos.usuario']);
        $movimientos = $bien->movimientos()->orderByDesc('fecha')->orderByDesc('created_at')->get();

        $pdf = Pdf::loadView('bienes.pdf', [
            'bien' => $bien,
            'dependencia' => $bien->dependencia,
            'responsablePrimario' => $bien->responsable_primario,
            'movimientos' => $movimientos,
        ])->setPaper('letter');

        $fileName = sprintf('bien_%s_%s.pdf', Str::slug($bien->codigo ?? 'sin_codigo', '_'), Str::slug(Str::limit($bien->descripcion, 50, ''), '_'));
        return $pdf->download($fileName);
    }

    private function procesarFotografia(Request $request, ?Bien $bien = null): ?string
    {
        if (!$request->hasFile('fotografia'))
            return null;
        $file = $request->file('fotografia');
        if ($bien && $bien->fotografia && !str_starts_with($bien->fotografia, 'http')) {
            Storage::disk('public')->delete($bien->fotografia);
        }
        $filename = uniqid('bien_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('bienes', $filename, 'public');
    }
    /**
 * Mostrar el formulario para editar un bien específico.
 */
    public function edit(Bien $bien)
    {
        // Eager-load relaciones de subtipo para popular campos dinámicos
        $bien->load(['dependencia.responsable', 'electronico', 'mobiliario', 'vehiculo', 'otro']);

        $dependencias = Dependencia::with('responsable')->get();

        $tiposBien = collect(TipoBien::cases())->mapWithKeys(
            fn(TipoBien $tipo) => [$tipo->value => $tipo->label()]
        );

        $estados = collect(EstadoBien::cases())->mapWithKeys(
            fn(EstadoBien $estado) => [$estado->value => $estado->label()]
        );

        // Datos del subtipo actual para los campos dinámicos en JS
        $subtipoData = $this->obtenerDatosSubtipo($bien);

        return view('bienes.edit', compact('bien', 'dependencias', 'tiposBien', 'estados', 'subtipoData'));
    }

    public function update(Request $request, Bien $bien)
    {
        // Construir reglas base
        $rules = [
            'dependencia_id' => ['nullable', 'exists:dependencias,id'],
            'codigo' => [
                'sometimes',
                'string',
                'size:8',
                'regex:/^[0-9]+$/',
                function ($attribute, $value, $fail) use ($bien) {
                    if (CodigoUnicoService::codigoExiste($value, 'bienes', $bien->id)) {
                        $info = CodigoUnicoService::obtenerUbicacionCodigo($value);
                        $fail("Código en uso por " . $info['tabla']);
                    }
                }
            ],
            'descripcion' => ['sometimes', 'string', 'max:255'],
            'precio' => ['sometimes', 'numeric', 'min:0'],
            'fotografia' => ['nullable', 'image', 'max:2048'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estado' => ['sometimes', Rule::enum(EstadoBien::class)],
            'tipo_bien' => ['sometimes', Rule::enum(TipoBien::class)],
            'fecha_registro' => ['sometimes', 'date'],
        ];

        // Reglas específicas según tipo de bien
        $tipo = $request->input('tipo_bien', $bien->tipo_bien?->value);
        $rules = array_merge($rules, $this->reglasEspecificasPorTipo($tipo));

        $validated = $request->validate($rules);

        // Procesar fotografía
        if ($request->hasFile('fotografia')) {
            $foto = $this->procesarFotografia($request, $bien);
            if ($foto) $validated['fotografia'] = $foto;
        }

        // Separar datos que NO pertenecen a la tabla bienes
        $datosBien = collect($validated)->except([
            'subtipo', 'procesador', 'memoria', 'almacenamiento', 'pantalla', 'serial', 'garantia',
            'marca', 'modelo', 'anio', 'placa', 'motor', 'chasis', 'combustible', 'kilometraje',
            'material', 'dimensiones', 'color', 'capacidad', 'cantidad_piezas', 'acabado',
            'especificaciones', 'cantidad', 'presentacion',
        ])->toArray();

        // Si cambió el tipo de bien, eliminar el subtipo anterior
        $tipoAnterior = $bien->tipo_bien?->value;
        if ($tipo && $tipoAnterior && strtoupper($tipo) !== strtoupper($tipoAnterior)) {
            $this->eliminarSubtipoAnterior($bien, $tipoAnterior);
        }

        $bien->update($datosBien);

        // Sincronizar datos específicos del tipo con datos validados
        if ($tipo) {
            $this->bienTypeService->sync($bien, $tipo, $validated);
        }

        return redirect()->route('bienes.index')->with('success', 'Bien actualizado.');
    }

    /**
     * Mostrar formulario de desincorporación.
     */
    public function showDesincorporarForm(Bien $bien)
    {
        return view('bienes.desincorporar', compact('bien'));
    }

    /**
     * Procesar la desincorporación de un bien.
     */
    public function desincorporar(Request $request, Bien $bien)
    {
        $validated = $request->validate([
            'motivo' => 'required|string|max:255',
            'acta_desincorporacion' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Guardar el archivo del acta
        $path = $request->file('acta_desincorporacion')->store('actas_desincorporacion', 'public');

        // Mover el bien a la tabla de eliminados
        \DB::table('eliminados')->insert([
            'model_type' => Bien::class,
            'model_id' => $bien->id,
            'data' => json_encode($bien->toArray()),
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Eliminar el bien de la tabla principal
        $bien->delete();

        return redirect()->route('bienes.index')->with('success', 'El bien ha sido desincorporado y movido a la tabla de eliminados.');
    }

    /**
     * Desincorporar un bien.
     */
    public function destroy(Bien $bien)
    {
        if (!auth()->user()->canDeleteData()) {
            return response()->json(['message' => 'No tienes permisos para desincorporar bienes.'], 403);
        }

        $userId = auth()->id();
        \App\Models\Movimiento::create([
            'bien_id' => $bien->id,
            'tipo' => 'desincorporación',
            'descripcion' => 'Bien desincorporado',
            'usuario_id' => $userId,
        ]);

        $bien->update(['estado' => EstadoBien::EXTRAVIADO]);
        \App\Services\EliminadosService::archiveModel($bien, $userId);

        return redirect()->route('bienes.index')->with('success', 'Bien desincorporado correctamente.');
    }

    public function galeriaCompleta()
    {
        $imagenes = Bien::whereNotNull('fotografia')
            ->where('fotografia', '!=', '')
            ->select('id', 'codigo', 'descripcion', 'fotografia')
            ->get()
            ->map(fn($b) => (object) [
                'id' => $b->id,
                'codigo' => $b->codigo,
                'descripcion' => $b->descripcion,
                'url' => Storage::url($b->fotografia)
            ]);

        return view('bienes.galeria-completa', compact('imagenes'));
    }

    /**
     * Reglas de validación específicas según el tipo de bien.
     */
    private function reglasEspecificasPorTipo(?string $tipo): array
    {
        $tipo = strtoupper($tipo ?? '');

        return match ($tipo) {
            'ELECTRONICO' => [
                'subtipo' => ['nullable', 'string', 'max:20'],
                'procesador' => ['nullable', 'string', 'max:255'],
                'memoria' => ['nullable', 'string', 'max:255'],
                'almacenamiento' => ['nullable', 'string', 'max:255'],
                'pantalla' => ['nullable', 'string', 'max:255'],
                'serial' => ['required_if:tipo_bien,ELECTRONICO', 'string', 'max:255'],
                'garantia' => ['nullable', 'date'],
            ],
            'VEHICULO' => [
                'marca' => ['nullable', 'string', 'max:100'],
                'modelo' => ['nullable', 'string', 'max:100'],
                'anio' => ['nullable', 'string', 'max:10'],
                'placa' => ['nullable', 'string', 'max:50'],
                'motor' => ['nullable', 'string', 'max:100'],
                'chasis' => ['nullable', 'string', 'max:100'],
                'combustible' => ['nullable', 'string', 'max:50'],
                'kilometraje' => ['nullable', 'string', 'max:50'],
            ],
            'MOBILIARIO' => [
                'material' => ['nullable', 'string', 'max:255'],
                'dimensiones' => ['nullable', 'string', 'max:255'],
                'color' => ['nullable', 'string', 'max:100'],
                'capacidad' => ['nullable', 'string', 'max:100'],
                'cantidad_piezas' => ['nullable', 'integer', 'min:0'],
                'acabado' => ['nullable', 'string', 'max:100'],
            ],
            'OTROS' => [
                'especificaciones' => ['nullable', 'string'],
                'cantidad' => ['nullable', 'integer', 'min:0'],
                'presentacion' => ['nullable', 'string', 'max:255'],
            ],
            default => [],
        };
    }

    /**
     * Eliminar el registro de subtipo anterior cuando cambia el tipo de bien.
     */
    private function eliminarSubtipoAnterior(Bien $bien, string $tipoAnterior): void
    {
        match (strtoupper($tipoAnterior)) {
            'ELECTRONICO' => $bien->electronico()?->delete(),
            'VEHICULO' => $bien->vehiculo()?->delete(),
            'MOBILIARIO' => $bien->mobiliario()?->delete(),
            'OTROS' => $bien->otro()?->delete(),
            default => null,
        };
    }

    /**
     * Obtener datos del subtipo actual para los campos dinámicos en la vista edit.
     */
    private function obtenerDatosSubtipo(Bien $bien): array
    {
        $tipo = $bien->tipo_bien?->value;
        if (!$tipo) return [];

        $relacion = match (strtoupper($tipo)) {
            'ELECTRONICO' => $bien->electronico,
            'VEHICULO' => $bien->vehiculo,
            'MOBILIARIO' => $bien->mobiliario,
            'OTROS' => $bien->otro,
            default => null,
        };

        return $relacion ? $relacion->toArray() : [];
    }

    public function generarReporte(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'dependencias' => ['nullable', 'array'],
            'estado' => ['nullable', 'array'],
            'fecha_desde' => ['nullable', 'date'],
            'fecha_hasta' => ['nullable', 'date'],
        ]);

        $query = Bien::with(['dependencia.responsable', 'dependencia.unidadAdministradora.organismo']);

        if (!empty($validated['search']))
            $query->search($validated['search']);
        if (!empty($validated['estado']))
            $query->whereIn('estado', $validated['estado']);
        if (!empty($validated['dependencias']))
            $query->whereIn('dependencia_id', $validated['dependencias']);

        $bienes = $query->get();
        $reporteService = new \App\Services\FpdfReportService();

        return $reporteService->downloadBienesListado(
            'reporte_bienes_' . now()->format('dmY_His') . '.pdf',
            'REPORTE DE BIENES E INVENTARIO',
            'Listado filtrado de bienes institucionales',
            now()->format('d/m/Y H:i'),
            $bienes
        );
    }
}
