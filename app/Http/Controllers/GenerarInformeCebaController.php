<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Ceba;
use App\Http\Requests;

class GenerarInformeCebaController extends Controller{
	/**
	* permite hacer una consulta a la base de datos para despues poder generar un archivo excel 
	* de acuerdo a los parametros enviados desde la vista GeneralPrecebo.blade.php
	*
	* @var Ceba
	* @param \Illuminate\Http\Request  $request
	* @return view/admin/tabladinamica/GeneralPrecebo.blade.php
	*/
    public function Consulta_general (request $request){
    	$Consolidado_ceba = Ceba::select(
			'año',
		    'edad_inicial',
			'fecha_ingreso_lote',
			'lote',
			'fecha_salida_lote',
			'inic',
			'cant_final_cerdos',
			'muertes',
			'cerdos_descartados',
			'por_mortalidad',
			'peso_total_ingresado',
			'peso_promedio_ingresado',
			'peso_total_vendido',
			'peso_promedio_vendido',
			 DB::raw("edad_final - edad_inicial as dias_permanencia "),
			'edad_final',
			 DB::raw( "peso_total_vendido -peso_total_ingresado   as ganancia_lote_ceba"),
			 DB::raw("(peso_total_vendido -peso_total_ingresado)/ inic as ato_promedio_dia_fin "),
			'ato_promedio_fin',
			'consumo_lote',
			DB::raw("consumo_lote / inic as final "),
			DB::raw("(consumo_lote / inic ) /(edad_final - edad_inicial) as cons_promedio_dia_ini"),
			DB::raw('consumo_lote / (peso_total_vendido -peso_total_ingresado) as conversion_ajust_fin')
		)
    	->whereBetween('año',[$request->fecha1,$request->fecha2])
    	->get();
	   	return response()->json(['status'=>'success','Consolidado_ceba'=>$Consolidado_ceba],200);
    }
}
