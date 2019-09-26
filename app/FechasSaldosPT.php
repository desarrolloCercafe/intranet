<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasSaldosPT extends Model
{
    protected $table = 'fechas_saldos_pt';
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
