<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIvaMedicamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iva_medicamentos', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('medicamento_id')->unsigned();
            $table->foreign('medicamento_id')->references('id')->on('medicamentos');
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
        Schema::drop('iva_medicamentos');
    }
}
