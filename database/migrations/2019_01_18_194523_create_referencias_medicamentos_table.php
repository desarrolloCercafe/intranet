<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenciasMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referencias_medicamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referencia');
            $table->string('nombre');
            $table->string('tipo');
            $table->string('precio');
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
        Schema::drop('referencias_medicamentos');
    }
}
