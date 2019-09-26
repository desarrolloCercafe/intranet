<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fechas_inventario extends Model
{
    protected $table = 'fechas_inventario';
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
