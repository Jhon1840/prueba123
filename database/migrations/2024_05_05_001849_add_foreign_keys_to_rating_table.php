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
        Schema::table('rating', function (Blueprint $table) {
            $table->foreign(['id_usuario_calificador'], 'rating_ibfk_1')->references(['id_usuario'])->on('usuario')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario_calificado'], 'rating_ibfk_2')->references(['id_usuario'])->on('usuario')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_seccion_calificada'], 'rating_ibfk_3')->references(['id_seccion'])->on('seccion')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rating', function (Blueprint $table) {
            $table->dropForeign('rating_ibfk_1');
            $table->dropForeign('rating_ibfk_2');
            $table->dropForeign('rating_ibfk_3');
        });
    }
};
