<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porcentaje extends Model
{
    protected $table = 'porcentajes';
    protected $fillable = ['id', 'subproceso', 'porcentaje', 'porcentaje_valor', 'etapa', 'created_at', 'updated_at'];
}
