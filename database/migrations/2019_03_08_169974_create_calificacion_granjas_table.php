<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionGranjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacion_granjas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subproceso');
            $table->string('suma_indicador_subproceso');
            $table->string('calificacion_subproceso');
            $table->integer('id_info_granja')->unsigned();
            $table->integer('id_proceso_macro')->unsigned();
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
        Schema::drop('calificacion_granjas');
    }
}
