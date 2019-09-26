<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precebo extends Model
{
    protected $table = 'formulario_precebo'; 
    protected $fillable = ['id', 'lote', 'granja_id', 'fecha_destete','fecha_traslado','semana_destete','semana_traslado', 'año_destete', 'año_traslado', 'mes_traslado', 'numero_inicial', 'edad_destete', 'edad_inicial_total', 'dias_jaulon', 'dias_totales_permanencia', 'edad_final', 'edad_final_ajustada', 'peso_esperado', 'numero_muertes', 'numero_descartes', 'numero_livianos', 'numero_final', 'porciento_mortalidad', 'porciento_descartes', 'porciento_livianos', 'peso_ini', 'peso_promedio_ini', 'peso_ponderado_ini', 'peso_fin', 'peso_promedio_fin', 'peso_ponderado_fin', 'ind_peso_final', 'cons_total', 'cons_promedio', 'cons_ponderado', 'cons_promedio_dia', 'cons_promedio_ini', 'cons_ponderado_ini', 'cons_promedio_dia_ini', 'cons_ajustado_ini', 'ato_promedio_ini', 'ato_promedio_dia_ini', 'conversion_ini', 'conversion_ajust_ini', 'cons_ajustado_fin', 'ato_promedio_fin', 'ato_promedio_dia_fin', 'conversion_fin', 'conversion_ajust_fin', 'RUL_precebo', 'eficiencia'];
}
