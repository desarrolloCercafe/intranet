<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGranjas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('granjas', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('nombre_granja',  80);
            $table->string('descripcion_granja', 1000);
            $table->string('direccion_granja');
            $table->string('numero_contacto_granja');
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
        Schema::drop('granjas');
    }
}
