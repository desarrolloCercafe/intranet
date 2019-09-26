<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('year');
            $table->integer('trimestre');
            $table->integer('mes_year');
            $table->integer('dia_mes');
            $table->integer('fecha_entero');
            $table->string('nombre_mes');
            $table->string('mes_calendario');
            $table->string('trimestre_calendario');
            $table->integer('dia_semana');
            $table->string('dia_semana_nombre');
            $table->string('fin_de_semana');
            $table->integer('numero_semana');
            $table->integer('mes_year_entero');
            $table->integer('trimestre_year_entero');
            $table->integer('year_shor');
            $table->string('fy');
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
        Schema::drop('calendario');
    }
}
