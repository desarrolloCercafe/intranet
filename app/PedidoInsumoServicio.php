<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoInsumoServicio extends Model
{
    protected $table = 'pedido_insumos_servicios';
    protected $fillable = ['id', 'consecutivo_pedido', 'fecha_pedido_insumo', 'granja_id', 'insumo_servicio_id', 'estado_id', 'unidades'];
}
