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
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('anio')->nullable();
            $table->string('portada')->nullable(); // URL o path local
            $table->foreignId('autor_id')->constrained('autores')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};


// DB::table('comics')->insert([
//     'titulo' => 'Aventuras Incompletas de niñx con sombrero',
//     'slug' => 'aventuras-incompletas-de-ninx-con-sombrero',
//     'descripcion' => 'Soy la descripción de Aventuras Incompletas de niñx con sombrero',
//     'anio' => 2025,
//     'portada' => 'comics/2/portada.jpg',
//     'autor_id' => 2,
//     'created_at' => now(),
//     'updated_at' => now()
// ]);