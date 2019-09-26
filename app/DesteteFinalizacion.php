<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesteteFinalizacion extends Model
{
    protected $table = 'formulario_destete_finalizacion';
    protected $fillable = ['id', 'lote', 'granja_id', 'fecha_ingreso_lote','fecha_salida_lote','año','mes','semana','inic','cerdos_descartados','cerdos_livianos','muertes','cant_final_cerdos','meta_cerdos','edad_inicial','edad_inicial_total','dias','dias_permanencia','edad_final','edad_final_total','conf_edad_final','por_mortalidad','por_descartes','por_livianos','peso_total_ingresado', 'peso_promedio_ingresado', 'peso_total_vendido', 'peso_promedio_vendido','consumo_lote','consumo_promedio_lote','consumo_promedio_lote_dias'];
}
