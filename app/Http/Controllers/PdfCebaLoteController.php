<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Ceba;
use App\Http\Requests;

class PdfCebaLoteController extends Controller
{
	/**
	* permite realizar una consulta desde la vista tabla_dinamica para despues
	* generar un archivo PDF con la informacion de acuerdo a los datos enviados desde la vista
	*
	* @var Ceba
	* @param use Illuminate\Http\Request $request
	* @return $pdf->download('Reporte Ceba.pdf')
	*/
    public function generar_reporte_ceba_lote(Request $request){

    	$ceba = Ceba::select(
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
		->where('granja_id',$request->granjas_ceba_hidden)
		->where('año',[$request->ano_mes_hidden]);


		if($request->has('selecionar_mes_hidden')){
			$parametros_ceba = explode(",", $request->selecionar_mes_hidden);

			$ceba = $ceba->whereIn('mes', $parametros_ceba);
		}

		$ceba = $ceba->get();
	    $pdf = \PDF::loadView('admin.tabladinamica.tabla_dinamica_ceba_pdf', compact('ceba'))
	     ->setPaper('legal', 'landscape');

	    return $pdf->download('Reporte Ceba.pdf');		
    }
}
