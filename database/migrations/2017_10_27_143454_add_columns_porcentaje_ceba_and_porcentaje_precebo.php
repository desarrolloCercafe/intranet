<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPorcentajeCebaAndPorcentajePrecebo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('granjas', function($table) 
        {
            $table->string('porcentaje_precebo')->after('numero_contacto_granja')->nullable();
            $table->string('porcentaje_ceba')->after('porcentaje_precebo')->nullable();
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
