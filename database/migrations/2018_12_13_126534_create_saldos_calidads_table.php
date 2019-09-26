<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldosCalidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldos_calidad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos_calidad');
            $table->string('descripcion');
            $table->string('cantidad');
            $table->string('unidad');
            $table->string('costo_unitario');
            $table->string('total');
            $table->date('fecha');
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
        Schema::drop('saldos_calidad');
    }
}
