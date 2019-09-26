<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValorFinalInventarioMtp extends Model
{
    protected $table = 'valor_final_inv_mtp';
    protected $fillable = ['id', 'referencia', 'tipo_producto', 'producto', 'costo', 'mes', 'fecha'];
}
