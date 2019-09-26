<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregaConcentrado extends Model
{
    protected $table = 'entrega_pedidos_concentrado';
    protected $fillable = ['id', 'consecutivo_id', 'fecha_selecionada', 'vehiculo_seleccionado', 'conductor_seleccionado','fecha_modificada']; 
}
