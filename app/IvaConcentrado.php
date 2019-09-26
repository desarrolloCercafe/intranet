<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IvaConcentrado extends Model
{
    protected $table = 'iva_concentrados';
    protected $fillable = ['id', 'id_concentrado', 'id_iva'];
}
