<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesoEsperado extends Model
{
    protected $table = 'medicamentos';
    protected $fillable = ['id', 'edad', 'peso_esperado'];
} 
