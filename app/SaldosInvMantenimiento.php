<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosInvMantenimiento extends Model
{
    protected $table = 'saldos_inv_mantenimiento';
    protected $fillable = ['id', 'codigo', 'descripcion' , 'cantidad', 'costo_unitario', 'costo_total', 'fecha'];
}
