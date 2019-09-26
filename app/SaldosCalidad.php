<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosCalidad extends Model
{
    protected $table = 'saldos_calidad';
    protected $fillable = ['id', 'producto_id', 'descripcion', 'cantidad', 'unidad', 'costo_unitario', 'total', 'fecha'];
}
