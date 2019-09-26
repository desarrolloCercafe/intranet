<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoConcentrado extends Model
{
    protected $table = 'pedido_concentrados';
    protected $fillable = ['id', 'consecutivo_pedido', 'fecha_creacion', 'fecha_entrega', 'tipo_documento', 'prefijo', 'granja_id', 'concentrado_id', 'estado_id', 'no_bultos', 'no_kilos','fecha_estimada'];
}
  