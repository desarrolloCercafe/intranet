<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrecebo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_precebo', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->date('fecha_destete');
            $table->date('fecha_traslado');
            $table->string('semana_destete');
            $table->string('semana_traslado');
            $table->string('año_destete'); 
            $table->string('año_traslado');
            $table->string('mes_traslado');
            $table->string('numero_inicial');
            $table->string('edad_destete');
            $table->string('edad_inicial_total');
            $table->string('dias_jaulon');
            $table->string('dias_totales_permanencia');
            $table->string('edad_final');
            $table->string('edad_final_ajustada');
            $table->string('peso_esperado');
            $table->string('numero_muertes');
            $table->string('numero_descartes');
            $table->string('numero_livianos');
            $table->string('numero_final');
            $table->string('porciento_mortalidad');
            $table->string('porciento_descartes');
            $table->string('porciento_livianos');
            $table->string('peso_ini');
            $table->string('peso_promedio_ini');
            $table->string('peso_ponderado_ini');
            $table->string('peso_fin');
            $table->string('peso_promedio_fin');
            $table->string('peso_ponderado_fin');
            $table->string('ind_peso_final');
            $table->string('cons_total');
            $table->string('cons_promedio');
            $table->string('cons_ponderado');
            $table->string('cons_promedio_dia');
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
        Schema::drop('formulario_precebo');
    }
}
