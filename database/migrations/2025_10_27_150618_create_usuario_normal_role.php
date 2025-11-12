<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Crear rol de Usuario Normal con permisos para gestionar datos del sistema
        DB::table('roles')->insert([
            'nombre' => 'Usuario Normal',
            'permisos' => json_encode([
                'crear_usuarios' => false,
                'crear_administradores' => false,
                'eliminar_datos' => false,
                'ver_reportes' => true,
                'gestionar_roles' => false,
                'crear_organismos' => true,
                'crear_unidades' => true,
                'crear_dependencias' => true,
                'crear_bienes' => true,
                'crear_movimientos' => true,
                'crear_responsables' => true,
            ]),
        ]);
    }

    public function down(): void
    {
        DB::table('roles')->where('nombre', 'Usuario Normal')->delete();
    }
};
