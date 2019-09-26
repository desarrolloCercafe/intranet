<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoMedicamento extends Model
{
    protected $table = 'pedido_medicamentos';
    protected $fillable = ['id', 'consecutivo_pedido', 'fecha_pedido', 'granja_id', 'medicamento_id', 'unidades'];
}
