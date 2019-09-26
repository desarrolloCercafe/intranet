<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Granja extends Model 
{
    protected $table = 'granjas'; 
    protected $fillable = ['id', 'nombre_granja', 'descripcion_granja','direccion_granja','numero_contacto_granja', 'porcentaje_precebo', 'porcentaje_ceba', 'forma_pago', 'centro_costo'];
}
