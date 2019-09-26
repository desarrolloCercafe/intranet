<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class informacion_colaborador extends Model
{
   protected $table = 'informacion_colaboradores';
   protected $fillable = ['id', 'empleado', 'cedula', 'nombre', 'fecha_ingreso', 'fondo_pensiones', 'nombre_de_fondo_de_pensiones', 'eps', 'nombre_de_eps', 'caja_compensacion', 'nombre_de_caja_compensacion', 'descripcion_cargo', 'descripcion_centro_costo', 'comisiones'];
}
