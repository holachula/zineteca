<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Agregar columna de rol
            $table->enum('role', ['admin', 'author'])
                ->default('author')
                ->after('password');

            // Relación con autores (si aplica)
            $table->unsignedBigInteger('autor_id')
                ->nullable()
                ->after('role');

            $table->foreign('autor_id')
                ->references('id')
                ->on('autores')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['autor_id']);
            $table->dropColumn(['autor_id', 'role']);
        });
    }
};
