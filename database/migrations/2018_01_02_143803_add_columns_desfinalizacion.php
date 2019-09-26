<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsDesfinalizacion extends Migration
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
            $table->string('cons_promedio_ini')->after('consumo_promedio_lote_dias')->nullable();
            $table->string('cons_promedio_dia_ini')->after('cons_promedio_ini')->nullable();
            $table->string('ato_promedio')->after('cons_promedio_dia_ini')->nullable();     
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
