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
        Schema::create('reserva', function (Blueprint $table) {
            $table->increments('id_reserva');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->integer('precio_acordado')->nullable();
            $table->integer('id_cliente')->nullable()->index('idx_reserva_cliente');
            $table->integer('id_vehiculo')->nullable()->index('idx_reserva_vehiculo');
            $table->integer('id_seccion')->nullable()->index('idx_reserva_seccion');
            $table->integer('id_oferta')->nullable()->index('idx_reserva_oferta');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
