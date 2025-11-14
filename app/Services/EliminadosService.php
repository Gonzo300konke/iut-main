<?php

namespace App\Services;

use App\Models\Eliminado;
use Illuminate\Support\Facades\DB;

class EliminadosService
{
    /**
     * Archiva un modelo dado en la tabla eliminados.
     * Guarda una copia JSON del modelo y el usuario que borró.
     */
    /**
     * @param mixed $deletedBy id del usuario que elimina (int|string|null)
     */
    public static function archiveModel($model, $deletedBy = null): Eliminado
    {
        $data = $model->toArray();

        // If we can resolve the user who performed the deletion, store a human-readable name inside the snapshot
        $archivedByName = null;
        if (is_numeric($deletedBy)) {
            try {
                $user = \App\Models\Usuario::find((int) $deletedBy);
                if ($user) {
                    $archivedByName = $user->nombre_completo ?? $user->correo ?? null;
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        if ($archivedByName) {
            $data['_archived_by'] = $archivedByName;
        }

        $record = Eliminado::create([
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'data' => $data,
            'deleted_by' => is_numeric($deletedBy) ? (int) $deletedBy : null,
            'deleted_at' => now(),
        ]);

        return $record;
    }

    /**
     * Restaura un registro archivado. Devuelve true/false dependiendo del éxito.
     */
    public static function restoreEliminado(Eliminado $eliminado): bool
    {
        $data = $eliminado->data ?? [];
        if (empty($data)) {
            return false;
        }

        // Obtener el nombre de la tabla del modelo
        $modelClass = $eliminado->model_type;

        if (! class_exists($modelClass)) {
            return false;
        }

        $instance = new $modelClass;
        $table = $instance->getTable();

        // Intentar reinsertar sin la clave primaria (si existe)
        $primary = $instance->getKeyName();
        if (isset($data[$primary])) {
            unset($data[$primary]);
        }

        // Filtrar sólo columnas existentes en la tabla para evitar errores de constraint
        try {
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
        } catch (\Throwable $e) {
            report($e);
            $columns = array_keys($data);
        }

        $filtered = array_intersect_key($data, array_flip($columns));

        try {
            DB::transaction(function () use ($table, $filtered, $eliminado) {
                DB::table($table)->insert($filtered);
                // Si insert fue ok, eliminar registro de eliminados
                $eliminado->delete();
            });

            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }
}
