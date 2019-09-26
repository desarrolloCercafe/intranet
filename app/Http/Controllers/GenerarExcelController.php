<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Auth;
use App\Granja;
use App\Precebo;
use App\Http\Requests;

class GenerarExcelController extends Controller{
    /**
    * permite hacer una consulta a la base de datos para despues poder generar un archivo excel 
    * de acuerdo a los parametros enviados desde la vista tabla_dinamica.blade.php
    *
    * @var Precebo
    * @param \Illuminate\Http\Request  $request
    * @return Reporte Mensual de Precebo.xls || Reporte Anual de Precebo.xls
    */
	public function excel (Request $request){
        if (count($request->parametros) != 0) {
           $precebo = Precebo::select(
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
            ->where('año_traslado',[$request->ano])
            ->whereIn('mes_traslado',$request->parametros)
            ->where('granja_id',$request->granja)
            ->get();
           
            $precebo=json_decode(json_encode($precebo),true);
            $titulo = 'Reporte Mensual de Precebo';
            Excel::create($titulo, function($excel) use ($titulo, $precebo){   
                $excel->setTitle($titulo);
                $excel->setDescription('Tabla de las granjas');

                $excel->sheet('Granjas', function($sheet) use ($titulo, $precebo){
                    $sheet->fromArray($precebo, null, 'A1', true);
                    $sheet->setAutoSize(true);
                    $sheet->setFontSize(13);
                    $sheet->setFreeze('A2');

                    $sheet->row(1, array(
                       'EDAD INICIAL', 'DIAS DE PERMANENCIA', 'EDAD FINAL','FECHA INICIAL','LOTE','FECHA FINAL','N° INICIAL DE ANIMALES','N° FINAL DE ANIMALES','N° MUERTOS DE ANIMALES','N° DESCARTES DE ANIMALES','% MORTALIDAD','PESO TOTAL INICIAL','PESO PROMEDIO INICIAL(KG)','PESO TOTAL FINAL(KG)','PESO PROMEDIO FINAL (KG)','GANANCIA DE PESO TOTAL DEL LOTE','GANANCIA DE PESO TOTAL POR ANIMAL','GANANCIA DE PESO POR ANIMAL  DIA','CONSUMO TOTAL DEL LOTE','CONSUMO TOTAL POR ANIMAL','CONSUMO TOTAL POR ANIMAL DIA',
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
            ->where('año_traslado',[$request->ano])
            ->where('granja_id',$request->granja)
            ->get();

         
            $precebo=json_decode(json_encode($precebo),true);
            $titulo = 'Reporte Anual de Precebo';
            Excel::create($titulo, function($excel) use ($titulo, $precebo){   
                $excel->setTitle($titulo);
                $excel->setDescription('Tabla de las granjas ');

                $excel->sheet('Granjas', function($sheet) use ($titulo, $precebo){
                    $sheet->fromArray($precebo, null, 'A1', true);
                    $sheet->setAutoSize(true);
                    $sheet->setFontSize(13);
                    $sheet->setFreeze('A2');

                    $sheet->row(1, array(
                        'EDAD INICIAL', 'DIAS DE PERMANENCIA', 'EDAD FINAL','FECHA INICIAL','LOTE','FECHA FINAL','N° INICIAL DE ANIMALES','N° FINAL DE ANIMALES','N° MUERTOS DE ANIMALES','N° DESCARTES DE ANIMALES','% MORTALIDAD','PESO TOTAL INICIAL','PESO PROMEDIO INICIAL(KG)','PESO TOTAL FINAL(KG)','PESO PROMEDIO FINAL (KG)','GANANCIA DE PESO TOTAL DEL LOTE','GANANCIA DE PESO TOTAL POR ANIMAL','GANANCIA DE PESO POR ANIMAL  DIA','CONSUMO TOTAL DEL LOTE','CONSUMO TOTAL POR ANIMAL','CONSUMO TOTAL POR ANIMAL DIA',
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
