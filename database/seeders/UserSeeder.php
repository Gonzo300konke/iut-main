<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Usuario de Prueba',
            'email' => 'test@inventario.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
