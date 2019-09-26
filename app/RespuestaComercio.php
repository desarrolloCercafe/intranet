<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaComercio extends Model
{
    protected $table = 'respuestas_comercio';
    protected $fillable = ['id','solicitud_id','fecha_redaccion','descripcion','emisario_id'];
}
