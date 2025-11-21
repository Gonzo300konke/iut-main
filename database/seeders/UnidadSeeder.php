<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadSeeder extends Seeder
{
    public function run(): void
    {
        $organismo = DB::table('organismos')->first();

        // Unidad principal con código específico
        DB::table('unidades_administradoras')->updateOrInsert(
            ['organismo_id' => $organismo->id, 'codigo' => '1430'],
            ['nombre' => 'UPTOS "CLODOSBALDO RUSSIAN"']
        );

        // Otras 4 unidades de prueba con códigos distintos
        for ($i = 2; $i <= 5; $i++) {
            DB::table('unidades_administradoras')->updateOrInsert(
                ['organismo_id' => $organismo->id, 'codigo' => 'U' . str_pad($i, 4, '0', STR_PAD_LEFT)],
                ['nombre' => "Unidad Administradora $i"]
            );
        }
    }
}


