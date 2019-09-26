<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsecutivoConcentrado extends Model
{
    protected $table = 'consecutivos_concentrados';
    protected $fillable = ['id', 'consecutivo',  'fecha_creacion', 'fecha_estimada', 'granja_id', 'user_id', 'estado_id', 'fecha_entrega',  'hora_entrega', 'conductor_asignado', 'vehiculo_asignado'];
}
