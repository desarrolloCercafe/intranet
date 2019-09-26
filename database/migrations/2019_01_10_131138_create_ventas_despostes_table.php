<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasDespostesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_desposte', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('producto');
            $table->string('cantidad');
            $table->string('precio_total');
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
        Schema::drop('ventas_desposte');
    }
}
