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
        Schema::create('metricas', function (Blueprint $table) {
            $table->integer('id_usuario')->nullable()->index('idx_metricas_usuario');
            $table->integer('rechazos_cliente')->nullable();
            $table->integer('rechazos_ofertante')->nullable();
            $table->integer('aceptados_cliente')->nullable();
            $table->integer('rechazados_cliente')->nullable();
            $table->timestamp('fecha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metricas');
    }
};
