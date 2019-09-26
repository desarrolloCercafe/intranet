<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosPT extends Model
{
    protected $table = 'saldos_pt';
    protected $fillable = ['id', 'codigo', 'descripcion' , 'cantidad', 'costo_unitario', 'costo_total', 'fecha'];
}
