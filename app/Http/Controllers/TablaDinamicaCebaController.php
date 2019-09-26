<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Granja;
use App\Ceba;
use App\AsociacionGranja;
use App\Http\Requests;

class TablaDinamicaCebaController extends Controller{

	/**
	* permite visualizar la vista tabla_dinamica_ceba.blade.php con los parametros necesarios para
	* realizar la consulta 
	* 
	* @var Granja
	* @var Ceba
	* @var AsociacionGranja
	* @return view('admin.tabladinamica.tabla_dinamica_ceba',compact('ano_ceba',$ano_ceba,'granjas_ceba',$granjas_ceba,'g_as',$g_as));
	*/

	public function index(){

		$ano_ceba= Ceba::select('año')
		->groupBy('año')->get();
		$granjas_ceba= Granja::all();
		$g_as = AsociacionGranja::all();

		return view('admin.tabladinamica.tabla_dinamica_ceba',compact('ano_ceba',$ano_ceba,'granjas_ceba',$granjas_ceba,'g_as',$g_as));
    }

    /**
    * permite realizar una consulta desde la vista tabla_dinamica_ceba.blade.php una vez hecha la consulta
    * se reaiza una condicion de acuerdo a los parametros enviados y devuelve un json con los datos
    * cargados de acuerdo a la condicion cumplida
    *
    * @var Ceba
    * @param Illuminate\Http\Request $request
    * @return response()->json(['status'=>'success','data'=>$ceba],200)
    */

    public function ConsultaCeba(request $request){
    	if ($request->mes != 0) {
	    	$ceba = Ceba::join('granjas','granjas.id','=','formulario_ceba.granja_id')
	    	->select('año',
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
	    			DB::raw("edad_final - edad_inicial as dias_permanencia"),
	    			'edad_final',
	    			DB::raw('peso_total_vendido - peso_total_ingresado  as ganancia_lote'),
	    			'ato_promedio_fin',
	    			'ato_promedio_dia_fin',
	    			'consumo_lote',
	    			'consumo_promedio_lote_dias',
	    			'cons_promedio_dia_ini',
	    			'conversion_ajust_fin')
	    	->where('año',[$request->fecha1])
	    	->whereIn('mes',$request->mes)
	    	->where('granja_id',$request->granja)
	    	->get();
        }
        else
        {
        	$ceba = Ceba::join('granjas','granjas.id','=','formulario_ceba.granja_id')
	    	->select('año',
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
	    			DB::raw("edad_final - edad_inicial as dias_permanencia"),
	    			'edad_final',
	    			DB::raw('peso_total_vendido - peso_total_ingresado  as ganancia_lote'),
	    			'ato_promedio_fin',
	    			'ato_promedio_dia_fin',
	    			'consumo_lote',
	    			'consumo_promedio_lote_dias',
	    			'cons_promedio_dia_ini',
	    			'conversion_ajust_fin')
	    	->where('año',[$request->fecha1])
	    	->where('granja_id',$request->granja)
	    	->get();
        }
    	return response()->json(['status'=>'success','data'=>$ceba],200);
    }
    
}
