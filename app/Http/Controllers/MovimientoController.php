<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Eliminado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class MovimientoController extends Controller
{
    /**
     * Listar todos los movimientos.
     */
    public function index()
    {
        // Incluimos relaciones para evitar N+1
        $movimientos = Movimiento::with(['bien', 'usuario', 'historial', 'subject'])->orderByDesc('fecha')->paginate(10);

        // Si el usuario es admin, incluir registros archivados (eliminados) en la vista
        $eliminados = null;
        if (Auth::check()) {
            $current = Auth::user();
            if ($current instanceof Usuario && $current->isAdmin()) {
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
        }

        if (request()->wantsJson()) {
            return response()->json(['movimientos' => $movimientos, 'eliminados' => $eliminados]);
        }

        return view('movimientos.index', compact('movimientos', 'eliminados'));
    }

    /**
     * Mostrar formulario para crear un nuevo movimiento.
     */
    public function create()
    {
        return view('movimientos.create');
    }

    /**
     * Guardar un nuevo movimiento.
     */
    public function store(Request $request)
    {
        // Solo permitir creación manual vía UI para administradores.
        if (! $request->expectsJson()) {
            if (! Auth::check()) {
                abort(403, 'Solo administradores pueden crear movimientos manualmente.');
            }

            $current = Auth::user();
            if (! ($current instanceof Usuario && $current->isAdmin())) {
                abort(403, 'Solo administradores pueden crear movimientos manualmente.');
            }
        }

        $validated = $request->validate([
            'bien_id' => ['nullable', 'exists:bienes,id'],
            'subject_type' => ['nullable', 'string', 'max:255'],
            'subject_id' => ['nullable', 'integer'],
            'tipo' => ['required', 'string', 'max:50'],
            'fecha' => ['required', 'date'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            'usuario_id' => ['required', 'exists:usuarios,id'],
        ]);

        // Validate subject_type against allowed classes and ensure subject exists
        $allowed = [
            \App\Models\Organismo::class,
            \App\Models\UnidadAdministradora::class,
            \App\Models\Dependencia::class,
            \App\Models\Bien::class,
            \App\Models\Usuario::class,
        ];

        if (! empty($validated['subject_type'])) {
            if (! in_array($validated['subject_type'], $allowed, true)) {
                return back()->withErrors(['subject_type' => 'Tipo de sujeto no permitido'])->withInput();
            }

            $modelClass = $validated['subject_type'];
            $exists = $modelClass::where('id', $validated['subject_id'] ?? 0)->exists();
            if (! $exists) {
                return back()->withErrors(['subject_id' => 'El sujeto indicado no existe'])->withInput();
            }

            // If subject is a Bien, ensure bien_id is set for compatibility
            if ($modelClass === \App\Models\Bien::class && empty($validated['bien_id'])) {
                $validated['bien_id'] = $validated['subject_id'];
            }
        }

        $movimiento = Movimiento::create($validated);

        if ($request->expectsJson()) {
            return response()->json($movimiento, 201);
        }

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente.');
    }

    /**
     * Mostrar formulario para editar un movimiento.
     */
    public function edit(Movimiento $movimiento)
    {
        return view('movimientos.edit', compact('movimiento'));
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
            'subject_type' => ['sometimes', 'string', 'max:255'],
            'subject_id' => ['sometimes', 'integer'],
            'tipo' => ['sometimes', 'string', 'max:50'],
            'fecha' => ['sometimes', 'date'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            'usuario_id' => ['sometimes', 'exists:usuarios,id'],
        ]);

        $allowed = [
            \App\Models\Organismo::class,
            \App\Models\UnidadAdministradora::class,
            \App\Models\Dependencia::class,
            \App\Models\Bien::class,
            \App\Models\Usuario::class,
        ];

        if (! empty($validated['subject_type'])) {
            if (! in_array($validated['subject_type'], $allowed, true)) {
                return back()->withErrors(['subject_type' => 'Tipo de sujeto no permitido'])->withInput();
            }

            $modelClass = $validated['subject_type'];
            $exists = $modelClass::where('id', $validated['subject_id'] ?? 0)->exists();
            if (! $exists) {
                return back()->withErrors(['subject_id' => 'El sujeto indicado no existe'])->withInput();
            }

            if ($modelClass === \App\Models\Bien::class && empty($validated['bien_id'])) {
                $validated['bien_id'] = $validated['subject_id'];
            }
        }

        $movimiento->update($validated);

        return response()->json($movimiento);
    }

    /**
     * Eliminar un movimiento.
     */
    public function destroy(Movimiento $movimiento)
    {
        // Archivar movimiento antes de borrar
        $deletedBy = null;
        if (Auth::check() && Auth::user() && is_numeric(Auth::user()->id)) {
            $deletedBy = Auth::user()->id;
        }

        \App\Services\EliminadosService::archiveModel($movimiento, $deletedBy);
        $movimiento->delete();

        return response()->json(null, 204);
    }

    /**
     * Restaurar un registro archivado (eliminado) — sólo admin
     */
    public function restoreEliminado(Eliminado $eliminado)
    {
        if (! Auth::check()) {
            abort(403, 'Solo administradores pueden restaurar registros eliminados.');
        }

        $current = Auth::user();
        if (! ($current instanceof Usuario && $current->isAdmin())) {
            abort(403, 'Solo administradores pueden restaurar registros eliminados.');
        }

        $ok = \App\Services\EliminadosService::restoreEliminado($eliminado);
        if (! $ok) {
            return redirect()->route('movimientos.index')->with('error', 'La restauración falló. Revisa los logs.');
        }

        return redirect()->route('movimientos.index')->with('success', 'Registro restaurado correctamente.');
    }
}
