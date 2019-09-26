<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInsumosYServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos_servicios', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('ref_insumo');
            $table->string('nombre_insumo');
            $table->string('tipo_insumo');
            $table->string('proveedor_1');
            $table->string('proveedor_2');
            $table->string('proveedor_3');
            $table->string('precio_insumo');
            $table->rememberToken();
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
