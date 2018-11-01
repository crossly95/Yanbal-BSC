<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoIndicadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Indicadores', function (Blueprint $table) {
            $table->increments('PK_id');
            $table->string('nombreIndicador');
            $table->enum('limite', ['mayor', 'menor']);
            $table->enum('tipo', ['cuantitativo', 'cualitativo']);
            $table->integer('metaIndicador');
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
        Schema::dropIfExists('TBL_Indicadores');
    }
}
