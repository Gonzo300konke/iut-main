<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoResponsableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_responsables')->updateOrInsert(
            ['nombre' => 'Responsable Patrimonial Primario'],
            ['descripcion' => 'Supervisa el inventario completo']
        );

        DB::table('tipos_responsables')->updateOrInsert(
            ['nombre' => 'Responsable Patrimonial por Uso'],
            ['descripcion' => 'Cuida bienes específicos asignados']
        );
    }
}

