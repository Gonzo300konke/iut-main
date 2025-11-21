<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            UsuarioSeeder::class,
            OrganismoSeeder::class,
            UnidadSeeder::class,
            DependenciaSeeder::class,
            BienSeeder::class,
        ]);
    }
}

