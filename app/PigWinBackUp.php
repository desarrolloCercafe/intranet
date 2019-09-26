<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class PigWinBackUp extends Model
{
    protected $table = 'pigwin_backup'; 
    protected $fillable = ['id', 'fecha_archivo', 'granja_id', 'nombre_copia','usuario', 'path'];

    public function setPathAttribute($path)
    { 
        $this->attributes['path'] = Carbon::now()->second.$path->getClientOriginalName();
        $archi = Carbon::now()->second.$path->getClientOriginalName();
        \Storage::disk('local3')->put($archi, \File::get($path));
    }
}
