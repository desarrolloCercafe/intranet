<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasSaldosCalidad extends Model
{
    protected $table = 'fechas_saldos_calidad';
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
