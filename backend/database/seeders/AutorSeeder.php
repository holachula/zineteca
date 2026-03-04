<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutorSeeder extends Seeder
{
    public function run()
    {
        DB::table('autores')->insert([
            ['nombre' => 'José Hernández', 'estado' => 'CDMX'],
            ['nombre' => 'Ana García', 'estado' => 'Jalisco'],
            ['nombre' => 'Luis Martínez', 'estado' => 'Oaxaca'],
            ['nombre' => 'María Pérez', 'estado' => 'Nuevo León'],
        ]);
    }
}
