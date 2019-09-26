<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTabDesteteF extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulario_destete_finalizacion', function($table)
        {
            $table->string('ato_promedio_dia')->after('ato_promedio')->nullable(); 
            $table->string('conversion')->after('ato_promedio_dia')->nullable();     
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
