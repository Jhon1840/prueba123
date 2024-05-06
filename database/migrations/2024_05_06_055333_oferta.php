<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta', function (Blueprint $table) {
            $table->id('id_oferta');
            $table->time('hora_inicio')->nullable();
            $table->text('tipo_oferta')->nullable();
            $table->time('hora_final')->nullable();
            $table->integer('precio_estimado')->nullable();
            $table->date('fecha')->nullable();
            $table->string('estado')->nullable()->collation('utf8mb4_unicode_ci');
            $table->unsignedBigInteger('id_seccion')->nullable();
            $table->timestamps();

            $table->foreign('id_seccion')->references('id_seccion')->on('seccion')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oferta');
    }
}
