<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableConcecutivoPedidosConcentrados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consecutivos_concentrados', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('consecutivo');
            $table->date('fecha_creacion');
            $table->date('fecha_estimada');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->string('fecha_entrega');
            $table->string('hora_entrega'); 
            $table->string('conductor_asignado'); 
            $table->string('vehiculo_asignado');

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
        Schema::drop('consecutivos_concentrados');
    }
}
