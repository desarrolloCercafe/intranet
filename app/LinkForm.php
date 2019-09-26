<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkForm extends Model
{
    protected $table = "link_forms";
    protected $fillable = ['id', 'area_id', 'macro_id', 'enlace', 'nombre_documento'];
}
