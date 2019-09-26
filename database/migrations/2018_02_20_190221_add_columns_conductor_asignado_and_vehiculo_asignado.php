<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsConductorAsignadoAndVehiculoAsignado extends Migration
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
            $table->string('conductor_asignado')->after('total_kilogramos')->nullable(); 
            $table->string('vehiculo_asignado')->after('conductor_asignado')->nullable();       
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
