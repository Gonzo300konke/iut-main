<?php

namespace App\Http\Controllers;

use App\Enums\EstadoBien;
use App\Models\Bien;
use App\Models\Dependencia;
use App\Models\Organismo;
use App\Models\UnidadAdministradora;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BienController extends Controller
{
    /**
     * Listar todos los bienes.
     */
    // BienController.php
        public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'organismo_id' => ['nullable', 'integer', 'exists:organismos,id'],
            'unidad_id' => ['nullable', 'integer', 'exists:unidades_administradoras,id'],
            'dependencias' => ['nullable', 'array'],
            'dependencias.*' => ['integer', 'exists:dependencias,id'],
            'estado' => ['nullable', 'array'],
            'estado.*' => ['string', Rule::in(array_map(fn (EstadoBien $estado) => $estado->value, EstadoBien::cases()))],
            'fecha_desde' => ['nullable', 'date'],
            'fecha_hasta' => ['nullable', 'date', 'after_or_equal:fecha_desde'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'codigo' => ['nullable', 'string', 'max:255'],
        ]);

        $query = Bien::with([
            'dependencia.responsable',
            'dependencia.unidadAdministradora.organismo',
        ]);

        if (! empty($validated['search'])) {
            $query->search($validated['search']);
        }

        if (! empty($validated['descripcion'])) {
            $query->where('descripcion', 'like', '%'.$validated['descripcion'].'%');
        }

        if (! empty($validated['codigo'])) {
            $query->where('codigo', 'like', '%'.$validated['codigo'].'%');
        }

        if (! empty($validated['estado'])) {
            $query->whereIn('estado', $validated['estado']);
        }

        if (! empty($validated['fecha_desde']) && ! empty($validated['fecha_hasta'])) {
            $query->whereBetween('fecha_registro', [$validated['fecha_desde'], $validated['fecha_hasta']]);
        } elseif (! empty($validated['fecha_desde'])) {
            $query->whereDate('fecha_registro', '>=', $validated['fecha_desde']);
        } elseif (! empty($validated['fecha_hasta'])) {
            $query->whereDate('fecha_registro', '<=', $validated['fecha_hasta']);
        }

        if (! empty($validated['dependencias'])) {
            $query->whereIn('dependencia_id', $validated['dependencias']);
        }

        if (! empty($validated['unidad_id'])) {
            $unidadId = $validated['unidad_id'];
            $query->whereHas('dependencia.unidadAdministradora', fn ($q) => $q->where('id', $unidadId));
        }

        if (! empty($validated['organismo_id'])) {
            $organismoId = $validated['organismo_id'];
            $query->whereHas('dependencia.unidadAdministradora.organismo', fn ($q) => $q->where('id', $organismoId));
        }

        $bienes = $query
            ->orderByDesc('fecha_registro')
            ->paginate(10)
            ->appends($request->query());

        $organismos = Organismo::orderBy('nombre')->get();

        $unidades = UnidadAdministradora::query()
            ->when($validated['organismo_id'] ?? null, fn ($q, $organismoId) => $q->where('organismo_id', $organismoId))
            ->orderBy('nombre')
            ->get();

        $dependencias = Dependencia::query()
            ->with('unidadAdministradora')
            ->when($validated['unidad_id'] ?? null, fn ($q, $unidadId) => $q->where('unidad_administradora_id', $unidadId))
            ->when(
                ($validated['organismo_id'] ?? null) && ! ($validated['unidad_id'] ?? null),
                fn ($q) => $q->whereHas('unidadAdministradora', fn ($sub) => $sub->where('organismo_id', $validated['organismo_id']))
            )
            ->orderBy('nombre')
            ->get();

        $estados = collect(EstadoBien::cases())->mapWithKeys(
            fn (EstadoBien $estado) => [$estado->value => $estado->label()]
        );

        return view('bienes.index', [
            'bienes' => $bienes,
            'filters' => $validated,
            'organismos' => $organismos,
            'unidades' => $unidades,
            'dependencias' => $dependencias,
            'estados' => $estados,
        ]);
    }


    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
    // Cargamos las dependencias con su responsable para mostrar al seleccionar
    $dependencias = Dependencia::with('responsable')->get();

    return view('bienes.create', compact('dependencias'));
    }

    /**
     * Guardar un nuevo bien.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dependencia_id' => ['required', 'exists:dependencias,id'],
            'codigo' => ['required', 'string', 'max:50', 'unique:bienes,codigo'],
            'descripcion' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0'],
            'fotografia' => ['nullable', 'image', 'max:2048'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estado' => ['required', Rule::enum(EstadoBien::class)],
            'fecha_registro' => ['required', 'date'],
        ]);

        if ($request->hasFile('fotografia')) {
            $validated['fotografia'] = $request->file('fotografia')->store('bienes', 'public');
        }

        // El responsable se obtiene dinámicamente a través de la dependencia; no lo almacenamos en la tabla bienes.
        $bien = Bien::create($validated);

        return redirect()
            ->route('bienes.index')
            ->with('success', 'Bien creado correctamente.');
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
     * Descargar los detalles del bien en PDF.
     */
    public function exportPdf(Bien $bien)
    {
        $bien->load(['dependencia.responsable', 'movimientos']);

        $pdf = Pdf::loadView('bienes.pdf', [
            'bien' => $bien,
        ])->setPaper('letter');

        $descriptionSlug = $bien->descripcion
            ? Str::slug(Str::limit($bien->descripcion, 50, ''), '_')
            : 'detalle';

        $fileName = sprintf(
            'bien_%s_%s.pdf',
            Str::slug($bien->codigo, '_'),
            $descriptionSlug
        );

        return $pdf->download($fileName);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Bien $bien)
    {
    // Para editar mostramos la lista de dependencias (si se necesita cambiar)
    $dependencias = Dependencia::with('responsable')->get();
    return view('bienes.edit', compact('bien', 'dependencias'));
    }

    /**
     * Actualizar un bien.
     */
    public function update(Request $request, Bien $bien)
    {
        $validated = $request->validate([
            'dependencia_id' => ['sometimes', 'exists:dependencias,id'],
            'codigo' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('bienes', 'codigo')->ignore($bien->getKey()),
            ],
            'descripcion' => ['sometimes', 'string', 'max:255'],
            'precio' => ['sometimes', 'numeric', 'min:0'],
            'fotografia' => ['nullable', 'image', 'max:2048'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estado' => ['sometimes', Rule::enum(EstadoBien::class)],
            'fecha_registro' => ['sometimes', 'date'],
        ]);

        if ($request->hasFile('fotografia')) {
            if ($bien->fotografia && ! str_starts_with($bien->fotografia, 'http')) {
                Storage::disk('public')->delete($bien->fotografia);
            }

            $validated['fotografia'] = $request->file('fotografia')->store('bienes', 'public');
        }

        // Si se cambió la dependencia, actualizar responsable según dependencia
        // El responsable es gestionado por la dependencia; sólo actualizamos los campos del bien.
        $bien->update($validated);

        return redirect()
            ->route('bienes.index')
            ->with('success', 'Bien actualizado correctamente.');
    }

    /**
     * Eliminar un bien.
     */
    public function destroy(Bien $bien)
    {
        // Verificar permisos: solo administradores pueden eliminar datos
        if (! auth()->user()->canDeleteData()) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'No tienes permisos para eliminar datos del sistema.'], 403);
            }

            abort(403, 'No tienes permisos para eliminar datos del sistema.');
        }

        if ($bien->fotografia && ! str_starts_with($bien->fotografia, 'http')) {
            Storage::disk('public')->delete($bien->fotografia);
        }

        $bien->delete();

        return redirect()
            ->route('bienes.index')
            ->with('success', 'Bien eliminado correctamente.');
    }

}
