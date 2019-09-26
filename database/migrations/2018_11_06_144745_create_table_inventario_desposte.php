<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventarioDesposte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_desposte', function(Blueprint $table){
            $table->increments('id');
            $table->string('codigo');
            $table->string('descripcion', 100);
            $table->double('kilos');
            $table->string('unidad');
            $table->double('costo_unitario');
            $table->double('costo_toal');
            $table->datetime('fecha');
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
        Schema::drop('inventario_desposte');
    }
}
