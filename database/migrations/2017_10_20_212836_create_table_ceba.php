<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCeba extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_ceba', function (Blueprint $table) 
        {
            $table->increments('id'); 
            $table->string('lote');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->date('fecha_ingreso_lote');
            $table->date('fecha_salida_lote');
            $table->string('año');
            $table->string('mes'); 
            $table->string('semana');
            $table->string('inic');
            $table->string('cerdos_descartados');
            $table->string('cerdos_livianos');
            $table->string('muertes');
            $table->string('cant_final_cerdos');
            $table->string('meta_cerdos');
            $table->string('edad_inicial');
            $table->string('edad_inicial_total');
            $table->string('dias');
            $table->string('dias_permanencia');
            $table->string('edad_final');
            $table->string('edad_final_total');
            $table->string('conf_edad_final');
            $table->string('por_mortalidad');
            $table->string('por_descartes');
            $table->string('por_livianos');
            $table->string('peso_total_ingresado');
            $table->string('peso_promedio_ingresado');
            $table->string('peso_total_vendido');
            $table->string('peso_promedio_vendido');
            $table->string('consumo_lote');
            $table->string('consumo_promedio_lote');
            $table->string('consumo_promedio_lote_dias'); 
            $table->string('cons_promedio_ini');
            $table->string('cons_ponderado_ini');
            $table->string('cons_promedio_dia_ini');
            $table->string('cons_ajustado_ini');
            $table->string('ato_promedio_ini');
            $table->string('ato_promedio_dia_ini');
            $table->string('conversion_ini');
            $table->string('conversion_ajust_ini');
            $table->string('cons_ajustado_fin');
            $table->string('ato_promedio_fin');
            $table->string('ato_promedio_dia_fin');
            $table->string('conversion_fin');
            $table->string('conversion_ajust_fin');
            $table->string('RUL');
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
        Schema::drop('formulario_ceba');
    }
}
