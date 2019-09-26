<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Granja;
use App\Ceba;
use App\Http\Requests;

class ConsolidadoCebaController extends Controller
{
	/**
	* permite acceder a la vista con los datos ya establecidos para elaborar la consulta
	*
	* @var Ceba
	* @var Granja
	* @return view/admin/tabladinamica/ConsolidacionCeba compact $ano_ceba $granjas_ceba
	*/
	public function index(){
		$ano_ceba= Ceba::select('año')
    	->groupBy('año')->get();
    	$granjas_ceba= Granja::all();

		return view('admin.tabladinamica.ConsolidacionCeba',compact('ano_ceba',$ano_ceba,'granjas_ceba',$granjas_ceba));
	}
	/**
	* Permite realizar la consulta de acuerdo a los parametros enviados desde la vista
	* ConsolidacionCeba.blade.php
	*
	* @var Ceba
	* @param \Illuminate\Http\Request  $request
	* @return view/admin/tabladinamica/ConsolidacionCeba
	*/
    public  function consolidadoceba (Request $request){
   		if ($request->mes !=0) {
   			$ceba = Ceba::select('año',
	    		    DB::raw('avg(edad_inicial) as edad_inicial'),
	    			DB::raw('sum(inic) as inic'),
	    			DB::raw('sum(cant_final_cerdos) as cant_final_cerdos'),
	    			DB::raw('sum(muertes) as muertes'),
	    			DB::raw('sum(cerdos_descartados) as cerdos_descartados'),
	    			DB::raw('avg(por_mortalidad) as  por_mortalidad'),
	    			DB::raw('sum(peso_total_ingresado) as peso_total_ingresado'),
	    			DB::raw('avg(peso_promedio_ingresado) as peso_promedio_ingresado'),
	    			DB::raw('sum(peso_total_vendido) as peso_total_vendido'),
	    			DB::raw('avg(peso_promedio_vendido) as peso_promedio_vendido'),
	    			DB::raw("edad_final - edad_inicial as dias_permanencia "),
	    			DB::raw('avg(edad_final) as edad_final'),
	    			DB::raw( "peso_total_ingresado - peso_promedio_vendido as ganancia_lote_ceba"),
	    			DB::raw('avg(ato_promedio_fin) as ato_promedio_fin '),
	    			DB::raw('avg(ato_promedio_dia_fin) as ato_promedio_dia_fin'),
	    			DB::raw('sum(consumo_lote) as consumo_lote'),
	    			DB::raw('sum(consumo_promedio_lote_dias /inic) as consumo_promedio_lote_dias'),
	    			DB::raw('avg(cons_promedio_dia_ini) as cons_promedio_dia_ini'),
	    			DB::raw('avg(conversion_ajust_fin) as conversion_ajust_fin')
	    		)
	    	->where('año',[$request->fecha1])
	   		->whereIn('mes',$request->mes)
	    	->where('granja_id',$request->granja)
	    	->get();
   		}else{
   			$ceba = Ceba::select('año',
	    		    DB::raw('avg(edad_inicial) as edad_inicial'),
	    			DB::raw('sum(inic) as inic'),
	    			DB::raw('sum(cant_final_cerdos) as cant_final_cerdos'),
	    			DB::raw('sum(muertes) as muertes'),
	    			DB::raw('sum(cerdos_descartados) as cerdos_descartados'),
	    			DB::raw('avg(por_mortalidad) as  por_mortalidad'),
	    			DB::raw('sum(peso_total_ingresado) as peso_total_ingresado'),
	    			DB::raw('avg(peso_promedio_ingresado) as peso_promedio_ingresado'),
	    			DB::raw('sum(peso_total_vendido) as peso_total_vendido'),
	    			DB::raw('avg(peso_promedio_vendido) as peso_promedio_vendido'),
	    			DB::raw("edad_final - edad_inicial as dias_permanencia "),
	    			DB::raw('avg(edad_final) as edad_final'),
	    			DB::raw( "peso_total_ingresado - peso_promedio_vendido as ganancia_lote_ceba"),
	    			DB::raw('avg(ato_promedio_fin) as ato_promedio_fin '),
	    			DB::raw('avg(ato_promedio_dia_fin) as ato_promedio_dia_fin'),
	    			DB::raw('sum(consumo_lote) as consumo_lote'),
	    			DB::raw('sum(consumo_promedio_lote_dias /inic) as consumo_promedio_lote_dias'),
	    			DB::raw('avg(cons_promedio_dia_ini) as cons_promedio_dia_ini'),
	    			DB::raw('avg(conversion_ajust_fin) as conversion_ajust_fin')
	    		)
	    	->where('año',[$request->fecha1])
	    	->where('granja_id',$request->granja)
	    	->get();
   		}

   		

	   return response()->json(['status'=>'success','Consolidado_ceba'=>$ceba],200);
   }
}
