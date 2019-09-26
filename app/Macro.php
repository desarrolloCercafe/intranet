<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Macro extends Model
{
    protected $table = "macros_form";
    protected $fillable = ['id', 'area_id', 'proceso'];
}
