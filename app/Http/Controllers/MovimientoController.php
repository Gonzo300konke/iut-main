<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Eliminado;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Listar todos los movimientos.
     */
    public function index()
    {
        // Incluimos relaciones para evitar N+1
        $movimientos = Movimiento::with(['bien', 'usuario', 'historial'])->orderByDesc('fecha')->paginate(10);

        // Si el usuario es admin, incluir registros archivados (eliminados) en la vista
        $eliminados = null;
        if (auth()->check() && auth()->user()->isAdmin()) {
            $eliminados = Eliminado::orderByDesc('deleted_at')->paginate(10, ['*'], 'eliminados_page');

            // Cargar nombres de usuario que realizaron la eliminación para mostrar en la vista
            $userIds = $eliminados->pluck('deleted_by')->unique()->filter()->values()->all();
            $users = [];
            if (! empty($userIds)) {
                $users = \App\Models\Usuario::whereIn('id', $userIds)->get()->keyBy('id');
            }

            // Añadir un atributo temporal 'deleted_by_user' en cada Eliminado
            $eliminados->getCollection()->transform(function($item) use ($users) {
                $item->deleted_by_user = null;
                if (! empty($item->deleted_by) && isset($users[$item->deleted_by])) {
                    $item->deleted_by_user = $users[$item->deleted_by]->nombre_completo ?? $users[$item->deleted_by]->correo ?? null;
                }

                // Si no hay deleted_by real, intentar obtener el nombre del snapshot (si fue guardado al archivar)
                if (empty($item->deleted_by_user) && is_array($item->data) && ! empty($item->data['_archived_by'])) {
                    $item->deleted_by_user = $item->data['_archived_by'];
                }

                return $item;
            });
        }

        if (request()->wantsJson()) {
            return response()->json(['movimientos' => $movimientos, 'eliminados' => $eliminados]);
        }

        return view('movimientos.index', compact('movimientos', 'eliminados'));
    }

    /**
     * Guardar un nuevo movimiento.
     */
    public function store(Request $request)
    {
        // Solo permitir creación manual vía UI para administradores.
        if (! $request->expectsJson() && (! auth()->check() || ! auth()->user()->isAdmin())) {
            abort(403, 'Solo administradores pueden crear movimientos manualmente.');
        }

        $validated = $request->validate([
            'bien_id' => ['required', 'exists:bienes,id'],
            'tipo' => ['required', 'string', 'max:50'],
            'fecha' => ['required', 'date'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            'usuario_id' => ['required', 'exists:usuarios,id'],
        ]);

        $movimiento = Movimiento::create($validated);

        if ($request->expectsJson()) {
            return response()->json($movimiento, 201);
        }

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente.');
    }

    /**
     * Mostrar un movimiento específico.
     */
    public function show(Movimiento $movimiento)
    {
        $movimiento->load(['bien', 'usuario', 'historial']);

        if (request()->wantsJson()) {
            return response()->json($movimiento);
        }

        return view('movimientos.show', compact('movimiento'));
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
        // Archivar movimiento antes de borrar
        \App\Services\EliminadosService::archiveModel($movimiento, auth()->id());
        $movimiento->delete();

        return response()->json(null, 204);
    }

    /**
     * Restaurar un registro archivado (eliminado) — sólo admin
     */
    public function restoreEliminado(Eliminado $eliminado)
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Solo administradores pueden restaurar registros eliminados.');
        }

        $ok = \App\Services\EliminadosService::restoreEliminado($eliminado);
        if (! $ok) {
            return redirect()->route('movimientos.index')->with('error', 'La restauración falló. Revisa los logs.');
        }

        return redirect()->route('movimientos.index')->with('success', 'Registro restaurado correctamente.');
    }
}
