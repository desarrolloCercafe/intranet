<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableConcentrados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concentrados', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('ref_concentrado');
            $table->string('nombre_concentrado');
            $table->string('tipo_concentrado');
            $table->integer('precio');    
            $table->integer('kg');      
            $table->string('unidad_medida');   
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
