<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuestas';
    protected $fillable = ['id', 'solicitud_id', 'redactor', 'fecha_redaccion', 'descripcion_respuesta'];
}
 