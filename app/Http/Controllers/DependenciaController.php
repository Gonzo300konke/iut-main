<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\UnidadAdministradora;
use App\Models\Responsable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DependenciaController extends Controller
{
    /**
     * Listar todas las dependencias.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $dependencias = Dependencia::with(['unidadAdministradora', 'bienes', 'responsable'])
            ->search($search)
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('dependencias.index', compact('dependencias', 'search'));
    }

    /**
     * Guardar una nueva dependencia.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'unidad_administradora_id' => ['required', 'exists:unidades_administradoras,id'],
        'codigo' => ['required', 'string', 'max:50', 'unique:dependencias,codigo'],
        'nombre' => ['required', 'string', 'max:255'],
        'responsable_id' => ['nullable', 'exists:responsables,id'],
    ], [
        // Mensajes para la Unidad Administradora superior
        'unidad_administradora_id.required' => 'Debe seleccionar una unidad administradora.',
        'unidad_administradora_id.exists'   => 'La unidad administradora seleccionada no es válida.',

        // Mensajes para el Código de la dependencia
        'codigo.required' => 'El código de la dependencia es obligatorio.',
        'codigo.unique'   => 'Este código ya ha sido asignado a otra dependencia.',
        'codigo.max'      => 'El código no debe exceder los 50 caracteres.',

        // Mensajes para el Nombre
        'nombre.required' => 'El nombre de la dependencia es obligatorio.',
        'nombre.max'      => 'El nombre es demasiado largo (máximo 255 caracteres).',

        // Mensaje para el Responsable (es opcional/nullable según tu código)
        'responsable_id.exists' => 'El responsable seleccionado no existe en el sistema.',
    ]);

    $dependencia = Dependencia::create($validated);

    return redirect()->route('dependencias.index')
        ->with('success', 'Dependencia creada correctamente');
}

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $unidadesAdministradoras = UnidadAdministradora::all();
        $responsables = Responsable::all();

        return view('dependencias.create', [
            'unidades' => $unidadesAdministradoras,
            'responsables' => $responsables,
        ]);
    }

    /**
     * Mostrar una dependencia específica.
     */
    public function show(Dependencia $dependencia)
    {
        $dependencia->load(['unidadAdministradora', 'bienes', 'responsable']);

        return view('dependencias.show', compact('dependencia'));
    }

    /**
     * Descargar los detalles de la dependencia en PDF.
     */
    public function exportPdf(Dependencia $dependencia)
    {
        $dependencia->load(['unidadAdministradora', 'bienes', 'responsable']);

        $pdf = Pdf::loadView('dependencias.pdf', [
            'dependencia' => $dependencia,
        ])->setPaper('letter');

        $fileName = sprintf(
            'dependencia_%s_%s.pdf',
            Str::slug($dependencia->codigo, '_'),
            Str::slug($dependencia->nombre, '_')
        );

        return $pdf->download($fileName);
    }

    /**
     * Actualizar una dependencia.
     */
    public function update(Request $request, Dependencia $dependencia)
    {
        $validated = $request->validate([
            'unidad_administradora_id' => ['sometimes', 'exists:unidades_administradoras,id'],
            'codigo' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('dependencias', 'codigo')->ignore($dependencia->getKey()),
            ],
            'nombre' => ['sometimes', 'string', 'max:255'],
            'responsable_id' => ['nullable', 'exists:responsables,id'],
        ]);

        $dependencia->update($validated);

        return redirect()->route('dependencias.index')
            ->with('success', 'Dependencia actualizada correctamente');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Dependencia $dependencia)
    {
        $unidadesAdministradoras = UnidadAdministradora::all();
        $responsables = Responsable::all();

        return view('dependencias.edit', [
            'dependencia' => $dependencia,
            'unidades' => $unidadesAdministradoras,
            'responsables' => $responsables,
        ]);
    }

    /**
     * Eliminar una dependencia.
     */
    public function destroy(Dependencia $dependencia)
    {
        return response()->json(['message' => 'No se pueden eliminar dependencias.'], 403);
    }
}
