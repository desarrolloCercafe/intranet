<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str as Str;


class FormularioCebaSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
        for($i = 0; $i<30; $i++){
 
            \DB::table('formulario_ceba')->insert(array(
                'lote'         => $faker->lote,
                'granja_id'  => $faker->nombre_granja,
                'fecha_ingreso_lote'       => $faker->formatDates(true,'Y-m-d'),
                'fecha_salida_lote'     => $faker->formatDates(true,'Y-m-d'),
                'año'     => $faker->año,
                'mes'     => $faker->mes,
                'semana'     => $faker->semana,
                'inic'     => $faker->inic,
                'cerdos_descartados'     => $faker->cerdos_descartados ,
                'cerdos_livianos'     => $faker->cerdos_livianos,
                'muertes'     => $faker->muertes,
                'cant_final_cerdos'     =>$faker->cant_final_cerdos,
                'meta_cerdos'     => $faker->meta_cerdos,
                'edad_inicial'     => $faker->edad_inicial,
               	'edad_inicial_total'     => $faker->edad_inicial_total,
               	'dias'     => $faker->dias,
               	'dias_permanencia'     => $faker->dias_permanencia,
               	'edad_final'     => $faker->edad_final,
               	'edad_final_total'     => $faker->edad_final_total,
               	'conf_edad_final'     => $faker->conf_edad_final,
               	'por_mortalidad'     => $faker->por_mortalidad,
               	'por_descartes'     => $faker->por_descartes,
               	'por_livianos'     => $faker->por_livianos,
               	'peso_total_ingresado'     => $faker->peso_total_ingresado,
               	'peso_promedio_ingresado'     => $faker->peso_promedio_ingresado,
               	'peso_total_vendido'     => $faker->peso_total_vendido,
               	'peso_promedio_vendido'     => $faker->peso_promedio_vendido,
               	'consumo_lote'     => $faker->consumo_lote,
               	'consumo_promedio_lote'     => $faker->consumo_promedio_lote,
               	'consumo_promedio_lote_dias'     => $faker->consumo_promedio_lote_dias
            ));
        }
    }
}
