<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str as Str;


class FormularioDestetosSemanaSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
        for($i = 0; $i<30; $i++){
 
            \DB::table('formulario_destetos_semana')->insert(array(
                'granja_cria_id'  => $faker->nombre_granja,
                'lote'         => $faker->lote,
                'año_destete'     => $faker->año_destete,
                'semana_destete'     => $faker->semana_destete,
                'numero_destetos'     => $faker->numero_destetos,
                'mortalidad_precebo'     => $faker->mortalidad_precebo ,
                'traslado_a_ceba'     => $faker->traslado_a_ceba,
                'cantidad_a_ceba'     => $faker->cantidad_a_ceba,
                'mortalidad_ceba'     =>$faker->mortalidad_ceba,
                'semana_venta'     => $faker->semana_venta,
                'año_venta'     => $faker->año_venta,
               	'disponibilidad_venta'     => $faker->disponibilidad_venta,
               	'kilos_venta'     => $faker->kilos_venta,
               	'semana_1_fase_1'     => $faker->semana_1_fase_1,
               	'consumo_semana_1_fase_1'     => $faker->consumo_semana_1_fase_1,
               	'semana_2_fase_1'     => $faker->semana_2_fase_1,
               	'consumo_semana_2_fase_1'     => $faker->consumo_semana_2_fase_1,
               	'semana_1_fase_2'     => $faker->semana_1_fase_2,
               	'consumo_semana_1_fase_2'     => $faker->consumo_semana_1_fase_2,
               	'semana_2_fase_2'     => $faker->semana_2_fase_2,
               	'consumo_semana_2_fase_2'     => $faker->consumo_semana_2_fase_2,
               	'semana_1_fase_3'     => $faker->semana_1_fase_3,
               	'consumo_semana_1_fase_3'     => $faker->consumo_semana_1_fase_3,
               	'semana_2_fase_3'     => $faker->semana_2_fase_3,
               	'consumo_semana_2_fase_3'     => $faker->consumo_semana_2_fase_3,
               	'semana_3_fase_3'     => $faker->semana_3_fase_3,
               	'consumo_semana_3_fase_3'     => $faker->consumo_semana_3_fase_3,
                'semana_1_iniciacion'     => $faker->semana_1_iniciacion,
                'consumo_semana_1_iniciacion'     => $faker->consumo_semana_1_iniciacion,
                'semana_2_iniciacion'     => $faker->semana_2_iniciacion,
                'consumo_semana_2_iniciacion'     => $faker->consumo_semana_2_iniciacion,
                'semana_1_levante'     => $faker->semana_1_levante,
                'consumo_semana_1_levante'     => $faker->consumo_semana_1_levante,
                'semana_2_levante'     => $faker->semana_2_levante,
                'consumo_semana_2_levante'     => $faker->consumo_semana_2_levante,
                'semana_3_levante'     => $faker->semana_3_levante,
                'consumo_semana_3_levante'     => $faker->consumo_semana_3_levante,
                'semana_4_levante'     => $faker->semana_4_levante,
                'consumo_semana_4_levante'     => $faker->consumo_semana_4_levante,

                'semana_1_engorde_1'     => $faker->semana_1_engorde_1,
                'consumo_semana_1_engorde_1'     => $faker->consumo_semana_1_engorde_1,
                'semana_2_engorde_1'     => $faker->semana_2_engorde_1,
                'consumo_semana_2_engorde_1'     => $faker->consumo_semana_2_engorde_1,
                'semana_1_engorde_2'     => $faker->semana_1_engorde_2,
                'consumo_semana_1_engorde_2'     => $faker->consumo_semana_1_engorde_2,
                'semana_2_engorde_2'     => $faker->semana_2_engorde_2,
                'consumo_semana_2_engorde_2'     => $faker->consumo_semana_2_engorde_2,
                'semana_3_engorde_2'     => $faker->semana_3_engorde_2,
                'consumo_semana_3_engorde_2'     => $faker->consumo_semana_3_engorde_2,
                'semana_4_engorde_2'     => $faker->semana_4_engorde_2,
                'consumo_semana_4_engorde_2'     => $faker->consumo_semana_4_engorde_2
            ));
        }
    }
}
