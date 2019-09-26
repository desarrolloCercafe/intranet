<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGranjasAsociadaCiclosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granjas_asociada_ciclos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('granja');
            $table->string('tipo_ciclo');
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
        Schema::drop('granjas_asociada_ciclos');
    }
}
