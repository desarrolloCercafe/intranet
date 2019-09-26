<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExistenciaMedicamento extends Model
{
    protected $table = 'existencia_medicamentos';
    protected $fillable = ['id', 'ref_producto', 'descripcion', 'cantidad', 'medicamento_id', 'fecha'];
}
