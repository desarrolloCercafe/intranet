<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciasMedicamentos extends Model
{
    protected $table = 'referencias_medicamentos';
    protected $fillable = ['id', 'referencia', 'nombre', 'tipo', 'precio'];
}
