<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMedicamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamentos', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('ref_medicamento');
            $table->string('nombre_medicamento');
            $table->string('tipo_medicamento');
            $table->string('proveedor_1');
            $table->string('proveedor_2');
            $table->string('proveedor_3');
            $table->string('proveedor_4');
            $table->string('precio_medicamento');
            $table->rememberToken();
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
        //
    }
}
