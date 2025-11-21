<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DependenciaSeeder extends Seeder
{
    public function run(): void
    {
        $unidades = DB::table('unidades_administradoras')->get();
        // Tomamos un responsable externo (traído del PAI)
        $responsable = DB::table('responsables')->first();

        foreach ($unidades as $unidad) {
            // Dependencia principal con código 0
            DB::table('dependencias')->updateOrInsert(
                ['unidad_administradora_id' => $unidad->id, 'codigo' => '0'],
                [
                    'nombre' => 'DEPENDENCIA USUARIA',
                    'responsable_id' => $responsable?->id, // asignar responsable externo
                ]
            );

            // Segunda dependencia
            DB::table('dependencias')->updateOrInsert(
                ['unidad_administradora_id' => $unidad->id, 'codigo' => '1'],
                [
                    'nombre' => "Dependencia Auxiliar de {$unidad->nombre}",
                    'responsable_id' => $responsable?->id,
                ]
            );
        }
    }
}


