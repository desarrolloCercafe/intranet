<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumoServicios extends Model
{
    protected $table = 'insumos_servicios'; 
    protected $fillable = ['id', 'ref_insumo', 'nombre_insumo', 'tipo_insumo', 'proveedor_1', 'proveedor_2', 'proveedor_3', 'proveedor_4']; 
}  
