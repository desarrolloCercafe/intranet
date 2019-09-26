<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDesSemana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_destetos_semana', function (Blueprint $table) 
        {
            $table->increments('id'); 
            $table->integer('granja_cria_id')->unsigned();
            $table->foreign('granja_cria_id')->references('id')->on('granjas');
            $table->string('lote');
            $table->string('año_destete');
            $table->string('semana_destete');
            $table->string('numero_destetos');
            $table->string('mortalidad_precebo');
            $table->string('traslado_a_ceba');
            $table->string('cantidad_a_ceba');
            $table->string('mortalidad_ceba');
            $table->string('semana_venta');
            $table->string('año_venta');
            $table->string('disponibilidad_venta');
            $table->string('kilos_venta');
            $table->string('semana_1_fase_1');
            $table->string('consumo_semana_1_fase_1');
            $table->string('semana_2_fase_1');
            $table->string('consumo_semana_2_fase_1');
            $table->string('semana_1_fase_2');
            $table->string('consumo_semana_1_fase_2');
            $table->string('semana_2_fase_2');
            $table->string('consumo_semana_2_fase_2');
            $table->string('semana_1_fase_3');
            $table->string('consumo_semana_1_fase_3');
            $table->string('semana_2_fase_3');
            $table->string('consumo_semana_2_fase_3');
            $table->string('semana_3_fase_3');
            $table->string('consumo_semana_3_fase_3');
            $table->string('semana_1_iniciacion');
            $table->string('consumo_semana_1_iniciacion');
            $table->string('semana_2_iniciacion');
            $table->string('consumo_semana_2_iniciacion');
            $table->string('semana_1_levante');
            $table->string('consumo_semana_1_levante');
            $table->string('semana_2_levante');
            $table->string('consumo_semana_2_levante');
            $table->string('semana_3_levante');
            $table->string('consumo_semana_3_levante');
            $table->string('semana_4_levante');
            $table->string('consumo_semana_4_levante');
            $table->string('semana_1_engorde_1');
            $table->string('consumo_semana_1_engorde_1');
            $table->string('semana_2_engorde_1');
            $table->string('consumo_semana_2_engorde_1');
            $table->string('semana_1_engorde_2');
            $table->string('consumo_semana_1_engorde_2');
            $table->string('semana_2_engorde_2');
            $table->string('consumo_semana_2_engorde_2');
            $table->string('semana_3_engorde_2');
            $table->string('consumo_semana_3_engorde_2');
            $table->string('semana_4_engorde_2');
            $table->string('consumo_semana_4_engorde_2');
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
        Schema::drop('formulario_destetos_semana');
    }
}
