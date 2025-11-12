<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Listar todos los movimientos.
     */
    public function index()
    {
        // Incluimos relaciones para evitar N+1
        $movimientos = Movimiento::with(['bien', 'usuario', 'historial'])->paginate(10);

        return response()->json($movimientos);
    }

    /**
     * Guardar un nuevo movimiento.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bien_id' => ['required', 'exists:bienes,id'],
            'tipo' => ['required', 'string', 'max:50'],
            'fecha' => ['required', 'date'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            'usuario_id' => ['required', 'exists:usuarios,id'],
        ]);

        $movimiento = Movimiento::create($validated);

        return response()->json($movimiento, 201);
    }

    /**
     * Mostrar un movimiento específico.
     */
    public function show(Movimiento $movimiento)
    {
        $movimiento->load(['bien', 'usuario', 'historial']);

        return response()->json($movimiento);
    }

    /**
     * Actualizar un movimiento.
     */
    public function update(Request $request, Movimiento $movimiento)
    {
        $validated = $request->validate([
            'bien_id' => ['sometimes', 'exists:bienes,id'],
            'tipo' => ['sometimes', 'string', 'max:50'],
            'fecha' => ['sometimes', 'date'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            'usuario_id' => ['sometimes', 'exists:usuarios,id'],
        ]);

        $movimiento->update($validated);

        return response()->json($movimiento);
    }

    /**
     * Eliminar un movimiento.
     */
    public function destroy(Movimiento $movimiento)
    {
        $movimiento->delete();

        return response()->json(null, 204);
    }
}
