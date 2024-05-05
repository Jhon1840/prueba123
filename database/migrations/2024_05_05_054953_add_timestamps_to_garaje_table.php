<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToGarajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garaje', function (Blueprint $table) {
            // Añadir las columnas de timestamps si no existen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garaje', function (Blueprint $table) {
            // Remover las columnas de timestamps si se hace un rollback
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}
