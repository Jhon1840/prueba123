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
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->integer('id_vehiculo')->index('idx_vehiculo_id');
            $table->text('imagen_vehiculo')->nullable();
            $table->string('marca')->nullable();
            $table->string('matricula')->nullable();
            $table->string('color')->nullable();
            $table->string('altura')->nullable();
            $table->string('ancho')->nullable();
            $table->string('largo')->nullable();
            $table->string('Modelo')->nullable();
            $table->integer('id_usuario')->nullable()->index('idx_vehiculo_usuario');

            $table->primary(['id_vehiculo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
