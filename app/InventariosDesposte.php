<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventariosDesposte extends Model
{
   protected $table = 'inventario_desposte';
   protected  $fillable = ['id', 'codigo', 'descripcion', 'kilos', 'unidad', 'costo_unitario', 'costo_toal', 'fecha']; 
   
}

