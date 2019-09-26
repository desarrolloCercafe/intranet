<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Granja;
use App\Precebo;
use App\Ceba;
use App\Http\Requests;

class ConsolidacionCercafeController extends Controller
{
	/**
     * permite descargar un archivo de excel de acuerdo a los paramaetros que se esten enviando 
     * en la vista ConsolidadoGeneral.blade.php
     *
     * @var Precebo
     * @param \Illuminate\Http\Request  $request
     * @return archivo.xls
     */
    public function ConsolidadoExcel(Request $request){
   		if ($request->option == 1) {
	   		if (count($request->parametros) != 0){
		   		$Consolidacion = Precebo::select(
					'año_traslado',
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
				->where('año_traslado',[$request->ano])
				->whereIn('mes_traslado',$request->parametros)
		        ->get();

				$Consolidacion=json_decode(json_encode($Consolidacion),true);
		        $titulo = 'Consolidacon Mensual Precebo';
		        Excel::create($titulo, function($excel) use ($titulo, $Consolidacion){   
		            $excel->setTitle($titulo);
		            $excel->setDescription('Tabla de las granjas');

		            $excel->sheet('Granjas', function($sheet) use ($titulo, $Consolidacion){
		                $sheet->fromArray($Consolidacion, null, 'A1', true);
		                $sheet->setAutoSize(true);
		                $sheet->setFontSize(13);
		                $sheet->setFreeze('A2');

		                $sheet->row(1, array(
		                   'Año Traslado','EDAD INICIAL', 'DIAS DE PERMANENCIA', 'EDAD FINAL','N° INICIAL DE ANIMALES','N° FINAL DE ANIMALES','N° MUERTOS DE ANIMALES','N° DESCARTES DE ANIMALES','% MORTALIDAD','PESO TOTAL INICIAL','PESO PROMEDIO INICIAL(KG)','PESO TOTAL FINAL(KG)','PESO PROMEDIO FINAL (KG)','GANANCIA DE PESO TOTAL DEL LOTE','GANANCIA DE PESO TOTAL POR ANIMAL','GANANCIA DE PESO POR ANIMAL  DIA','CONSUMO TOTAL DEL LOTE','CONSUMO TOTAL POR ANIMAL','CONSUMO TOTAL POR ANIMAL DIA',
		                ));
		                $sheet->row(1, function($row) {
		                
		                    $row->setBackground('#df0101');
		                    $row->setFontWeight('bold');
		                    $row->setAlignment('center');
		                });
		            });
		        })->export("xls");
	   		}else{
	   			$Consolidacion = Precebo::select(
					'año_traslado',
					
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
				->where('año_traslado',[$request->ano])
		        ->get();

				$Consolidacion=json_decode(json_encode($Consolidacion),true);
		        $titulo = 'Consolidacion Anual de Precebo';
		        Excel::create($titulo, function($excel) use ($titulo, $Consolidacion){   
		            $excel->setTitle($titulo);
		            $excel->setDescription('Tabla de las granjas');

		            $excel->sheet('Granjas', function($sheet) use ($titulo, $Consolidacion){
		                $sheet->fromArray($Consolidacion, null, 'A1', true);
		                $sheet->setAutoSize(true);
		                $sheet->setFontSize(13);
		                $sheet->setFreeze('A2');

		                $sheet->row(1, array(
		                   'Año Traslado','EDAD INICIAL', 'DIAS DE PERMANENCIA', 'EDAD FINAL','N° INICIAL DE ANIMALES','N° FINAL DE ANIMALES','N° MUERTOS DE ANIMALES','N° DESCARTES DE ANIMALES','% MORTALIDAD','PESO TOTAL INICIAL','PESO PROMEDIO INICIAL(KG)','PESO TOTAL FINAL(KG)','PESO PROMEDIO FINAL (KG)','GANANCIA DE PESO TOTAL DEL LOTE','GANANCIA DE PESO TOTAL POR ANIMAL','GANANCIA DE PESO POR ANIMAL  DIA','CONSUMO TOTAL DEL LOTE','CONSUMO TOTAL POR ANIMAL','CONSUMO TOTAL POR ANIMAL DIA',
		                ));
		                $sheet->row(1, function($row) {
		                
		                    $row->setBackground('#df0101');
		                    $row->setFontWeight('bold');
		                    $row->setAlignment('center');
		                });
		            });
		        })->export("xls");
	   		}
   	}else if ($request->option == 2) {
   		if (count($request->parametros) != 0){
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
	    	->where('granja_id',$request->granja)
	    	->where('año',[$request->ano])
	   		->whereIn('mes',$request->parametros)
	    	->get();

	    	$ceba=json_decode(json_encode($ceba),true);
            $titulo = 'Consolidado Mensual Ceba';
            Excel::create($titulo, function($excel) use ($titulo, $ceba){   
                $excel->setTitle($titulo);
                $excel->setDescription('Informe de Ceba');

                $excel->sheet('Granjas', function($sheet) use ($titulo, $ceba){
                    $sheet->fromArray($ceba, null, 'A1', true);
                    $sheet->setAutoSize(true);
                    $sheet->setFontSize(13);
                    $sheet->setFreeze('A2');

                    $sheet->row(1, array(
                           'Año','Edad Inicial','N° Inicial animales','N° Final animales','N° Muertes animales','N° Descarte animales','% Mortalidad','Peso Total Inicial(Kg)','Peso Promedio Inicial(Kg','Peso Total Final(Kg)','Peso Promedio Final(Kg)','Dias Permanencia','Edad Final','Ganancia total de Peso Lote','Ganancia de Peso Total por anima','Ganancia de Peso Animal por Dia','Consumo Total del Lote','Consumo Total Por Dia','Consumo Por Animal Por Dia','Convercion',
                    ));

                    $sheet->row(1, function($row) {
                    
                        $row->setBackground('#df0101');
                        $row->setFontWeight('bold');
                        $row->setAlignment('center');
                    });
                });
            })->export("xls");
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
		    	->where('granja_id',$request->granja)
		    	->where('año',[$request->ano])
		    	->get();

		    	$ceba=json_decode(json_encode($ceba),true);
	            $titulo = 'Consolidado Anual Ceba';
	            Excel::create($titulo, function($excel) use ($titulo, $ceba){   
	                $excel->setTitle($titulo);
	                $excel->setDescription('Informe de Ceba');

	                $excel->sheet('Granjas', function($sheet) use ($titulo, $ceba){
	                    $sheet->fromArray($ceba, null, 'A1', true);
	                    $sheet->setAutoSize(true);
	                    $sheet->setFontSize(13);
	                    $sheet->setFreeze('A2');

	                    $sheet->row(1, array(
	                          'Año','Edad Inicial','N° Inicial animales','N° Final animales','N° Muertes animales','N° Descarte animales','% Mortalidad','Peso Total Inicial(Kg)','Peso Promedio Inicial(Kg','Peso Total Final(Kg)','Peso Promedio Final(Kg)','Dias Permanencia','Edad Final','Ganancia total de Peso Lote','Ganancia de Peso Total por anima','Ganancia de Peso Animal por Dia','Consumo Total del Lote','Consumo Total Por Dia','Consumo Por Animal Por Dia','Convercion',
	                    ));
	                    $sheet->row(1, function($row) {
	                    
	                        $row->setBackground('#df0101');
	                        $row->setFontWeight('bold');
	                        $row->setAlignment('center');
	                    });
	                });
	            })->export("xls");
   		 	}
   		}		
    }
}
