<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableAsociacionGranjas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granjas_asociadas', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('granjas_asociadas');
    }
}
