<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorcentajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porcentajes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subproceso');
            $table->string('porc');
            $table->string('porc_value');
            $table->string('etapa');
            $table->integer('id_proceso_macro')->unsigned();
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
        Schema::drop('porcentajes');
    }
}
