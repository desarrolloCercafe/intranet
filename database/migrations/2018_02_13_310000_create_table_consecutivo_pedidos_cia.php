<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConsecutivoPedidosCia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consecutivos_productos_cia', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('consecutivo');
            $table->date('fecha_creacion');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->integer('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados');
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
