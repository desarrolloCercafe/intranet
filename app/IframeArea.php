<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IframeArea extends Model
{
    protected $table = 'iframes_area';
    protected $fillable = ['id','area_id','iframe', 'path'];
}
