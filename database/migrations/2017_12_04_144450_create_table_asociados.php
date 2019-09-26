<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAsociados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associates', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('nombre_asociado', 80);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('documento', 20);
            $table->string('telefono', 20);
            $table->date('fecha_nacimiento');
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
        Schema::drop('associates');
    }
}
