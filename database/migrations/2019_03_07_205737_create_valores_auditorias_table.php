<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValoresAuditoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valores_auditorias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pregunta')->unsigned();
            $table->integer('id_proceso_macro')->unsigned();
            $table->integer('id_porcentaje_subproceso')->unsigned();
            $table->integer('id_info_granja')->unsigned();
            $table->string('calificacion');
            $table->string('indicador');
            $table->string('max');
            $table->string('diferencia');
            $table->string('promedio');
            $table->string('observacion');
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
        Schema::drop('valores_auditorias');
    }
}
