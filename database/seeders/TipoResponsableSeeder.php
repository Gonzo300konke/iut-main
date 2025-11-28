<?php

// database/seeders/TipoResponsableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoResponsable;

class TipoResponsableSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Obrero', 'Docente', 'Administrativo'];

        foreach ($tipos as $nombre) {
            TipoResponsable::firstOrCreate(['nombre' => $nombre]);
        }
    }
}


