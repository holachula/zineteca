<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComicSeeder extends Seeder
{
    public function run()
    {
        // Insert comics
        DB::table('comics')->insert([
            [
                'titulo' => 'El Viaje Cósmico',
                'descripcion' => 'Aventura espacial independiente.',
                'autor_id' => 1,
                'portada' => null,
                'anio' => 2022
            ],
            [
                'titulo' => 'Risas Urbanas',
                'descripcion' => 'Cómic humorístico sobre la vida en la ciudad.',
                'autor_id' => 2,
                'portada' => null,
                'anio' => 2022
            ],
            [
                'titulo' => 'Historias del Sur',
                'descripcion' => 'Cuentos gráficos tradicionales del sur.',
                'autor_id' => 3,
                'portada' => null,
                'anio' => 2022
            ],
        ]);

        // Relacionar géneros
        DB::table('comic_genero')->insert([
            ['comic_id' => 1, 'genero_id' => 3], // ciencia ficción
            ['comic_id' => 2, 'genero_id' => 2], // humor
            ['comic_id' => 3, 'genero_id' => 5], // drama
        ]);

        // Relacionar temáticas
        DB::table('comic_tematica')->insert([
            ['comic_id' => 1, 'tematica_id' => 3], // sociedad
            ['comic_id' => 2, 'tematica_id' => 4], // infantil
            ['comic_id' => 3, 'tematica_id' => 1], // política
        ]);
    }
}
