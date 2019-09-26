<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistenciaMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('existencia_medicamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_producto');
            $table->string('descripcion');
            $table->string('cantidad');
            $table->integer('medicamento_id')->unsigned();
            $table->foreign('medicamento_id')->references('id')->on('medicamentos');
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
        Schema::drop('existencia_medicamentos');
    }
}
