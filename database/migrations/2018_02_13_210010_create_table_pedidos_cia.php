<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePedidosCia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_cia', function (Blueprint $table) 
        { 
            $table->increments('id');
            $table->string('consecutivo_pedido');
            $table->date('fecha_pedido');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->integer('producto_cia_id')->unsigned();
            $table->foreign('producto_cia_id')->references('id')->on('productos_cia');
            $table->integer('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->string('dosis');
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
        //
    }
}
