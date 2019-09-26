<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table = 'medicamentos';
    protected $fillable = ['id', 'ref_medicamento', 'nombre_medicamento', 'tipo_medicamento', 'proveedor_1', 'proveedor_2', 'proveedor_3', 'proveedor_4'];
}
