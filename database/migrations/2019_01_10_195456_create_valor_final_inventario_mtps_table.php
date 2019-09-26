<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValorFinalInventarioMtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valor_final_inv_mtp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referencia');
            $table->string('tipo_producto');
            $table->string('producto');
            $table->string('costo');
            $table->string('mes');
            $table->string('fecha');
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
        Schema::drop('valor_final_inv_mtp');
    }
}
