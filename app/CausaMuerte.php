<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CausaMuerte extends Model
{
    protected $table = 'causas_muerte'; 
    protected $fillable = ['id', 'causa'];
}
