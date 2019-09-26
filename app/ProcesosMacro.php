<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcesosMacro extends Model
{
    protected $table = 'procesos_macros';
    protected $fillable = ['id', 'proceso', 'porcentaje', 'porcentaje_valor'];
}
