<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIvaInsumos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iva_insumos', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('insumo_id')->unsigned();
            $table->foreign('insumo_id')->references('id')->on('insumos_servicios');
            $table->integer('iva_id')->unsigned();
            $table->foreign('iva_id')->references('id')->on('iva');
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
