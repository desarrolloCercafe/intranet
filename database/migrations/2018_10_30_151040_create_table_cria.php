<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('cria', function (Blueprint $table) {

            $table->increments('id');
            $table->datetime('fecha_inicial');
            $table->integer('granja_id')->unsigned();
            $table->foreign('granja_id')->references('id')->on('granjas');
            $table->double('lech_destetados_hembra_servida_anno');
            $table->double('prom_total_nac_por_camada');
            $table->double('prom_nac_vivos_por_camada');
            $table->double('porc_lechones_nac_muertos');
            $table->double('porc_momificados');
            $table->double('tasa_partos');
            $table->double('porc_mortalidad_pre_destete');
            $table->double('pesos_de_camada_21');
            $table->timestamps();

       });
    }

    /**gu
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('cria');
    }
}
