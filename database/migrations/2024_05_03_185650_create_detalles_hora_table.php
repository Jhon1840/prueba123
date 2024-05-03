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
        Schema::create('detalles_hora', function (Blueprint $table) {
            $table->integer('id_seccion')->nullable()->index('idx_detalles_hora_seccion');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_final')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_hora');
    }
};
