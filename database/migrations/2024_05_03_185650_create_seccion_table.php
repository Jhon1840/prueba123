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
        Schema::create('seccion', function (Blueprint $table) {
            $table->integer('id_seccion')->index('idx_seccion_id');
            $table->text('imagen_seccion')->nullable();
            $table->float('ancho')->nullable();
            $table->float('largo')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_final')->nullable();
            $table->string('estado')->nullable();
            $table->float('altura')->nullable();
            $table->integer('id_garaje')->nullable()->index('idx_seccion_garaje');

            $table->primary(['id_seccion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seccion');
    }
};
