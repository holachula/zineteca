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
                'titulo' => 'Bodrio 4',
                'slug' => 'bodrio-4',
                'descripcion' => 'Su revista de humor favorita que contiene toda la cochinada gráfica del trazo podrido.',
                'autor_id' => 1,
                'portada' => null,
                'anio' => 2022
            ],
            [
                'titulo' => 'Risas Urbanas',
                'slug' => 'el-viaje-cosmico',
                'descripcion' => 'Cómic humorístico sobre la vida en la ciudad.',
                'autor_id' => 2,
                'portada' => null,
                'anio' => 2022
            ],
            [
                'titulo' => 'Historias del Sur',
                'slug' => 'el-viaje-cosmico',
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
