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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id('id_vehiculo');
            $table->text('imagen_vehiculo')->nullable();
            $table->string('marca');
            $table->string('matricula');
            $table->string('color');
            $table->string('altura');
            $table->string('ancho');
            $table->string('largo');
            $table->string('modelo');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuarios');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
