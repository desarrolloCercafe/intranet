<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIvaConcentrados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iva_concentrados', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('concentrado_id')->unsigned();
            $table->foreign('concentrado_id')->references('id')->on('concentrados');
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
        Schema::drop('iva_concentrados');
    }
}
