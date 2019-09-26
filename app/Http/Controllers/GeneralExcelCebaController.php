<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Granja;
use App\Ceba;
use App\Http\Requests;

class GeneralExcelCebaController extends Controller{
	/**
	* permite hacer una consulta a la base de datos para despues poder generar un archivo excel 
	* de acuerdo a los parametros enviados desde la vista GeneralPrecebo.blade.php
	*
	* @var Ceba
	* @param  \Illuminate\Http\Request  $request
	* @return archivo.xls
	*/
    public function ExcelCeba(Request $request){
    	if (count($request->meses) != 0) {
	    	$ceba = Ceba::join('granjas','granjas.id','=','formulario_ceba.granja_id')
	    	->select(
    			'nombre_granja',
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
	    	->where('año',[$request->ano_mes])
	    	->whereIn('mes',$request->meses)
	    	->where('granja_id',$request->granja_ceba)
	    	->get();

	    	$ceba=json_decode(json_encode($ceba),true);
            $titulo = 'Reporte Mensual por Lote Ceba';
            Excel::create($titulo, function($excel) use ($titulo, $ceba){   
                $excel->setTitle($titulo);
                $excel->setDescription('Informe de Ceba');

                $excel->sheet('Granjas', function($sheet) use ($titulo, $ceba){
       		         $sheet->fromArray($ceba, null, 'A1', true);
       		        $sheet->setAutoSize(true);
        	        $sheet->setFontSize(13);
        	        $sheet->setFreeze('A2');
                $sheet->row(1, array('Granja','Año','Edad Inicial','Fecha Inicial','Lote','Fecha Final','N° Inicial animales','N° Final animales','N° Muertes animales','N° Descarte animales','% Mortalidad','Peso Total Inicial(Kg)','Peso Promedio Inicial(Kg','Peso Total Final(Kg)','Peso Promedio Final(Kg)','Dias Permanencia','Edad Final','Ganancia de Peso Total por anima','Ganancia de Peso Animal por Dia','Consumo Total del Lote','Consumo Total Por Dia','Consumo Por Animal Por Dia','Convercion',
                    ));

                    $sheet->row(1, function($row) {
                    
                        $row->setBackground('#df0101');
                        $row->setFontWeight('bold');
                        $row->setAlignment('center');
                        $row->setFontColor('#ffffff');
                       
                    });
                });
            })->export("xls");
	    }else{
	    	$ceba = Ceba::join('granjas','granjas.id','=','formulario_ceba.granja_id')
	    	->select(
				'nombre_granja',
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
	    	->where('año',[$request->ano_mes])
	    	->where('granja_id',$request->granja_ceba)
	    	->get();
	    
	    	$ceba=json_decode(json_encode($ceba),true);
            $titulo = 'Reporte Anual por Lote Ceba';
            Excel::create($titulo, function($excel) use ($titulo, $ceba){   
                $excel->setTitle($titulo);
                $excel->setDescription('Informe de Ceba');

                $excel->sheet('Granjas', function($sheet) use ($titulo, $ceba){
                    $sheet->fromArray($ceba, null, 'A1', true);
                    $sheet->setAutoSize(true);
                    $sheet->setFontSize(13);
                    $sheet->setFreeze('A2');

                     $sheet->row(1, array('Granja','Año','Edad Inicial','Fecha Inicial','Lote','Fecha Final','N° Inicial animales','N° Final animales','N° Muertes animales','N° Descarte animales','% Mortalidad','Peso Total Inicial(Kg)','Peso Promedio Inicial(Kg','Peso Total Final(Kg)','Peso Promedio Final(Kg)','Dias Permanencia','Edad Final','Ganancia de Peso Total por anima','Ganancia de Peso Animal por Dia','Consumo Total del Lote','Consumo Total Por Dia','Consumo Por Animal Por Dia','Convercion',
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
