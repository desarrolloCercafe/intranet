<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $table = 'alimentos'; 
    protected $fillable = ['id', 'nombre_alimento', 'peso_gramos'];
}
