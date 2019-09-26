<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesComercio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_comercio', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agente',1000)->nullable();
            $table->string('medio')->nullable();
            $table->string('categoria')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('cedula')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->datetime('fecha_hora')->nullable();
            $table->string('motivo_descripcion')->nullable();
            $table->string('motivo_adicional')->nullable();
            $table->string('descripcion',1000)->nullable();
            $table->string('path')->nullable();
            $table->integer('estado_id')->nullable()->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->integer('emisario_id')->nullable()->unsigned();
            $table->foreign('emisario_id')->references('id')->on('users');
            $table->string('moderador')->nullable();
            $table->remembertoken();
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
        Schema::drop('solicitudes_comercio');
    }
}
