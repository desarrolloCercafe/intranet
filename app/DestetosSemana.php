<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestetosSemana extends Model
{
    protected $table = 'formulario_destetos_semana'; 
    protected $fillable = ['id', 'granja_cria_id','lote','año_destete','semana_destete','numero_destetos','mortalidad_precebo','traslado_a_ceba','cantidad_a_ceba','mortalidad_ceba','semana_venta','año_venta','disponibilidad_venta','kilos_venta','semana_1_fase_1','consumo_semana_1_fase_1','semana_2_fase_1','consumo_semana_2_fase_1','semana_1_fase_2','consumo_semana_1_fase_2','semana_2_fase_2','consumo_semana_2_fase_2', 'semana_1_fase_3', 'consumo_semana_1_fase_3', 'semana_2_fase_3','consumo_semana_2_fase_3','semana_3_fase_3','consumo_semana_3_fase_3', 'semana_1_iniciacion', 'consumo_semana_1_iniciacion', 'semana_2_iniciacion', 'consumo_semana_2_iniciacion', 'semana_1_levante', 'consumo_semana_1_levante', 'semana_2_levante', 'consumo_semana_2_levante', 'semana_3_levante', 'consumo_semana_3_levante', 'semana_4_levante', 'consumo_semana_4_levante', 'semana_1_engorde_1', 'consumo_semana_1_engorde_1', 'semana_2_engorde_1', 'consumo_semana_2_engorde_1', 'semana_1_engorde_2', 'consumo_semana_1_engorde_2', 'semana_2_engorde_2', 'consumo_semana_2_engorde_2', 'semana_3_engorde_2', 'consumo_semana_3_engorde_2', 'semana_4_engorde_2', 'consumo_semana_4_engorde_2'];
}
