<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoCia extends Model
{ 
    protected $table = 'productos_cia';
    protected $fillable = ['id', 'ref_producto_cia', 'nombre_producto_cia'];
}
