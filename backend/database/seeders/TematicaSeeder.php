<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TematicaSeeder extends Seeder
{
    public function run()
    {
        DB::table('tematicas')->insert([
            ['nombre' => 'Politica'],
            ['nombre' => 'Feminismo'],
            ['nombre' => 'Sociedad'],
            ['nombre' => 'Infantil'],
            ['nombre' => 'LGBT+'],
        ]);
    }
}
    