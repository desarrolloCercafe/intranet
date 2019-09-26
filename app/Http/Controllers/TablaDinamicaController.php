<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Granja;
use App\AsociacionGranja;
use App\Precebo;
use App\Http\Requests;

class TablaDinamicaController extends Controller
{
	/**
	* permite cargar la vista tabla_dinamica.blade.php con los parametros
	* para realizar una consulta
	*
	* @var Precebo
	* @var Granja
	* @var AsociacionGranja
	* @return view/admin/tabladinamica/tabla_dinamica.blade.php compact $anno_precebo 
	* $granjas $g_as
	*/
    public function index()
    {
    	$anno_precebo= Precebo::select('año_traslado')
    	->groupBy('año_traslado')->get();
    	$granjas= Granja::all();
    	$g_as = AsociacionGranja::all();

		return view('admin.tabladinamica.tabla_dinamica',compact('anno_precebo',$anno_precebo,'granjas',$granjas,'g_as',$g_as));
    }

    /**
    * permite realizar una consulta desde la vista tabla_dinamica.blade.php y de acuerdo a los datos
    * ingresados se realiza una condicion para determinar la cantidad de datos enviados,
    * luego retorna un json con los datos cargados de acuerdo a la condicion cumplida
    *
    * @var Precebo
    * @param Illuminate\Http\Request $request.
    * @return response()->json(['status'=>'success','data'=>$precebo],200)
    */

    public function consulta (request $request)
    {
       
     	if ($request->mes != 0) 
     	{
     		$precebo = Precebo::select(
				DB::raw("peso_fin - peso_ini as ganancia_lote"),
				DB::raw("edad_final - edad_destete as dias_permanencia"),
				'año_traslado',
				'mes_traslado',
				'edad_destete',
				'edad_final',
				'fecha_destete',
				'lote', 
				'fecha_traslado',
				'numero_inicial',
				'numero_final',
				'numero_muertes',
				'numero_descartes',
				'porciento_mortalidad',
				'peso_ini',
				'peso_promedio_ini',
				'peso_fin',
				'peso_promedio_fin',
				'ato_promedio_ini',
				'ato_promedio_fin',
				'ato_promedio_dia_fin',
				'cons_total',
				'cons_promedio_dia',
				'cons_promedio',
				'cons_promedio_dia_ini',
				'conversion_ajust_fin')
			->where('año_traslado',[$request->fecha1])
			->whereIn('mes_traslado',$request->mes)
			->where('granja_id',$request->granja)->get();
     	}
     	else
     	{

     		$granja_filtro =$request->granja;
     		$ano_filtro=$request->fecha1;
     		$mes_filtro="+";

     		$precebo = Precebo::select(
				DB::raw("peso_fin - peso_ini as ganancia_lote"),
				DB::raw("edad_final - edad_destete as dias_permanencia"),
				'año_traslado',
				'mes_traslado',
				'edad_destete',
				'edad_final',
				'fecha_destete',
				'lote', 
				'fecha_traslado',
				'numero_inicial',
				'numero_final',
				'numero_muertes',
				'numero_descartes',
				'porciento_mortalidad',
				'peso_ini',
				'peso_promedio_ini',
				'peso_fin',
				'peso_promedio_fin',
				'ato_promedio_ini',
				'ato_promedio_fin',
				'ato_promedio_dia_fin',
				'cons_total',
				'cons_promedio_dia',
				'cons_promedio',
				'cons_promedio_dia_ini',
				'conversion_ajust_fin')
			->where('año_traslado',[$request->fecha1])
			->where('granja_id',$request->granja)->get();
     	}
		return response()->json(['status'=>'success','data'=>$precebo],200);
    }
}
