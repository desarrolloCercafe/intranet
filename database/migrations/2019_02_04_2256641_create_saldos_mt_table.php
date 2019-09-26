<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldosMTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldos_mt', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('descripcion', 255);
            $table->double('cantidad');
            $table->double('costo_unitario');
            $table->double('costo_total');
            $table->datetime('fecha');
            $table->string('mv_mensual', 255);
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
        Schema::drop('saldos_mt');
    }
}
