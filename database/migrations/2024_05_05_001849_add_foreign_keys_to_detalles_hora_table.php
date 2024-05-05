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
        Schema::table('detalles_hora', function (Blueprint $table) {
            $table->foreign(['id_seccion'], 'detalles_hora_ibfk_1')->references(['id_seccion'])->on('seccion')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_hora', function (Blueprint $table) {
            $table->dropForeign('detalles_hora_ibfk_1');
        });
    }
};
