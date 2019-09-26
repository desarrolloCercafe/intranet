<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehiculoDespacho extends Model
{
    protected $table = 'vehiculos_despacho';
    protected $fillable = ['id', 'placa', 'capacidad']; 
}
