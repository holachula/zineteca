<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('comics', function (Blueprint $table) {
        $table->string('slug')->after('titulo');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('comics', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}
};
