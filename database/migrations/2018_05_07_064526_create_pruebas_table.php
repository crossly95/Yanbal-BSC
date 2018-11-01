<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Pruebas', function (Blueprint $table) {
            $table->increments('PK_id');
            $table->text('respuestaUsuario');
            $table->integer('FK_UsuarioId')->unsigned();
            $table->integer('FK_PreguntaId')->unsigned();
            $table->timestamps();

            $table->foreign('FK_PreguntaId')->references('PK_id')
            ->on('TBL_Preguntas')->onDelete('cascade');

            $table->foreign('FK_UsuarioId')->references('PK_id')
            ->on('TBL_Usuarios')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_Pruebas');
    }
}
