<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePedidoConcentrados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_concentrados', function (Blueprint $table) 
        { 
            $table->increments('id');
            $table->string('consecutivo_pedido');
            $table->string('fecha_creacion');
            $table->string('fecha_entrega');
            $table->string('tipo_documento');
            $table->string('prefijo');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->integer('concentrado_id')->unsigned();
            $table->foreign('concentrado_id')->references('id')->on('concentrados');
            $table->integer('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->string('no_bultos');
            $table->string('no_kilos');
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
        Schema::drop('pedido_concentrados');
    }
}
