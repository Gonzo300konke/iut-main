<?php

namespace App\Traits;

use App\Models\Auditoria;

trait AuditableTrait
{
    protected static function bootAuditableTrait()
    {
        static::created(function ($model) {
            Auditoria::registrar(
                tabla: $model->getTable(),
                registro_id: $model->getKey(),
                operacion: 'CREATE',
                valores_nuevos: $model->getAttributes(),
                descripcion: "Registro creado en {$model->getTable()}"
            );
        });

        static::updated(function ($model) {
            $cambios = $model->getChanges();

            if (! empty($cambios)) {
                $valores_anteriores = [];
                foreach (array_keys($cambios) as $campo) {
                    $valores_anteriores[$campo] = $model->getOriginal($campo);
                }

                Auditoria::registrar(
                    tabla: $model->getTable(),
                    registro_id: $model->getKey(),
                    operacion: 'UPDATE',
                    valores_anteriores: $valores_anteriores,
                    valores_nuevos: $cambios,
                    descripcion: 'Campos actualizados: '.implode(', ', array_keys($cambios))
                );
            }
        });

        static::deleted(function ($model) {
            Auditoria::registrar(
                tabla: $model->getTable(),
                registro_id: $model->getKey(),
                operacion: 'DELETE',
                valores_anteriores: $model->getAttributes(),
                descripcion: "Registro eliminado de {$model->getTable()}"
            );
        });
    }
}
