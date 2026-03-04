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
