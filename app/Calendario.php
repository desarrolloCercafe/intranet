<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    protected $table = 'calendario';
    protected $fillable = ['fecha', 'year', 'trimestre', 'mes_year', 'dia_mes', 'fecha_entero', 'nombre_mes', 'mes_calendario', 'trimestre_calendario', 'dia_semana', 'dia_semana_nombre', 'fin_de_semana', 'numero_semana', 'mes_year_entero', 'trimestre_year_int', 'year_shor', 'fy'];
}
