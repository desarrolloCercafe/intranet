<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConceptosNomina extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos_nomina', function(Blueprint $table){
            $table->increments('id');
            $table->string('concepto');
            $table->string('descripcion', 100);
            $table->string('titulo');
            $table->string('tipo');
            $table->string('cantidad');
            $table->string('valor');
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
        Schema::drop('conceptos_nomina');
    }
}
