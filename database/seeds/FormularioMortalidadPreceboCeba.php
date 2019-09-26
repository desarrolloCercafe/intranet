<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str as Str;

class FormularioMortalidadPreceboCebaSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
        for($i = 0; $i<30; $i++){
 
            \DB::table('formulario_mortalidad_precebo_ceba')->insert(array(
                'granja_id'  => $faker->nombre_granja,
                'lote'         => $faker->lote,
                'fecha'     => $faker->formatDates(true,'Y-m-d'),
                'dia_muerte'     => $faker->dia_muerte,
                'año_muerte'     => $faker->año_muerte,
                'mes_muerte'     => $faker->mes_muerte,
                'semana_muerte'     => $faker->semana_muerte,
                'edad_cerdo'     => $faker->edad_cerdo,
                'causa_id'     => $faker->causa_id,
                'alimento_id'     => $faker->alimento_id,
            ));
        }
    }
}