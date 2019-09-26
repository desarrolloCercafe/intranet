<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeCalidad extends Model
{
    protected $table = 'informe_calidad';
    protected $fillable = ['id', 'ref', 'nombre_producto', 'saldo_geminus', 'cantidad', 'conteo', 'diferencia','costo_unitario','costo_total','costo_diferencia','id_calendario', 'year', 'mes', 'fecha'];
}
