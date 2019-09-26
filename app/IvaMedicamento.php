<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IvaMedicamento extends Model
{
    protected $table = 'iva_medicamentos';
    protected $fillable = ['id', 'id_medicamento', 'id_iva'];
}
