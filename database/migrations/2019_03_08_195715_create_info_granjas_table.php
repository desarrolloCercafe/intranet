<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoGranjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_granjas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fecha');
            $table->string('granja');
            $table->string('asociado');
            $table->string('ubicacion');
            $table->string('altura_mar');
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
        Schema::drop('info_granjas');
    }
}
