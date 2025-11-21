<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BienSeeder extends Seeder
{
    public function run(): void
    {
        $dependencias = DB::table('dependencias')->get();

        foreach ($dependencias as $dep) {
            for ($i = 1; $i <= 10; $i++) {
                DB::table('bienes')->insert([
                    'dependencia_id' => $dep->id,
                    'codigo' => "B{$dep->codigo}-{$dep->id}-".str_pad((string)$i, 3, '0', STR_PAD_LEFT),
                    'descripcion' => "Bien $i de la dependencia {$dep->nombre}",
                    'precio' => mt_rand(50000, 500000) / 100, // 500.00 a 5000.00
                    'ubicacion' => "Depósito {$dep->nombre}",
                    'estado' => 'ACTIVO',
                    'fotografia' => null, // o Storage::url(...) si ya manejas archivos
                    'fecha_registro' => now(),
                ]);
            }
        }
    }
}

