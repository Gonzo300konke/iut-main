<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Reasignar usuarios que tengan el rol 'Gerente de Bienes' al rol 'Usuario Normal'
        $usuarioNormalId = DB::table('roles')->where('nombre', 'Usuario Normal')->value('id');

        // Si no existe 'Usuario Normal' (caso raro), crear el rol y tomar su id
        if (! $usuarioNormalId) {
            $usuarioNormalId = DB::table('roles')->insertGetId([
                'nombre' => 'Usuario Normal',
                'permisos' => json_encode([]),
            ]);
        }

        $gerenteId = DB::table('roles')->where('nombre', 'Gerente de Bienes')->value('id');

        if ($gerenteId) {
            // Reasignar usuarios con el rol obsoleto
            DB::table('usuarios')->where('rol_id', $gerenteId)->update(['rol_id' => $usuarioNormalId]);

            // Eliminar el rol obsoleto
            DB::table('roles')->where('id', $gerenteId)->delete();
        }
    }

    public function down(): void
    {
        // Restaurar el rol en caso de rollback (sin permisos por defecto)
        DB::table('roles')->insert([
            'nombre' => 'Gerente de Bienes',
            'permisos' => json_encode([]),
        ]);
    }
};
