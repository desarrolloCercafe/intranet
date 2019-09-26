<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentasDesposte extends Model
{
    protected $table = 'ventas_desposte';

    protected $fillable = [
    	'id', 'codigo', 'producto', 'cantidad' , 'precio_total', 'fecha'	
    ];
}
