<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IvaInsumo extends Model
{
    protected $table = 'iva_insumos';
    protected $fillable = ['id', 'id_insumo', 'id_iva'];
}
