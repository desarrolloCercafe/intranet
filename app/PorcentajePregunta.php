<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PorcentajePregunta extends Model
{
    protected $table = 'procentajes_preguntas';
    protected $fillable = ['id', 'id_pregunta', 'id_proceso_macro', 'porc_pregunta', 'porc_valor'];
}
