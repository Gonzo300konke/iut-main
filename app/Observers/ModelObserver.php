<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movimiento;
use App\Models\HistorialMovimiento;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
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

    public function created(Model $model)
    {
        try {
            Movimiento::create([
                'subject_type' => get_class($model),
                'subject_id' => $model->id,
                'tipo' => 'Registro',
                'fecha' => now(),
                'observaciones' => sprintf('Registro de %s (id=%s)', class_basename($model), $model->id),
                'usuario_id' => $this->resolveAuthenticatedUserId(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function updated(Model $model)
    {
        try {
            $changes = $model->getChanges();
            $original = $model->getOriginal();

            $fields = [];
            foreach ($changes as $k => $v) {
                $fields[] = sprintf('%s: %s -> %s', $k, $original[$k] ?? 'N/A', $v);
            }

            $detalle = $fields ? implode('; ', $fields) : 'Actualización';

            $mov = Movimiento::create([
                'subject_type' => get_class($model),
                'subject_id' => $model->id,
                'tipo' => 'Actualización',
                'fecha' => now(),
                'observaciones' => $detalle,
                'usuario_id' => $this->resolveAuthenticatedUserId(),
            ]);

            if ($mov) {
                HistorialMovimiento::create([
                    'movimiento_id' => $mov->id,
                    'fecha' => now(),
                    'detalle' => $detalle,
                ]);
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function deleting(Model $model)
    {
        try {
            Movimiento::create([
                'subject_type' => get_class($model),
                'subject_id' => $model->id,
                'tipo' => 'Eliminación',
                'fecha' => now(),
                'observaciones' => sprintf('Eliminación de %s (id=%s)', class_basename($model), $model->id),
                'usuario_id' => $this->resolveAuthenticatedUserId(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
