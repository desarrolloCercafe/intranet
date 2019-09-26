<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableConcecutivoConcentrado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consecutivos_concentrados', function($table)
        {
            $table->string('total_bultos')->after('hora_entrega');   
            $table->string('total_kilogramos')->after('total_bultos');    
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
