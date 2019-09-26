<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosDotacion extends Model
{
    protected $table = 'saldos_dotacion';
    protected $fillable = ['id', 'producto_id', 'descripcion', 'cantidad', 'unidad', 'costo_unitario', 'total', 'fecha'];
}
