<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioPT extends Model
{
    protected $table = 'inventario_pt';
    protected $fillable = ['id', 'codigo', 'descripcion'];
}
