<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsecutivoMedicamento extends Model
{
    protected $table = 'consecutivos_medicamentos';
    protected $fillable = ['id', 'consecutivo', 'fecha_creacion', 'granja_id'];
}
