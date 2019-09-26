<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConceptoNomina extends Model
{
    protected $table = 'conceptos_nomina';
    protected $fillable = ['id', 'fecha', 'concepto', 'descripcion','titulo','tipo', 'cantidad', 'valor'];
}