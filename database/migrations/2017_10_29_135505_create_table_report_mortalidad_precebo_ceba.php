<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReportMortalidadPreceboCeba extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_mortalidad_precebo_ceba', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->string('lote');
            $table->string('sala');
            $table->string('numero_cerdos');
            $table->string('sexo_cerdo');
            $table->string('peso_cerdo');
            $table->date('fecha');
            $table->string('dia_muerte');
            $table->string('año_muerte');
            $table->string('mes_muerte');
            $table->string('semana_muerte');
            $table->string('edad_cerdo');
            $table->integer('causa_id')->unsigned();
            $table->foreign('causa_id')->references('id')->on('causas_muerte');
            $table->integer('alimento_id')->unsigned();
            $table->foreign('alimento_id')->references('id')->on('alimentos');
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
        Schema::drop('formulario_mortalidad_precebo_ceba');
    }
}
