<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
        {
            Schema::create('comic_paginas', function (Blueprint $table) {
                $table->id();

                $table->foreignId('comic_id')
                    ->constrained('comics')
                    ->onDelete('cascade');

                $table->string('imagen'); // path storage, ruta de la imagen
                $table->integer('orden'); // número de página orden vertical

                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comic_paginas');
    }
};


// DB::table('comic_paginas')->insert([
//     [
//         'comic_id' => 2,
//         'imagen' => 'comics/2/paginas/01.jpg',
//         'orden' => 1,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ],
//     [
//         'comic_id' => 2,
//         'imagen' => 'comics/2/paginas/02.jpg',
//         'orden' => 2,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ],
//     [
//         'comic_id' => 2,
//         'imagen' => 'comics/2/paginas/03.jpg',
//         'orden' => 3,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ],
//     [
//         'comic_id' => 2,
//         'imagen' => 'comics/2/paginas/04.jpg',
//         'orden' => 4,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ],
//     [
//         'comic_id' => 2,
//         'imagen' => 'comics/2/paginas/05.jpg',
//         'orden' => 5,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ],
// ]);