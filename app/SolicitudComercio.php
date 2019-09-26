<?php

namespace App;
use Carbon\carbon;
use Illuminate\Database\Eloquent\Model;

class SolicitudComercio extends Model
{
    protected $table = 'solicitudes_comercio';
    protected $fillable = ['id', 'agente','medio','categoria', 'nombre_completo', 'cedula', 'direccion', 'telefono', 'correo_electronico', 'fecha_hora', 'motivo_descripcion','motivo_adicional','descripcion','path','estado_id','emisario_id','moderador'];

    public function setPathAttribute($path)
    {
    	if ($path != null) {
    		$name = Carbon::now()->second.$path->getClientOriginalName();
        	$this->attributes['path'] = $name;
        	\Storage::disk('local4')->put($name, \File::get($path));
    	}	
    }
}
