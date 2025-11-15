<?php

namespace App\Observers;

use App\Enums\EstadoBien;
use App\Models\Bien;
use App\Models\HistorialMovimiento;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;

class BienObserver
{
    /**
     * Intenta resolver el id numérico del `Usuario` autenticado.
     * Puede devolver null si no se logra resolver.
     */
    private function resolveAuthenticatedUserId(): ?int
    {
        try {
            $user = Auth::user();
            if ($user && isset($user->id)) {
                return (int) $user->id;
            }

            $identifier = Auth::id();
            if (is_numeric($identifier)) {
                return (int) $identifier;
            }

            // Si el identificador es un correo, intentar buscar el usuario por correo
            if (is_string($identifier) && filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
                $u = \App\Models\Usuario::where('correo', $identifier)->first();
                if ($u) {
                    return (int) $u->id;
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return null;
    }

    public function created(Bien $bien)
    {
        try {
            $userId = $this->resolveAuthenticatedUserId();

            Movimiento::create([
                'bien_id' => $bien->id,
                'subject_type' => Bien::class,
                'subject_id' => $bien->id,
                'tipo' => 'Registro',
                'fecha' => now(),
                'observaciones' => 'Registro inicial del bien',
                'usuario_id' => $userId,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function updating(Bien $bien)
    {
        // Nothing here; handle in updated to have access to original values via getOriginal()
    }

    public function updated(Bien $bien)
    {
        $original = $bien->getOriginal();

        // Transferencia: cambio de dependencia
        if (array_key_exists('dependencia_id', $bien->getChanges()) && ($original['dependencia_id'] ?? null) != $bien->dependencia_id) {
            $oldDep = $original['dependencia_id'] ? \App\Models\Dependencia::find($original['dependencia_id']) : null;
            $newDep = $bien->dependencia_id ? \App\Models\Dependencia::find($bien->dependencia_id) : null;

            $observ = sprintf('Transferencia de dependencia: %s -> %s', $oldDep?->nombre ?? 'N/A', $newDep?->nombre ?? 'N/A');

                try {
                $userId = $this->resolveAuthenticatedUserId();

                $mov = Movimiento::create([
                    'bien_id' => $bien->id,
                    'subject_type' => Bien::class,
                    'subject_id' => $bien->id,
                    'tipo' => 'Transferencia',
                    'fecha' => now(),
                    'observaciones' => $observ,
                    'usuario_id' => $userId,
                ]);

                HistorialMovimiento::create([
                    'movimiento_id' => $mov->id,
                    'fecha' => now(),
                    'detalle' => $observ,
                ]);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // Cambio de estado
        if (array_key_exists('estado', $bien->getChanges()) && ($original['estado'] ?? null) != $bien->estado) {
            $observ = sprintf('Cambio de estado: %s -> %s', $original['estado'] ?? 'N/A', $bien->estado);
                try {
                $userId = $this->resolveAuthenticatedUserId();

                $mov = Movimiento::create([
                    'bien_id' => $bien->id,
                    'subject_type' => Bien::class,
                    'subject_id' => $bien->id,
                    'tipo' => 'Estado',
                    'fecha' => now(),
                    'observaciones' => $observ,
                    'usuario_id' => $userId,
                ]);

                HistorialMovimiento::create([
                    'movimiento_id' => $mov->id,
                    'fecha' => now(),
                    'detalle' => $observ,
                ]);
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }

    public function deleting(Bien $bien)
    {
        // Registrar movimiento de baja antes de eliminar
        try {
            $userId = $this->resolveAuthenticatedUserId();

            Movimiento::create([
                'bien_id' => $bien->id,
                'subject_type' => Bien::class,
                'subject_id' => $bien->id,
                'tipo' => 'Baja',
                'fecha' => now(),
                'observaciones' => 'Eliminación del bien',
                'usuario_id' => $userId,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
