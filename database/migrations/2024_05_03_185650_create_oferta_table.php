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
        Schema::create('oferta', function (Blueprint $table) {
            $table->integer('id_oferta')->index('idx_oferta_id');
            $table->time('hora_inicio')->nullable();
            $table->binary('tipo_oferta')->nullable();
            $table->time('hora_final')->nullable();
            $table->integer('precio_estimado')->nullable();
            $table->date('fecha')->nullable();
            $table->string('estado')->nullable();
            $table->integer('id_seccion')->nullable()->index('idx_oferta_seccion');

            $table->primary(['id_oferta']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta');
    }
};
