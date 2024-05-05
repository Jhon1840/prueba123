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
        Schema::create('garaje', function (Blueprint $table) {
            $table->increments('id_garaje');
            $table->text('imagen_garaje')->nullable();
            $table->float('ancho')->nullable();
            $table->float('largo')->nullable();
            $table->text('direccion')->nullable();
            $table->text('notas')->nullable();
            $table->text('referencias')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->integer('id_usuario')->nullable()->index('idx_garaje_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garaje');
    }
};
