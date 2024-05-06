<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->id('id_rating');
            $table->integer('puntaje')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->unsignedBigInteger('id_usuario_calificador')->nullable();
            $table->unsignedBigInteger('id_usuario_calificado')->nullable();
            $table->unsignedBigInteger('id_seccion_calificada')->nullable();
            $table->timestamps();

            $table->foreign('id_usuario_calificador')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_usuario_calificado')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_seccion_calificada')->references('id_seccion')->on('seccion')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating');
    }
}
