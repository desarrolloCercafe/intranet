<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasSaldosDotacion extends Model
{
    protected $table = 'fechas_saldos_dotacion';
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
