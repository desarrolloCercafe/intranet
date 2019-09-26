<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Ceba;
use App\Precebo;
use App\Http\Requests;

class GenerarExcelPrecebosController extends Controller{
	/**
	* permite hacer una consulta a la base de datos para despues poder generar un archivo excel 
	* de acuerdo a los parametros enviados desde la vista GeneralPrecebo.blade.php
	*
	* @var Precebo
	* @var Ceba
	* @param \Illuminate\Http\Request  $request
	* @return Reporte General Precebo.xls || Reporte General Ceba.xls
	*/
 	public function informe_general (Request $request){
 		if ($request->option == 1) {
 			$precebo = Precebo::join('granjas','granjas.id','=','formulario_precebo.granja_id')
			->select(	
			'edad_destete',
            DB::raw("edad_final - edad_destete as dias_permanencia"),
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
             DB::raw("peso_fin - peso_ini as ganancia"),
            'ato_promedio_fin',
            'ato_promedio_dia_fin',
            'cons_total',
            'cons_promedio_dia',
            'cons_promedio',
            'cons_promedio_dia_ini',
            'conversion_ajust_fin')
			->whereBetween('año_traslado',[$request->ano,$request->ano1])
			->get();
			

	        $precebo=json_decode(json_encode($precebo),true);
	        $titulo = 'Reporte General Precebo';
	        Excel::create($titulo, function($excel) use ($titulo, $precebo){   
	            $excel->setTitle($titulo);
	            $excel->setDescription('Tabla de las granjas');

	            $excel->sheet('Informe', function($sheet) use ($titulo, $precebo){
	                $sheet->fromArray($precebo, null, 'A1', true);
	                $sheet->setAutoSize(true);
	                $sheet->setFontSize(13);
	                $sheet->setFreeze('A2');

	                $sheet->row(1, array(
	                    'EDAD INICIAL', 'DIAS DE PERMANENCIA', 'EDAD FINAL','FECHA INICIAL','LOTE','FECHA FINAL','N° INICIAL DE ANIMALES','N° FINAL DE ANIMALES','N° MUERTOS DE ANIMALES','N° DESCARTES DE ANIMALES','% MORTALIDAD','PESO TOTAL INICIAL','PESO PROMEDIO INICIAL(KG)','PESO TOTAL FINAL(KG)','PESO PROMEDIO FINAL (KG)','GANANCIA DE PESO TOTAL DEL LOTE','GANANCIA DE PESO TOTAL POR ANIMAL','GANANCIA DE PESO POR ANIMAL  DIA','CONSUMO TOTAL DEL LOTE','CONSUMO TOTAL POR ANIMAL','CONSUMO TOTAL POR ANIMAL DIA','CONVERSION',
	                ));
	                $sheet->row(1, function($row) {
	                    $row->setBackground('#df0101');
	                    $row->setFontWeight('bold');
	                    $row->setAlignment('center');
                        $row->setFontColor('#ffffff');
	                });
	            });
	        })->export("xls");
 		}elseif ($request->option == 2) {
 			$generalceba = Ceba::select(		    
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
		    ->whereBetween('año',[$request->ano,$request->ano1])
		    ->get();
  
	    	$generalceba=json_decode(json_encode($generalceba),true);
            $titulo = 'Reporte  General Ceba';
            Excel::create($titulo, function($excel) use ($titulo, $generalceba){   
                $excel->setTitle($titulo);
                $excel->setDescription('Informe de Ceba');

                $excel->sheet('Granjas', function($sheet) use ($titulo, $generalceba){
       		         $sheet->fromArray($generalceba, null, 'A1', true);
       		        $sheet->setAutoSize(true);
        	        $sheet->setFontSize(13);
        	        $sheet->setFreeze('A2');

                 $sheet->row(1, array('Año','Edad Inicial','Fecha Inicial','Lote','Fecha Final','N° Inicial animales','N° Final animales','N° Muertes animales','N° Descarte animales','% Mortalidad','Peso Total Inicial(Kg)','Peso Promedio Inicial(Kg','Peso Total Final(Kg)','Peso Promedio Final(Kg)','Dias Permanencia','Edad Final','Ganancia de Peso Total por anima','Ganancia de Peso Animal por Dia','Consumo Total del Lote','Consumo Total Por Dia','Consumo Por Animal Por Dia','Convercion',
                    ));
                    $sheet->row(1, function($row) {
                    
                        $row->setBackground('#df0101');
                        $row->setFontWeight('bold');
                        $row->setAlignment('center');
                        $row->setFontColor('#ffffff');
                    });
                });
            })->export("xls");
 		}	
 	}
}

