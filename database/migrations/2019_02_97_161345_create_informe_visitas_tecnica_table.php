<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeVisitasTecnicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_visitas_tecnica', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('id_granja')->unsigned();
            $table->foreign('id_granja')->references('id')->on('granjas');
            $table->string('granja_nombre');
            $table->string('asociado');
            $table->string('lugar');
            $table->string('admin_granja');
            $table->string('tipo_produccion');
            $table->integer('id_fuente_agua')->unsigned();
            $table->foreign('id_fuente_agua')->references('id')->on('fuente_agua');
            $table->integer('id_suministro_agua')->unsigned();
            $table->foreign('id_suministro_agua')->references('id')->on('suministro_agua');
            $table->string('sitio_muestra_gestacion1');
            $table->string('medicion_accupoint_gestacion1');
            $table->string('sitio_muestra_gestacion2');
            $table->string('medicion_accupoint_gestacion2');
            $table->string('sitio_muestra_gestacion3');
            $table->string('medicion_accupoint_gestacion3');
            $table->string('sitio_muestra_maternidad1');
            $table->string('medicion_accupoint_maternidad1');
            $table->string('sitio_muestra_maternidad2');
            $table->string('medicion_accupoint_maternidad2');
            $table->string('sitio_muestra_maternidad3');
            $table->string('medicion_accupoint_maternidad3');
            $table->string('sitio_muestra_maternidad4');
            $table->string('medicion_accupoint_maternidad4');
            $table->longText('observacion');
            $table->longText('recomendaciones');
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
        Schema::drop('informe_visitas_tecnica');
    }
}
