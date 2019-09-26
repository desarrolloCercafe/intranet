<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Precebo;
use App\Http\Requests;

class GeneralPreceboController extends Controller{
	/**
	* Permite visualizar la vista GeneralPrecebo.blade.php
	*
	* @var Precebo
	* @return view/admin/tabladinamica/GeneralPrecebo.blade.php compact $anno_precebo
	*/
    public function index(){
    	$anno_precebo= Precebo::select('año_traslado')
    	->groupBy('año_traslado')
    	->get();
    	return view('admin.tabladinamica.general_precebo',compact('anno_precebo',$anno_precebo));
    }
    /**
    * permite hacer una consulta a la base de datos para despues poder generar un archivo excel 
	* de acuerdo a los parametros enviados desde la vista GeneralPrecebo.blade.php
	*
	* @var Precebo
	* @param  \Illuminate\Http\Request  $request
	* @return view/admin/tabladinamica/GeneralPrecebo.blade.php
    */
    public function Generar_informe (request $request){
 		$generalprecebo = Precebo::select(	
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
			'ato_promedio_fin',
			'ato_promedio_dia_fin',
			'cons_total',
			'cons_promedio_dia',
			'cons_promedio',
			'cons_promedio_dia_ini',
			'conversion_ajust_fin')
		->whereBetween('año_traslado',[$request->fecha1,$request->fecha2])
		->get();
		return response()->json(['status'=>'success','generalprecebo'=>$generalprecebo],200);
    }
}
