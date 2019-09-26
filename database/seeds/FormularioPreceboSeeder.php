<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str as Str;


class FormularioCebaTableSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
        for($i = 0; $i<30; $i++){
 
            \DB::table('formulario_precebo')->insert(array(
                'granja_id'  => $faker->nombre_granja,
                'lote' => $faker->lote,
                'fecha_destete'       => $faker->formatDates(true,'Y-m-d'),
                'fecha_traslado'     => $faker->formatDates(true,'Y-m-d'),
                'semana_destete'     => $faker->semana_destete,
                'semana_traslado'     => $faker->semana_traslado,
                'año_destete'     => $faker->año_destete,
                'año_traslado'     => $faker->año_traslado,
                'mes_traslado'     => $faker->mes_traslado,
                'numero_inicial'     => $faker->numero_inicial,
                'edad_destete'     => $faker->edad_destete,
                'edad_inicial_total'    => $faker->edad_inicial_total,
                'dias_jaulon'     => $faker->dias_jaulon,
                'dias_totales_permanencia'     =>$faker->dias_totales_permanencia,
                'edad_final'     => $faker->edad_final,
                'edad_final_ajustada'     => $faker->edad_final_ajustada,
               	'peso_esperado'     => $faker->peso_esperado,
               	'numero_muertes'     => $faker->numero_muertes,
               	'numero_descartes'     => $faker->numero_descartes,
               	'numero_livianos'     => $faker->numero_livianos,
               	'numero_final'     => $faker->numero_final,
               	'porciento_mortalidad'     => $faker->porciento_mortalidad,
               	'porciento_descartes'     => $faker->porciento_descartes,
               	'porciento_livianos'     => $faker->porciento_livianos,
               	'por_livianos'     => $faker->por_livianos,
               	'peso_ini'     => $faker->peso_ini,
               	'peso_promedio_ini'     => $faker->peso_promedio_ini,
               	'peso_ponderado_ini'     => $faker->peso_ponderado_ini,
               	'peso_fin'     => $faker->peso_fin,
               	'peso_promedio_fin'     => $faker->peso_promedio_fin,
               	'peso_ponderado_fin'     => $faker->peso_ponderado_fin,
               	'ind_peso_final'     => $faker->ind_peso_final,
                'cons_total'     => $faker->cons_total,
                'cons_promedio'     => $faker->cons_promedio,
                'cons_ponderado'     => $faker->cons_ponderado,
                'cons_promedio_dia'     => $faker->cons_promedio_dia
            ));
        }
    }
}