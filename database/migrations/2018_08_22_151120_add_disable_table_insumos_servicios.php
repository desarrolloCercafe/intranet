<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisableTableInsumosServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insumos_servicios', function($table) 
        {
            $table->boolean('disable')->after('tipo_insumo');
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
