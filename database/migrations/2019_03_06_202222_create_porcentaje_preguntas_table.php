<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorcentajePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porcentaje_preguntas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pregunta')->unsigned();
            $table->integer('id_proceso_macro')->unsigned();
            $table->string('porc_pregunta');
            $table->string('porc_valor');
            $table->foreign('id_pregunta')->references('id')->on('preguntas');
            $table->foreign('id_proceso_macro')->references('id')->on('procesos_macros');
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
        Schema::drop('porcentaje_preguntas');
    }
}
