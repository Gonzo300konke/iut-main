<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResponsableSeeder extends Seeder
{
    public function run(): void
    {
        $primario = DB::table('tipos_responsables')->where('nombre', 'Responsable Patrimonial Primario')->first();
        $uso      = DB::table('tipos_responsables')->where('nombre', 'Responsable Patrimonial por Uso')->first();

        DB::table('responsables')->updateOrInsert(
            ['cedula' => '3873777'],
            [
                'tipo_id' => $primario->id,
                'nombre' => 'ENRY GÓMEZ MAIZ',
                'correo' => 'enry.gomez@pai.gob.ve',
                'telefono' => '0412-1234567',
            ]
        );

        DB::table('responsables')->updateOrInsert(
            ['cedula' => '20000001'],
            [
                'tipo_id' => $uso->id,
                'nombre' => 'MARÍA PÉREZ',
                'correo' => 'maria.perez@pai.gob.ve',
                'telefono' => '0412-7654321',
            ]
        );
    }
}

