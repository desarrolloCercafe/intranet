<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GranjasDisponibles extends Model
{
    protected $table = 'granjas_disponibles';
    protected $fillable = ['id','granja_id','semana','cerdos_disponibles','peso_promedio','remember_token'];
}
