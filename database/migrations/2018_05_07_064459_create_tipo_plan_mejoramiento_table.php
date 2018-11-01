<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPlanMejoramientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_PlanMejoramiento', function (Blueprint $table) {
            $table->increments('PK_id');
            $table->text('recomendacion');
            $table->integer('umbral');
            $table->enum('estado', ['malo', 'regular','excelente']);
            $table->integer('FK_IndicadorId')->unsigned();
            $table->timestamps();

            $table->foreign('FK_IndicadorId')->references('PK_id')
            ->on('TBL_Indicadores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_PlanMejoramiento');
    }
}
