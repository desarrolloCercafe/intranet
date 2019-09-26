<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productos_calidad extends Model
{
    protected $table = 'productos_calidad';
    protected $fillable = ['id', 'codigo_producto', 'descripcion'];
}
