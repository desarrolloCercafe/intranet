<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldosDesposteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldos_desposte', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('descripcion', 255);
            $table->double('cantidad');
            $table->double('costo_unitario');
            $table->double('costo_total');
            $table->datetime('fecha');
            $table->string('ventas_kg', 255);
            $table->string('ventas_valor', 255);
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
        Schema::drop('saldos_desposte');
    }
}
