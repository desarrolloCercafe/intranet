<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Granja;
use App\Precebo;
use App\Http\Requests;

class ConsolidacionController extends Controller
{
	/**
	* permite acceder a la vista con los datos para filtrar 
	*
	* @var Precebo
	* @var Granja
	* @return view/admin/tabladinamica/ConsolidadoGeneral.blade.php
	*/
    public function index(){

    	$anno_precebo= Precebo::select('año_traslado')
    	->groupBy('año_traslado')->get();
    	$granjas= Granja::all();

    	return view('admin.tabladinamica.consolidado_general',compact('anno_precebo',$anno_precebo,'granjas',$granjas));
    }

    /**
    * permite hacer una consulta a la base de datos de acuerdos 
    * a los parametros que se esten enviando en la vista ConsolidadoGeneral.blade.php
    *
    * @var Precebo
   	* @param \Illuminate\Http\Request  $request
   	* @return view/admin/tabladinamica/ConsolidadoGeneral.blade.php
    */
    public function consolidar(Request $request){

    	if ($request->mes !=0) {
    		$Consolidacion = Precebo::select(
				'año_traslado',
				'mes_traslado',
			
				DB::raw('avg(edad_destete) as edad_inicial'),
				DB::raw("avg(edad_final - edad_destete) as dias_permanecia"),
			    DB::raw('avg(edad_final) as edad_final'),
			    DB::raw('sum(numero_inicial) as t_numero_inicial'),
			    DB::raw('sum(numero_final) as numero_final'),
			    DB::raw('sum(numero_muertes) as numero_muertes'),
				DB::raw('sum(numero_descartes) as numero_descartes'),
				DB::raw('avg(porciento_mortalidad) as promedio_mortalidad'),
				DB::raw('sum(peso_ini) as total_peso_ini'),
				DB::raw('sum(peso_fin) as total_peso_fin'),
				DB::raw('avg(peso_promedio_ini) as promedio'),
				DB::raw('avg(peso_promedio_fin) as total_peso_promedio_fin'),
				DB::raw('sum(ato_promedio_fin) as total_ato_promedio_fin'),
				DB::raw('avg(ato_promedio_dia_fin) as total_ato_promedio_dia_fin'),
				DB::raw("avg(peso_fin - peso_ini) as total_ganancia_lote"),
				DB::raw('sum(cons_total) as total_cons_total'),
				DB::raw('avg(cons_promedio_dia) as total_cons_promedio_dia'),
				DB::raw('avg(cons_promedio_dia_ini) as total_cons_promedio_dia_ini'),
				DB::raw('avg(conversion_ajust_fin) as total_conversion_ajust_fin')	
			)
			->where('granja_id',$request->granja)
			->where('año_traslado',$request->fecha1)
			->whereIn('mes_traslado',$request->mes)
			->get();
    	}else{
    		$Consolidacion = Precebo::select(
				'año_traslado',
				'mes_traslado',

				DB::raw('avg(edad_destete) as edad_inicial'),
				DB::raw("avg(edad_final - edad_destete) as dias_permanecia"),
			    DB::raw('avg(edad_final) as edad_final'),
			    DB::raw('sum(numero_inicial) as t_numero_inicial'),
			    DB::raw('sum(numero_final) as numero_final'),
			    DB::raw('sum(numero_muertes) as numero_muertes'),
				DB::raw('sum(numero_descartes) as numero_descartes'),
				DB::raw('avg(porciento_mortalidad) as promedio_mortalidad'),
				DB::raw('sum(peso_ini) as total_peso_ini'),
				DB::raw('sum(peso_fin) as total_peso_fin'),
				DB::raw('avg(peso_promedio_ini) as promedio'),
				DB::raw('avg(peso_promedio_fin) as total_peso_promedio_fin'),
				DB::raw('sum(ato_promedio_fin) as total_ato_promedio_fin'),
				DB::raw('avg(ato_promedio_dia_fin) as total_ato_promedio_dia_fin'),
				DB::raw("avg(peso_fin - peso_ini) as total_ganancia_lote"),
				DB::raw('sum(cons_total) as total_cons_total'),
				DB::raw('avg(cons_promedio_dia) as total_cons_promedio_dia'),
				DB::raw('avg(cons_promedio_dia_ini) as total_cons_promedio_dia_ini'),
				DB::raw('avg(conversion_ajust_fin) as total_conversion_ajust_fin')	
			)
			->where('granja_id',$request->granja)
			->where('año_traslado',$request->fecha1)
			->get();
    	}
		return response()->json(['status'=>'success','Consolidacion'=>$Consolidacion],200);
    }
}
