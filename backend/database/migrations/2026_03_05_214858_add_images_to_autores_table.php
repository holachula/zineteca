<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Agregar imágenes a la tabla autores
|--------------------------------------------------------------------------
|
| Esta migración agrega dos campos nuevos:
|
| foto_perfil → imagen tipo avatar del autor
| imagen_lateral → imagen ilustrativa (personaje completo)
|
| Se guardará solamente la ruta del archivo.
|
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('autores', function (Blueprint $table) {

            // Imagen tipo avatar
            $table->string('foto_perfil')->nullable()->after('bio');

            // Imagen ilustración lateral
            $table->string('imagen_lateral')->nullable()->after('foto_perfil');

        });
    }

    public function down(): void
    {
        Schema::table('autores', function (Blueprint $table) {

            // elimina columnas si se revierte migración
            $table->dropColumn(['foto_perfil', 'imagen_lateral']);

        });
    }
};