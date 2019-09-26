<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePedidoMedicamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_medicamentos', function (Blueprint $table) 
        {  
            $table->increments('id');
            $table->string('consecutivo_pedido');
            $table->date('fecha_pedido');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->integer('medicamento_id')->unsigned();
            $table->foreign('medicamento_id')->references('id')->on('medicamentos');
            $table->integer('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->string('unidades');
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
        Schema::drop('pedido_medicamentos');
    }
}
