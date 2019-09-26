<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechasSaldosInvMantenimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechas_saldos_inv_mantenimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('id_calendario')->unsigned();
            $table->foreign('id_calendario')->references('id')->on('calendario');
            $table->integer('year');
            $table->integer('mes');
            $table->integer('dia');
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
        Schema::drop('fechas_saldos_inv_mantenimiento');
    }
}
