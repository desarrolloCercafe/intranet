<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Bitacora extends Model
{
    protected $table = 'archivos';
    protected $fillable = ['id', 'nombre_archivo', 'nombre_usuario', 'path'];

    public function setPathAttribute($path)
    {
    	$this->attributes['path'] = Carbon::now()->second.$path->getClientOriginalName();
    	$archi = Carbon::now()->second.$path->getClientOriginalName();
    	\Storage::disk('local')->put($archi, \File::get($path));
    }
}

