<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
   protected $table = 'preguntas';
   protected $fillable = ['id', 'criterio', 'subproceso', 'etapa', 'id_porcentaje'];
}
