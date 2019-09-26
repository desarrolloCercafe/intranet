<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Precebo;
use App\Http\Requests;

class PdfPreceboLoteController extends Controller
{
    /**
    * permite descargar un archivo PDF desde la vista tabla_dinamica.blade.php
    * de acuerdo a los parametros enviados desde la vista, luego se genera
    * una condicion de acuerdo a los parametros enviados desde la vista
    *
    * @var Precebo
    * @param Illuminate\Http\Request $request
    * @return $pdf->download('Reporte Precebo Anual.pdf') || $pdf->download('Reporte Precebo Mensual.pdf')
    */
    public function generar_reporte_precebo_lote(Request $request)
    {

        if ($request->parametro_hidden != null) {
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
            ->where('granja_id', $request->granja_hidden)
            ->where('año_traslado', $request->ano_hidden)
            ->whereIn('mes_traslado',[$request->parametro_hidden])
            ->get();

    
  
            $pdf = \PDF::loadView('admin.tabladinamica.tabla_dinamica_PDF', compact('precebo'))
            ->setPaper('legal', 'landscape');
            return $pdf->download('Reporte Precebo Mensual.pdf');
        }else{

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
            ->where('granja_id', $request->granja_hidden)
            ->where('año_traslado', $request->ano_hidden)
            ->get();

     
  
            $pdf = \PDF::loadView('admin.tabladinamica.tabla_dinamica_pdf', compact('precebo'))
            ->setPaper('legal', 'landscape');
            return $pdf->download('Reporte Precebo Anual.pdf');
        }
    }
}
