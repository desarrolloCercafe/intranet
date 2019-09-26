<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventariosMedicamento extends Model
{
   protected $table = 'inventario_medicamentos';
   protected $fillable = ['id', 'medicamento_id', 'cantidad', 'unidad', 'costo_unitario', 'costo_total', 'fecha'];
}
