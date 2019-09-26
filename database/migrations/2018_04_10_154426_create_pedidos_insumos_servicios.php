
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosInsumosServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_insumos_servicios', function (Blueprint $table) 
        { 
            $table->increments('id');
            $table->string('consecutivo_pedido');
            $table->date('fecha_pedido_insumo');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->integer('insumo_servicio_id')->unsigned();
            $table->foreign('insumo_servicio_id')->references('id')->on('insumos_servicios');
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
        Schema::drop('pedido_insumos_servicios');    
    }
}
