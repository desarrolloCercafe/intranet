<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ceba extends Model
{
    protected $table = 'formulario_ceba';
    protected $fillable = ['id', 'lote', 'granja_id', 'fecha_ingreso_lote','fecha_salida_lote','año','mes','semana','inic','cerdos_descartados','cerdos_livianos','muertes','cant_final_cerdos','meta_cerdos','edad_inicial','edad_inicial_total','dias','dias_permanencia','edad_final','edad_final_total','conf_edad_final','por_mortalidad','por_descartes','por_livianos','peso_total_ingresado', 'peso_promedio_ingresado', 'peso_total_vendido', 'peso_promedio_vendido','consumo_lote','consumo_promedio_lote','consumo_promedio_lote_dias', 'cons_prom_inicial', 'cons_prom_dia_ini', 'cons_ajustado_ini', 'ato_promedio_ini', 'ato_promedio_dia_ini', 'conversion_ini', 'conversion_ajust_ini', 'cons_ajustado_fin', 'ato_promedio_fin', 'ato_promedio_dia_fin', 'conversion_fin', 'conversion_ajust_fin', 'RUL_ceba'];
}
