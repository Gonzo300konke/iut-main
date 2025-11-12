<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarse de que existan los roles mínimos del sistema.
        // Usamos firstOrCreate para evitar duplicados si ya fueron creados por una migración.
        Rol::firstOrCreate(
            ['nombre' => 'Administrador'],
            ['permisos' => []]
        );

        Rol::firstOrCreate(
            ['nombre' => 'Usuario Normal'],
            ['permisos' => []]
        );
    }
}
