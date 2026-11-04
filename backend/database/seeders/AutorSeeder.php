<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Autor;

class AutorSeeder extends Seeder
{
    public function run()
    {
        Autor::create([
            'nombre' => 'Trazo podrido',
            'estado' => 'CDMX'
        ]);

        Autor::create([
            'nombre' => 'Ana García',
            'estado' => 'Jalisco'
        ]);

        Autor::create([
            'nombre' => 'Luis Martínez',
            'estado' => 'Oaxaca'
        ]);

        Autor::create([
            'nombre' => 'María Pérez',
            'estado' => 'Nuevo León'
        ]);
    }
}