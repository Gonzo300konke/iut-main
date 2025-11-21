<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganismoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organismos')->insert([
            'codigo' => 'MPPEU-001',
            'nombre' => 'MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN UNIVERSITARIA',
        ]);

    }
}

