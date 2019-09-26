<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteMortalidadPreceboCeba extends Model
{
    protected $table = 'formulario_mortalidad_precebo_ceba'; 
    protected $fillable = ['id', 'granja_id', 'lote', 'sala', 'numero_cerdos', 'sexo_cerdo', 'peso_cerdo', 'fecha', 'dia_muerte', 'año_muerte', 'mes_muerte', 'semana_muerte', 'edad_cerdo','causa_id', 'alimento_id'];
}
