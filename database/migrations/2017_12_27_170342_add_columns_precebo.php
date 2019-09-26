<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPrecebo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulario_precebo', function($table) 
        {
            $table->string('cons_promedio_ini')->after('cons_promedio_dia')->nullable();
            $table->string('cons_ponderado_ini')->after('cons_promedio_ini')->nullable();
            $table->string('cons_promedio_dia_ini')->after('cons_ponderado_ini')->nullable();
            $table->string('cons_ajustado_ini')->after('cons_promedio_dia_ini')->nullable();
            $table->string('ato_promedio_ini')->after('cons_ajustado_ini')->nullable();
            $table->string('ato_promedio_dia_ini')->after('ato_promedio_ini')->nullable();
            $table->string('conversion_ini')->after('ato_promedio_dia_ini')->nullable();
            $table->string('conversion_ajust_ini')->after('conversion_ini')->nullable();
            $table->string('cons_ajustado_fin')->after('conversion_ajust_ini')->nullable();
            $table->string('ato_promedio_fin')->after('cons_ajustado_fin')->nullable();
            $table->string('ato_promedio_dia_fin')->after('ato_promedio_fin')->nullable();
            $table->string('conversion_fin')->after('ato_promedio_dia_fin')->nullable();
            $table->string('conversion_ajust_fin')->after('conversion_fin')->nullable();
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
