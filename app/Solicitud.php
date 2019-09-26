<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $fillable = ['id', 'emisor_id', 'agente', 'asunto', 'descripcion_solicitud', 'fecha_envio', 'estado_id', 'prioridad', 'path'];

    public function setPathAttribute($path)
    {
    	if ($path != null) {
    		$name = Carbon::now()->second.$path->getClientOriginalName();
        	$this->attributes['path'] = $name;        
        	\Storage::disk('local2')->put($name, \File::get($path));
    	}	
    } 
}
