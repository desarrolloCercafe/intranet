<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoCia extends Model
{
    protected $table = 'pedido_cia';
    protected $fillable = ['id', 'consecutivo_pedido', 'fecha_pedido', 'granja_id', 'producto_cia_id', 'dosis','fecha_estimada'];
}
