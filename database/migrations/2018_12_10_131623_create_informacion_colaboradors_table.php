<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacionColaboradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_colaboradores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado');
            $table->string('cedula');
            $table->string('nombre');
            $table->date('fecha_ingreso');
            $table->string('fondo_pensiones');
            $table->string('nombre_de_fondo_de_pensiones');
            $table->string('eps');
            $table->string('nombre_de_eps');
            $table->string('caja_compensacion');
            $table->string('nombre_de_caja_compensacion');
            $table->string('descripcion_cargo');
            $table->string('descripcion_centro_costo');
            $table->string('comisiones');
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
        Schema::drop('informacion_colaboradors');
    }
}
