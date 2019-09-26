<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Maatwebsite\Excel\Facades\Excel;
use App\PedidoMedicamento;
use App\PedidoConcentrado;
use App\PedidoInsumoServicio;
use App\PedidoCia;
use App\ConsecutivoMedicamento;
use App\ConsecutivoConcentrado;
use App\ConsecutivoCia;
use DB;
use App\DesteteFinalizacion;
use Auth;
use Carbon\Carbon;
use App\DestetosSemana;
use App\Medicamento; 
use App\InsumoServicios;
use App\Concentrado;
use App\ProductoCia;
use App\Estado; 
use App\Ceba;
use App\Precebo; 
use App\Granja;
use App\Alimento;
use App\CausaMuerte;
use App\AsociacionGranja;
use App\IvaConcentrado;
use App\Iva;
use App\ReporteMortalidadPreceboCeba;
use App\Http\Requests;

class ExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
    * permite generar el archivo excel de la vista list_cebas.blade.php
    * @var DB
    * @return Reporte Completo de Ceba.csv
    */
    public function generateCebasExcel()
    {
    	Excel::create('Reporte Completo de Ceba', function($excel) 
        {
            $cebas = DB::table('formulario_ceba')
                ->join('granjas', 'formulario_ceba.granja_id', '=', 'granjas.id')
                ->select('lote','granjas.nombre_granja as NombreGranja', 'fecha_ingreso_lote as FechaIngreso','fecha_salida_lote as FechaSalida', 'año as anno', 'mes', 'semana', 'inic','cerdos_descartados as Descartes', 'cerdos_livianos as Livianos', 'muertes', 'cant_final_cerdos as CantidadFinalCerdos', 'edad_inicial as EdadInicial', 'edad_inicial_total as EdadInicialTotal', 'dias', 'dias_permanencia as DiasPermanencia', 'edad_final as EdadFinal', 'edad_final_total as EdadFinalTotal', 'conf_edad_final as ConfEdadFinal', 'por_mortalidad as Mortalidad%', 'por_descartes as Descartes%', 'por_livianos as Livianos%', 'peso_total_ingresado as PesoIngresado', 'peso_promedio_ingresado as PesoPromedioIngresado', 'peso_total_vendido as PesoVendido', 'peso_promedio_vendido as PesoPromedioVendido', 'consumo_lote as ConsumoLote', 'consumo_promedio_lote as ConsumoPromedioLote', 'consumo_promedio_lote_dias as ConsumoPromedioDias','cons_promedio_ini as ConsumoPromedioInicial','cons_promedio_dia_ini as ConsumoPromedioDiasInicial','cons_ajustado_ini as ConsumoAjustadoInicial','ato_promedio_ini as AumentoPromedioInicial','ato_promedio_dia_ini as AumentoPromedioDiasInicial','conversion_ini as ConversionInicial','conversion_ajust_ini as ConversionAjustadaInicial','cons_ajustado_fin as ConsumoAjustadoFinal','ato_promedio_fin as AumentoPromedioFinal','ato_promedio_dia_fin as AumentoPromedioDiasFinal','conversion_fin as ConversionFinal','conversion_ajust_fin as ConversionAjustadaFinal')
                ->get();
            $cebas = json_decode(json_encode($cebas), true);

            $excel->sheet('Cebas', function($sheet) use($cebas)
            {
                $sheet->fromArray($cebas);
            });
        })->export('csv');
    }
    /**
    * permite el archivo excel desde la vista list_reporte_mortalidad_precebo_ceba
    *
    * @var DB
    * @return Reporte de mortalidad.csv
    */
    public function generateReporteMortalidadExcel()
    {
    	Excel::create('Reporte de Mortalidad', function($excel) 
        {
        	$reportes = DB::table('formulario_mortalidad_precebo_ceba')
    	 		->join('granjas', 'formulario_mortalidad_precebo_ceba.granja_id', '=', 'granjas.id')
        		->join('alimentos', 'formulario_mortalidad_precebo_ceba.alimento_id', '=', 'alimentos.id')
                ->join('causas_muerte', 'formulario_mortalidad_precebo_ceba.causa_id', '=', 'causas_muerte.id')
                ->select('granjas.nombre_granja as NombreGranja', 'lote', 'sala', 'numero_cerdos as #Cerdos', 'sexo_cerdo as Sexo', 'peso_cerdo as Peso', 'fecha as Fecha', 'dia_muerte as Dia', 'año_muerte as Anno', 'mes_muerte as Mes', 'semana_muerte as Semana', 'edad_cerdo as Edad', 'causa as Causa', 'nombre_alimento as Alimento')
                ->get();
            $reportes = json_decode(json_encode($reportes), true);

            $excel->sheet('ReporteMortalidadPreceboCeba', function($sheet) use($reportes)
            {
                $sheet->fromArray($reportes);
            });
        })->export('csv');
    }

    /**
    * permite descargar el archivo proveniente de la vista list_precebos.blade.php
    *
    * @var DB
    * @return Reporte completo de precebo.csv
    */
    public function generatePrecebosExcel()
    {
        Excel::create('Reporte Completo de Precebo', function($excel) 
        {
            
            $precebos = DB::table('formulario_precebo')   
                ->join('granjas', 'formulario_precebo.granja_id', '=', 'granjas.id')
                ->select('granjas.nombre_granja as NombreGranja', 'lote', 'fecha_destete as FechaDestete','fecha_traslado as FechaTraslado', 'semana_destete as SemanaDestete', 'semana_traslado as SemanaTraslado', 'año_destete as AnnoDestete', 'año_traslado as AnnoTraslado', 'mes_traslado as MesTraslado', 'numero_inicial as #Inicial','edad_destete as EdadDestete', 'edad_inicial_total as EdadInicialTotal', 'dias_jaulon as DiasJau', 'dias_totales_permanencia as DiasTotalesPermanencia', 'edad_final as EdadFinal', 'edad_final_ajustada as EdadFinalAjustada', 'peso_esperado as PesoEsperado', 'numero_muertes as #Muertes', 'numero_descartes as #Descartes', 'numero_livianos as #Livianos', 'numero_final as #Final', 'porciento_mortalidad as Mortalidad%', 'porciento_descartes as Descartes%', 'porciento_livianos as Livianos%', 'peso_ini as PesoInicial', 'peso_promedio_ini as PesoPromedioInicial', 'peso_ponderado_ini as PesoPonderadoInicial', 'peso_fin as PesoFinal', 'peso_promedio_fin as PesoPromedioFinal', 'peso_ponderado_fin as PesoPonderadoFinal', 'ind_peso_final as INDPesoFinal', 'cons_total as ConsumoTotal', 'cons_promedio as ConsumoPromedio', 'cons_ponderado as ConsumoPonderado', 'cons_promedio_dia as ConsumoPromedioDias', 'cons_promedio_ini as ConsumoPromedioInicial', 'cons_ponderado_ini as ConsumoPonderadoInicial', 'cons_promedio_dia_ini as ConsumoPromedioDiasInicial', 'cons_ajustado_ini as ConsumoAjustadoInicial', 'ato_promedio_ini as AumentoPromedioInicial', 'ato_promedio_dia_ini as AumentoPromedioDiasInicial', 'conversion_ini as ConversionInicial', 'conversion_ajust_ini as ConversionAjustadaInicial', 'cons_ajustado_fin as ConsumoAjustadoFinal', 'ato_promedio_fin as AumentoPromedioFinal', 'ato_promedio_dia_fin as AumentoPromedioDiasFinal', 'conversion_fin as ConversionFinal', 'conversion_ajust_fin as ConversionAjustadaFinal')
                ->get();
            $precebos = json_decode(json_encode($precebos), true);

            $excel->sheet('Precebos', function($sheet) use($precebos)
            {
                $sheet->fromArray($precebos);
            });
        })->export('csv');
    }

    /**
    * Permite descargar el archivo proveniente de la vista list_destete_finalizacion.blade.php
    *
    * @var DB
    * @return Reporte Completo de Destete Finalizado.csv 
    */
    public function generateDesteteFinalizacionExcel()
    {
        Excel::create('Reporte Completo de Destete Finalizado', function($excel) 
        {
            
            $destetes = DB::table('formulario_destete_finalizacion')
                    ->join('granjas', 'formulario_destete_finalizacion.granja_id', '=', 'granjas.id')
                    ->select('lote','granjas.nombre_granja as NombreGranja', 'fecha_ingreso_lote as FechaIngreso','fecha_salida_lote as FechaSalida', 'año as anno', 'mes', 'semana', 'inic','cerdos_descartados as Descartes', 'cerdos_livianos as Livianos', 'muertes', 'cant_final_cerdos as CantidadFinalCerdos', 'meta_cerdos as Meta', 'edad_inicial as EdadInicial', 'edad_inicial_total as EdadInicialTotal', 'dias', 'dias_permanencia as DiasPermanencia', 'edad_final as EdadFinal', 'edad_final_total as EdadFinalTotal', 'conf_edad_final as ConfEdadFinal', 'por_mortalidad as Mortalidad%', 'por_descartes as Descartes%', 'por_livianos  as Livianos%', 'peso_total_ingresado as PesoIngresado', 'peso_promedio_ingresado as PesoPromedioIngresado', 'peso_total_vendido as PesoVendido', 'peso_promedio_vendido as PesoPromedioVendido', 'consumo_lote as ConsumoLote', 'consumo_promedio_lote as ConsumoPromedioLote', 'consumo_promedio_lote_dias as ConsumoPromedioDias','cons_promedio_ini as ConsumoPromedioInicial','cons_promedio_dia_ini as ConsumoPromedioDiasInicial','ato_promedio as AumentoPromedio','ato_promedio_dia as AumentoPromedioDias','conversion')
                    ->get();
            $destetes = json_decode(json_encode($destetes), true);

            $excel->sheet('DesteteFinalizacion', function($sheet) use($destetes)
            {
                $sheet->fromArray($destetes);
            });
        })->export('csv');
    }

    /**
    * permite descargar el archivo proveniente de la vista list_destetos_semana.blade.php
    *
    * @var DB
    * @return Reporte Completo de Destetos por Semana.csv
    */
    public function generateReporteDestetosExcel()
    {
        Excel::create('Reporte Completo de Destetos por Semana', function($excel) 
        {
            
            $destetos_semana = DB::table('formulario_destetos_semana')
                    ->join('granjas', 'formulario_destetos_semana.granja_cria_id', '=', 'granjas.id')
                    ->select('granjas.nombre_granja as NombreGranjaCria', 'lote', 'año_destete as AnnoDestete', 'semana_destete as SemanaDestete', 'numero_destetos as #Destetos', 'mortalidad_precebo as Mortalidad%Precebo', 'traslado_a_ceba as TrasladoCeba','cantidad_a_ceba as CantidadCeba', 'mortalidad_ceba as Mortalidad%Ceba', 'semana_venta as SemanaVenta', 'año_venta as AnnoVenta', 'disponibilidad_venta as DisponibilidadVenta', 'kilos_venta as KilosVenta', 'semana_1_fase_1 as Semana1Fase1', 'consumo_semana_1_fase_1 as ConsumoSemana1Fase1', 'semana_2_fase_1 as Semana2Fase1', 'consumo_semana_2_fase_1 as ConsumoSemana2Fase1', 'semana_1_fase_2 as Semana1Fase2', 'consumo_semana_1_fase_2 as ConsumoSemana1Fase2', 'semana_2_fase_2 as Semana2Fase2', 'consumo_semana_2_fase_2 as ConsumoSemana2Fase2', 'semana_1_fase_3 as Semana1Fase3', 'consumo_semana_1_fase_3 as ConsumoSemana1Fase3', 'semana_2_fase_3 as Semana2Fase3', 'consumo_semana_2_fase_3 as ConsumoSemana2Fase3', 'semana_3_fase_3 as Semana3Fase3', 'consumo_semana_3_fase_3 as ConsumoSemana3Fase3', 'semana_1_iniciacion as Semana1Iniciacion', 'consumo_semana_1_iniciacion as ConsumoSemana1Iniciacion','semana_2_iniciacion as Semana2Iniciacion', 'consumo_semana_2_iniciacion as ConsumoSemana2Iniciacion', 'semana_1_levante as Semana1Levante', 'consumo_semana_1_levante as ConsumoSemana1Levante', 'semana_2_levante as Semana2Levante', 'consumo_semana_2_levante as ConsumoSemana2Levante', 'semana_3_levante as Semana3Levante', 'consumo_semana_3_levante as ConsumoSemana3Levante', 'semana_4_levante as Semana4Levante', 'consumo_semana_4_levante as ConsumoSemana4Levante', 'semana_1_engorde_1 as Semana1Engorde1', 'consumo_semana_1_engorde_1 as ConsumoSemana1Engorde1', 'semana_2_engorde_1 as Semana2Engorde1', 'consumo_semana_2_engorde_1 as ConsumoSemana2Engorde1', 'semana_1_engorde_2 as Semana1Engorde2', 'consumo_semana_1_engorde_2 as ConsumoSemana1Engorde2', 'semana_2_engorde_2 as Semana2Engorde2', 'consumo_semana_2_engorde_2 as ConsumoSemana2Engorde2', 'semana_3_engorde_2 as Semana3Engorde2', 'consumo_semana_3_engorde_2 as ConsumoSemana3Engorde2', 'semana_4_engorde_2 as Semana4Engorde2', 'consumo_semana_4_engorde_2 as ConsumoSemana4Engorde2')
                    ->get();
             $destetos_semana = json_decode(json_encode( $destetos_semana), true);

            $excel->sheet('DestetosSemana', function($sheet) use($destetos_semana)
            {
                $sheet->fromArray( $destetos_semana);
            });
        })->export('csv');
    }
    /**
    * permite descargar un archivo que proviene de la vista list_pedido_medicamento.blade.php
    *
    * @var Granja
    * @var PedidoMedicamento
    * @var PedidoInsumoServicio
    * @var Medicamento
    * @var InsumoServicios
    * @param int $cons
    * @return Pedido PME $cons.csv
    */
    public function porPedido($cons)
    {
        Excel::create('Pedido PME'.$cons, function($excel) use($cons)
        { 
            $granjas = Granja::all();
            $productos_solicitados = PedidoMedicamento::all();
            $productos_solicitados_insumos = PedidoInsumoServicio::all();
            $medicamentos = Medicamento::all();
            $insumos = InsumoServicios::all();
            $cont = 1;
            $consecutivos = ConsecutivoMedicamento::all();

            foreach ($productos_solicitados as $producto)
            {
                if($producto->consecutivo_pedido == $cons)
                {
                    foreach ($granjas as $granja)
                    {
                        if ($producto->granja_id == $granja->id) 
                        {
                            $granja_pedido = $granja->nombre_granja;
                        }
                    } 
                    foreach ($medicamentos as $medicamento) 
                    {
                        if($producto->medicamento_id == $medicamento->id) 
                        {
                            $medicamentos_solicitados[$medicamento->id]['codigo'] = $medicamento->ref_medicamento;
                            $medicamentos_solicitados[$medicamento->id]['nombre'] = $medicamento->nombre_medicamento;
                            $medicamentos_solicitados[$medicamento->id]['cantidad'] = $producto->unidades;
                            foreach ($consecutivos as $consecutivo)
                            {
                                if($producto->consecutivo_pedido == $consecutivo->consecutivo)
                                {
                                    if ($consecutivo->tipo_pedido == 1) 
                                    {
                                       $medicamentos_solicitados[$medicamento->id]['tipo_pedido'] = 'Mensual';
                                    }
                                    else
                                    {
                                        $medicamentos_solicitados[$medicamento->id]['tipo_pedido'] = 'Adicional';
                                    }
                                }
                            }
                           
                        }
                    }
                }
                else
                {
                    $cont++; 
                }
            }
            if ($cont != 1) 
            {
                foreach ($productos_solicitados_insumos as $producto_insumo)
                {
                    if($producto_insumo->consecutivo_pedido == $cons)
                    {
                        foreach ($granjas as $granja) 
                        {
                            if ($producto_insumo->granja_id == $granja->id) 
                            {
                                $granja_pedido = $granja->nombre_granja;
                            }
                        }
                        foreach ($insumos as  $insumo) 
                        {
                            if($insumo->id == $producto_insumo->insumo_servicio_id) 
                            {
                                $medicamentos_solicitados[$insumo->id]['codigo'] = $insumo->ref_insumo;
                                $medicamentos_solicitados[$insumo->id]['nombre'] = $insumo->nombre_insumo;
                                $medicamentos_solicitados[$insumo->id]['cantidad'] = $producto_insumo->unidades;
                                foreach ($consecutivos as $consecutivo) 
                                {
                                    if($producto_insumo->consecutivo_pedido == $consecutivo->consecutivo)
                                    {
                                        if ($consecutivo->tipo_pedido == 1) 
                                        {
                                           $medicamentos_solicitados[$insumo->id]['tipo_pedido'] = 'Mensual';
                                        }
                                        else
                                        {
                                            $medicamentos_solicitados[$insumo->id]['tipo_pedido'] = 'Adicional';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $medicamentos_solicitados = json_decode(json_encode($medicamentos_solicitados), true);

            $excel->sheet('pedidoMedicamentos', function($sheet) use($medicamentos_solicitados, $granja_pedido, $cons)
            {
                $sheet->mergeCells('A1:C1');
                $sheet->row(1, ['Granja: ' . $granja_pedido . '              Consecutivo: ' . 'PME'.$cons]);
                $sheet->row(2, ['Codigo', 'Nombre del Producto', 'cantidad', 'tipo pedido']);

                foreach ($medicamentos_solicitados as $m_solicitado) 
                {
                    $row = [];
                    $row[0] = $m_solicitado['codigo'];
                    $row[1] = $m_solicitado['nombre'];
                    $row[2] = $m_solicitado['cantidad'];
                    $row[3] = $m_solicitado['tipo_pedido'];
                    $sheet->appendRow($row);
                }   
            }); 
        })->export('csv');
    }
    /**
    * permite descargar el pedido seleccionado desde la vista list_pedidos_concentrados.blade.php
    *
    * @var Granja
    * @var PedidoConcentrado
    * @var Concentrado
    * @param int $cons
    * @return Pedido PCO $cons.csv
    *
    */ 
    public function porPedidoConcentrado($cons)
    {
        Excel::create('Pedido PCO'.$cons, function($excel) use($cons)
        { 
            $granjas = Granja::all();
            $productos_solicitados = PedidoConcentrado::all();
            $concentrados = Concentrado::all();

            foreach ($productos_solicitados as $producto)
            {
                if($producto->consecutivo_pedido == $cons)
                {
                    foreach ($granjas as $granja) 
                    {
                        if ($producto->granja_id == $granja->id) 
                        {
                            $granja_pedido = $granja->nombre_granja;
                        }
                    }
                    foreach ($concentrados as $concentrado) 
                    {
                        if($producto->concentrado_id == $concentrado->id) 
                        {
                            $concentrados_solicitados[$concentrado->id]['codigo'] = $concentrado->ref_concentrado;
                            $concentrados_solicitados[$concentrado->id]['nombre'] = $concentrado->nombre_concentrado;
                            $concentrados_solicitados[$concentrado->id]['bultos'] = $producto->no_bultos;
                            $concentrados_solicitados[$concentrado->id]['kilos'] = $producto->no_kilos;
                            $concentrados_solicitados[$concentrado->id]['fecha_entrega'] = $producto->fecha_entrega;
                        }
                    }
                }
            }
            $concentrados_solicitados = json_decode(json_encode($concentrados_solicitados), true);

            $excel->sheet('pedidoConcentrados', function($sheet) use($concentrados_solicitados, $granja_pedido, $cons)
            {
                $sheet->mergeCells('A1:C1');
                $sheet->row(1, ['Granja: ' . $granja_pedido . '              Consecutivo: ' . 'PCO'.$cons]);
                $sheet->row(2, ['Codigo', 'Nombre del Concentrado', '# Bultos', '# Kilos', 'Fecha de Entrega']);

                foreach ($concentrados_solicitados as $c_solicitado) 
                {
                    $row = [];
                    $row[0] = $c_solicitado['codigo'];
                    $row[1] = $c_solicitado['nombre'];
                    $row[2] = $c_solicitado['bultos'];
                    $row[3] = $c_solicitado['kilos'];
                    $row[4] = $c_solicitado['fecha_entrega'];
                    $sheet->appendRow($row);
                }
            });
        })->export('csv');
    } 
    /**
    * permite descargar un archivo que se selecciona desde la vista list_pedido_cia.blade.php
    *
    * @var Granja
    * @var PedidoCia
    * @var ProductoCia
    * @param int $cons
    * @return Pedido PSE $cons.csv
    */
    public function porPedidoCia($cons)
   {
        Excel::create('Pedido PSE'.$cons, function($excel) use($cons)
        { 
            $granjas = Granja::all();
            $productos_solicitados = PedidoCia::all();
            $productos_cia = ProductoCia::all();

            foreach ($productos_solicitados as $producto)
            {
                if($producto->consecutivo_pedido == $cons)
                {
                    foreach ($granjas as $granja) 
                    {
                        if ($producto->granja_id == $granja->id) 
                        {
                            $granja_pedido = $granja->nombre_granja;
                        }
                    }
                    foreach ($productos_cia as $producto_cia) 
                    {
                        if($producto->producto_cia_id == $producto_cia->id) 
                        {
                            $productos_cia_solicitados[$producto_cia->id]['codigo'] = $producto_cia->ref_producto_cia;
                            $productos_cia_solicitados[$producto_cia->id]['nombre'] = $producto_cia->nombre_producto_cia;
                            $productos_cia_solicitados[$producto_cia->id]['dosis'] = $producto->dosis;
                            $productos_cia_solicitados[$producto_cia->id]['fecha_estimada'] = $producto->fecha_estimada;
                        }
                    }
                }
            }
            $productos_cia_solicitados = json_decode(json_encode($productos_cia_solicitados), true);

            $excel->sheet('pedidoProductosCia', function($sheet) use($productos_cia_solicitados, $granja_pedido, $cons)
            {

                $sheet->mergeCells('A1:C1');
                $sheet->row(1, ['Granja: ' . $granja_pedido . '              Consecutivo: ' . 'PSE'.$cons]);
                $sheet->row(2, ['Codigo', 'Nombre del Producto', 'dosis','fecha_estimada']);

                foreach ($productos_cia_solicitados as $p_solicitado) 
                {
                    $row = [];
                    $row[0] = $p_solicitado['codigo'];
                    $row[1] = $p_solicitado['nombre'];
                    $row[2] = $p_solicitado['dosis'];
                    $row[3] = $p_solicitado['fecha_estimada'];
                    $sheet->appendRow($row);
                }   
            });
        })->export('csv');
    } 
    /**
    * permite descargar el archivo desde la vista filtro_pedido_medicamentos.blade.php
    * dependiendo de los parametros que se envian desde la vista
    *
    * @var ConsecutivoMedicamento 
    * @var Granja 
    * @var Estado 
    * @var ConsecutivoMedicamento 
    * @param int $ini
    * @param int $fin
    * @param int $gr
    * @return Filtro de Pedidos Medicamentos.csv
    */
    public function filtroPorPedidos($ini,$fin,$gr)
    {
        Excel::create('Filtro Pedidos Medicamentos', function($excel) use($ini, $fin, $gr)
        {
            $peds = ConsecutivoMedicamento::whereBetween('fecha_creacion', [$ini, $fin])->get();
            $granjas = Granja::all();
            $estados = Estado::all();
            $pedidos = ConsecutivoMedicamento::all();
            foreach ($peds as $pe)
            {
                foreach ($granjas as $g)
                {
                    if ($pe->granja_id == $g->id)
                    {
                        if ($gr == $g->id) 
                        {
                            foreach ($estados as $estado)
                            {
                                if ($pe->estado_id == 2) 
                                {
                                    $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                                    $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                                    $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion;
                                    $pedidos_db[$pe->id]["estado"] = $estado->nombre_estado;
                                    if ($pe->tipo_pedido == 1) 
                                    {
                                        $pedidos_db[$pe->id]['tipo_pedido'] = 'Mensual';
                                    }
                                    else
                                    {
                                        $pedidos_db[$pe->id]['tipo_pedido'] = 'Adicional';
                                    }  
                                }
                            }
                        }
                        else if ($gr == '0')
                        {
                            foreach ($estados as $estado) 
                            {
                                if ($pe->estado_id == 2) 
                                {
                                    $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                                    $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                                    $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion;
                                    $pedidos_db[$pe->id]["estado"] = $estado->nombre_estado;
                                    if ($pe->tipo_pedido == 1)
                                    {
                                        $pedidos_db[$pe->id]['tipo_pedido'] = 'Mensual';
                                    }
                                    else
                                    { 
                                        $pedidos_db[$pe->id]['tipo_pedido'] = 'Adicional';
                                    } 
                                }
                            }
                        }
                    }
                }
            }
            $pedidos_db = json_decode(json_encode($pedidos_db), true);

            $excel->sheet('Pedidos', function($sheet) use($pedidos_db)
            {
                foreach ($pedidos_db as $pedido_db) 
                {
                    $sheet->row(1, ['Consecutivo', 'Granja', 'Fecha', 'Estado']);
                    $row = [];
                    $row[0] = 'PME'.$pedido_db['consecutivo'];
                    $row[1] = $pedido_db['granja'];
                    $row[2] = $pedido_db['fecha'];
                    $row[3] = $pedido_db['estado'];
                    $row[4] = $pedido_db['tipo_pedido'];
                    $sheet->appendRow($row);
                }
            });
        })->export('csv');
    }
    /**
    * permite descargar un archivo desde la vista filtro_pedido_medicamentos.blade.php
    * de acuerdo a los parametro que se le envian desde la vista
    *
    * @var Granja
    * @var Medicamento
    * @var InsumoServicios
    * @var PedidoMedicamento
    * @var PedidoInsumoServicio
    * @var ConsecutivoMedicamento
    * @param int $ini
    * @param int $fin
    * @param int $gr
    * @return Filtro de Productos.csv
    */
    public function filtroPorProductos($ini,$fin,$gr)
    {
        Excel::create('Filtro de Productos', function($excel) use($ini, $fin, $gr)
        {
            $granjas = Granja::all();
            $estados = Estado::all();
            $medicamentos = Medicamento::all();
            $insumos = InsumoServicios::all();
            $productos = PedidoMedicamento::all();
            $productos_insumos = PedidoInsumoServicio::all();
            $pedidos = ConsecutivoMedicamento::all(); 
            $prods = PedidoMedicamento::whereBetween('fecha_pedido', [$ini,$fin])->get();
            $prods_insumos = PedidoInsumoServicio::whereBetween('fecha_pedido_insumo', [$ini,$fin])->get();
            $productos_db = [];
            $productos_insumos_db = [];

            foreach ($prods as $pr)  
            {
                foreach ($granjas as $g) 
                {
                    if ($pr->granja_id == $g->id)
                    {
                        foreach ($medicamentos as $medicamento) 
                        {
                            if ($pr->medicamento_id == $medicamento->id) 
                            {
                                if ($gr == $g->id)
                                {
                                    $productos_db[$pr->id]["granja"] = $g->descripcion_granja;
                                    $productos_db[$pr->id]["nombre_granja"] = $g->nombre_granja;
                                    $productos_db[$pr->id]["tipo_documento"] = 'PET';
                                    $productos_db[$pr->id]["prefijo"] = 'WEB';
                                    $productos_db[$pr->id]["ref"] = $medicamento->ref_medicamento;
                                    $productos_db[$pr->id]["producto"] = $medicamento->nombre_medicamento;
                                    if( $medicamento->proveedor_1 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_1"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_1"] = $medicamento->proveedor_1;
                                    }

                                    if( $medicamento->proveedor_2 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_2"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_2"] = $medicamento->proveedor_2;
                                    }

                                    if( $medicamento->proveedor_2 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_3"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_3"] = $medicamento->proveedor_3;
                                    }
                                    if( $medicamento->proveedor_4 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_4"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_4"] = $medicamento->proveedor_4;
                                    }
                                    $productos_db[$pr->id]["fecha"] = $pr->fecha_pedido;
                                    $productos_db[$pr->id]["cantidad"] = $pr->unidades;
                                    $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                    $productos_db[$pr->id]["centro_costo"] = '05';
                                    $productos_db[$pr->id]["forma_pago"] = $g->forma_pago;
                                    $productos_db[$pr->id]["precio_medicamentos"] = $medicamento->precio_medicamento;
                                    $productos_db[$pr->id]["vendedor"] = '0';
                                    $productos_db[$pr->id]["bodega"] = 'XXX';
                                    $productos_db[$pr->id]["tipo_pedido"] = "Medicamentos";
                                    $origen = ConsecutivoMedicamento::where('consecutivo', $pr->consecutivo_pedido)->get();
                                    
                                    foreach($origen as $or)
                                    {
                                        if ($or->tipo_pedido == 1)  
                                        {  
                                            $productos_db[$pr->id]["tipo_solicitud"] = "Mensual";
                                        }
                                        else
                                        {
                                            $productos_db[$pr->id]["tipo_solicitud"] = "Adicional";
                                        }
                                    }
                                    foreach ($estados as $estado)
                                    {
                                        if($pr->estado_id == $estado->id)
                                        {
                                            $productos_db[$pr->id]["estado"] = $estado->nombre_estado;
                                        }
                                    }
                                }
                                else if ($gr == '0')
                                {
                                    $productos_db[$pr->id]["granja"] = $g->descripcion_granja;
                                    $productos_db[$pr->id]["nombre_granja"] = $g->nombre_granja;
                                    $productos_db[$pr->id]["tipo_documento"] = 'PET';
                                    $productos_db[$pr->id]["prefijo"] = 'WEM';
                                    $productos_db[$pr->id]["ref"] = $medicamento->ref_medicamento;
                                    $productos_db[$pr->id]["producto"] = $medicamento->nombre_medicamento;
                                    if( $medicamento->proveedor_1 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_1"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_1"] = $medicamento->proveedor_1;
                                    }

                                    if( $medicamento->proveedor_2 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_2"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_2"] = $medicamento->proveedor_2;
                                    }

                                    if( $medicamento->proveedor_2 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_3"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_3"] = $medicamento->proveedor_3;
                                    }
                                    if( $medicamento->proveedor_4 == null)
                                    {
                                        $productos_db[$pr->id]["proveedor_4"] = null;
                                    }
                                    else
                                    {
                                        $productos_db[$pr->id]["proveedor_4"] = $medicamento->proveedor_4;
                                    }
                                    $productos_db[$pr->id]["fecha"] = $pr->fecha_pedido;
                                    $productos_db[$pr->id]["cantidad"] = $pr->unidades;
                                    $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                    $productos_db[$pr->id]["centro_costo"] = '05';
                                    $productos_db[$pr->id]["forma_pago"] = $g->forma_pago;
                                    $productos_db[$pr->id]["precio_medicamentos"] = $medicamento->precio_medicamento;
                                    $productos_db[$pr->id]["vendedor"] = '0';
                                    $productos_db[$pr->id]["bodega"] = 'XXX';
                                    $productos_db[$pr->id]["tipo_pedido"] = "Medicamentos";

                                    $origen = ConsecutivoMedicamento::where('consecutivo', $pr->consecutivo_pedido)->get();
                                    
                                    foreach($origen as $or)
                                    {
                                        if ($or->tipo_pedido == 1) 
                                        {
                                            $productos_db[$pr->id]["tipo_solicitud"] = "Mensual";
                                        }
                                        else
                                        {
                                            $productos_db[$pr->id]["tipo_solicitud"] = "Adicional";
                                        }
                                    }
                                    foreach ($estados as $estado) 
                                    {
                                        if($pr->estado_id == $estado->id)
                                        {
                                            $productos_db[$pr->id]["estado"] = $estado->nombre_estado;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        
            foreach ($prods_insumos as $pr_insumo)  
            {
                foreach ($granjas as $g) 
                {
                    if ($pr_insumo->granja_id == $g->id)
                    {
                        foreach ($insumos as $insumo) 
                        {
                            if ($pr_insumo->insumo_servicio_id == $insumo->id) 
                            {
                                if ($gr == $g->id)
                                {
                                    $productos_insumos_db[$pr_insumo->id]["granja"] = $g->descripcion_granja;
                                    $productos_insumos_db[$pr_insumo->id]["nombre_granja"] = $g->nombre_granja;
                                    $productos_insumos_db[$pr_insumo->id]["tipo_documento"] = 'PET';
                                    $productos_insumos_db[$pr_insumo->id]["prefijo"] = 'WEB';
                                    $productos_insumos_db[$pr_insumo->id]["ref"] = $insumo->ref_insumo;
                                    $productos_insumos_db[$pr_insumo->id]["producto"] = $insumo->nombre_insumo;
                                    if( $insumo->proveedor_1 == null)
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_1"] = null;
                                    }
                                    else
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_1"] = $insumo->proveedor_1;
                                    }

                                    if( $insumo->proveedor_2 == null)
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_2"] = null;
                                    }
                                    else
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_2"] = $insumo->proveedor_2;
                                    }

                                    if( $insumo->proveedor_2 == null)
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_3"] = null;
                                    }
                                    else
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_3"] = $insumo->proveedor_3;
                                    }

                                    $productos_insumos_db[$pr_insumo->id]["fecha"] = $pr_insumo->fecha_pedido_insumo;
                                    $productos_insumos_db[$pr_insumo->id]["cantidad"] = $pr_insumo->unidades;
                                    $productos_insumos_db[$pr_insumo->id]["consecutivo"] = $pr_insumo->consecutivo_pedido;
                                    $productos_insumos_db[$pr_insumo->id]["centro_costo"] = '05';
                                    $productos_insumos_db[$pr_insumo->id]["forma_pago"] = $g->forma_pago;
                                    $productos_insumos_db[$pr_insumo->id]["precio_insumo"] = $insumo->precio_insumo;
                                    $productos_insumos_db[$pr_insumo->id]["vendedor"] = '0';
                                    $productos_insumos_db[$pr_insumo->id]["bodega"] = 'XXX';
                                    $productos_insumos_db[$pr_insumo->id]["tipo_pedido"] = "Insumos";
                                    $origen = ConsecutivoMedicamento::where('consecutivo', $pr_insumo->consecutivo_pedido)->get();
                                    
                                    foreach($origen as $or)
                                    {
                                        if ($or->tipo_pedido == 1) 
                                        {
                                            $productos_insumos_db[$pr_insumo->id]["tipo_solicitud"] = "Mensual";
                                        }
                                        else
                                        {
                                            $productos_insumos_db[$pr_insumo->id]["tipo_solicitud"] = "Adicional";
                                        }
                                    }
                                    foreach ($estados as $estado) 
                                    {
                                        if($pr_insumo->estado_id == $estado->id)
                                        {
                                            $productos_insumos_db[$pr_insumo->id]["estado"] = $estado->nombre_estado;
                                        }
                                    }
                                }
                                else if ($gr == '0') 
                                {
                                    $productos_insumos_db[$pr_insumo->id]["granja"] = $g->descripcion_granja;
                                    $productos_insumos_db[$pr_insumo->id]["nombre_granja"] = $g->nombre_granja;
                                    $productos_insumos_db[$pr_insumo->id]["tipo_documento"] = 'PET';
                                    $productos_insumos_db[$pr_insumo->id]["prefijo"] = 'WEM';
                                    $productos_insumos_db[$pr_insumo->id]["ref"] = $insumo->ref_insumo;
                                    $productos_insumos_db[$pr_insumo->id]["producto"] = $insumo->nombre_insumo;
                                    if( $insumo->proveedor_1 == null)
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_1"] = null;
                                    }
                                    else
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_1"] = $insumo->proveedor_1;
                                    }

                                    if( $insumo->proveedor_2 == null)
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_2"] = null;
                                    }
                                    else
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_2"] = $insumo->proveedor_2;
                                    }

                                    if( $insumo->proveedor_2 == null)
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_3"] = null;
                                    }
                                    else
                                    {
                                        $productos_insumos_db[$pr_insumo->id]["proveedor_3"] = $insumo->proveedor_3;
                                    }

                                    $productos_insumos_db[$pr_insumo->id]["fecha"] = $pr_insumo->fecha_pedido_insumo;
                                    $productos_insumos_db[$pr_insumo->id]["cantidad"] = $pr_insumo->unidades;
                                    $productos_insumos_db[$pr_insumo->id]["consecutivo"] = $pr_insumo->consecutivo_pedido;
                                    $productos_insumos_db[$pr_insumo->id]["centro_costo"] = '05';
                                    $productos_insumos_db[$pr_insumo->id]["forma_pago"] = $g->forma_pago;
                                    $productos_insumos_db[$pr_insumo->id]["precio_insumo"] = $insumo->precio_insumo;
                                    $productos_insumos_db[$pr_insumo->id]["vendedor"] = '0';
                                    $productos_insumos_db[$pr_insumo->id]["bodega"] = 'XXX';
                                    $productos_insumos_db[$pr_insumo->id]["tipo_pedido"] = "Insumos";
                                    $origen = ConsecutivoMedicamento::where('consecutivo', $pr_insumo->consecutivo_pedido)->get();
                                    
                                    foreach($origen as $or)
                                    {
                                        if ($or->tipo_pedido == 1) 
                                        {
                                            $productos_insumos_db[$pr_insumo->id]["tipo_solicitud"] = "Mensual";
                                        }
                                        else
                                        {
                                            $productos_insumos_db[$pr_insumo->id]["tipo_solicitud"] = "Adicional";
                                        }
                                    }
                                    foreach ($estados as $estado) 
                                    {
                                        if($pr_insumo->estado_id == $estado->id)
                                        {
                                            $productos_insumos_db[$pr_insumo->id]["estado"] = $estado->nombre_estado;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }  
            }

            if($productos_db != null   && $productos_insumos_db != null)
            {
                $productos_db = json_decode(json_encode($productos_db), true);
                $productos_insumos_db = json_decode(json_encode($productos_insumos_db), true);
                $excel->sheet('Productos', function($sheet) use($productos_db, $productos_insumos_db)
                {
                    $sheet->row(1, ['Fecha de Creacion', 'Tipo de Documento', 'Prefijo', 'Consecutivo','Nit', 'Granja','Vendedor', 'Forma de Pago', 'Referencia', 'Producto', 'Cantidad', 'Bodega', 'Centro de Costo', 'Precio', 'estado', 'Tipo de pedido', 'Tipo de Solicitud', 'Proveedor 1', 'Proveedor 2', 'Proveedor 3']);

                    foreach ($productos_db as $producto_db) 
                    {
                        $row = [];
                        $row[0] = $producto_db['fecha'];
                        $row[1] = $producto_db['tipo_documento'];
                        $row[2] = $producto_db['prefijo'];
                        $row[3] = $producto_db['consecutivo'];
                        $row[4] = $producto_db['granja'];
                        $row[5] = $producto_db['nombre_granja'];
                        $row[6] = $producto_db['vendedor'];
                        $row[7] = $producto_db['forma_pago'];
                        $row[8] = $producto_db['ref'];
                        $row[9] = $producto_db["producto"];
                        $row[10] = $producto_db['cantidad'];
                        $row[11] = $producto_db['bodega'];
                        $row[12] = $producto_db['centro_costo'];
                        $row[13] = $producto_db['precio_medicamentos'];
                        $row[14] = $producto_db['estado'];
                        $row[15] = $producto_db['tipo_pedido'];
                        $row[16] = $producto_db['tipo_solicitud'];
                        $row[17] = $producto_db['proveedor_1'];
                        $row[18] = $producto_db['proveedor_2'];
                        $row[19] = $producto_db['proveedor_3'];
                        $sheet->appendRow($row);
                    }
                    foreach ($productos_insumos_db as $producto_insumo_db) 
                    {
                        $row = [];
                        $row[0] = $producto_insumo_db['fecha'];
                        $row[1] = $producto_insumo_db['tipo_documento'];
                        $row[2] = $producto_insumo_db['prefijo'];
                        $row[3] = $producto_insumo_db['consecutivo'];
                        $row[4] = $producto_insumo_db['granja'];
                        $row[5] = $producto_insumo_db['nombre_granja'];
                        $row[6] = $producto_insumo_db['vendedor'];
                        $row[7] = $producto_insumo_db['forma_pago'];
                        $row[8] = $producto_insumo_db['ref'];
                        $row[9] = $producto_insumo_db["producto"];
                        $row[10] = $producto_insumo_db['cantidad'];
                        $row[11] = $producto_insumo_db['bodega'];
                        $row[12] = $producto_insumo_db['centro_costo'];
                        $row[13] = $producto_insumo_db['precio_insumo'];
                        $row[14] = $producto_insumo_db['estado'];
                        $row[15] = $producto_insumo_db['tipo_pedido'];
                        $row[16] = $producto_insumo_db['tipo_solicitud'];
                        $row[17] = $producto_insumo_db['proveedor_1'];
                        $row[18] = $producto_insumo_db['proveedor_2'];
                        $row[19] = $producto_insumo_db['proveedor_3'];

                        $sheet->appendRow($row);
                    }
                });
            }
            else if ($productos_db != null)
            {
                $productos_db = json_decode(json_encode($productos_db), true);
                $excel->sheet('Productos', function($sheet) use($productos_db)
                {
                    $sheet->row(1, ['Fecha de Creacion', 'Tipo de Documento', 'Prefijo', 'Consecutivo','Nit', 'Granja','Vendedor', 'Forma de Pago', 'Referencia', 'Producto', 'Cantidad', 'Bodega', 'Centro de Costo', 'Precio', 'estado', 'Tipo de Pedido', 'Tipo de Solicitud', 'Proveedor 1', 'Proveedor 2', 'Proveedor 3']);

                    foreach ($productos_db as $producto_db) 
                    {
                        $row = [];
                        $row[0] = $producto_db['fecha'];
                        $row[1] = $producto_db['tipo_documento'];
                        $row[2] = $producto_db['prefijo'];
                        $row[3] = $producto_db['consecutivo'];
                        $row[4] = $producto_db['granja'];
                        $row[5] = $producto_db['nombre_granja'];
                        $row[6] = $producto_db['vendedor'];
                        $row[7] = $producto_db['forma_pago'];
                        $row[8] = $producto_db['ref'];
                        $row[9] = $producto_db["producto"];
                        $row[10] = $producto_db['cantidad'];
                        $row[11] = $producto_db['bodega'];
                        $row[12] = $producto_db['centro_costo'];
                        $row[13] = $producto_db['precio_medicamentos'];
                        $row[14] = $producto_db['estado'];
                        $row[15] = $producto_db['tipo_pedido'];
                        $row[16] = $producto_db['tipo_solicitud'];
                        $row[17] = $producto_db['proveedor_1'];
                        $row[18] = $producto_db['proveedor_2'];
                        $row[19] = $producto_db['proveedor_3'];
                        $sheet->appendRow($row);
                    }
                });
            }
            else if($productos_insumos_db != null)
            {
                $productos_insumos_db = json_decode(json_encode($productos_insumos_db), true);
                $excel->sheet('Productos', function($sheet) use($productos_insumos_db)
                {
                    $sheet->row(1, ['Fecha de Creacion', 'Tipo de Documento', 'Prefijo', 'Consecutivo','Nit', 'Granja','Vendedor', 'Forma de Pago', 'Referencia', 'Producto', 'Cantidad', 'Bodega', 'Centro de Costo', 'Precio', 'estado', 'Tipo de Pedido', 'Tipo de Solicitud', 'Proveedor 1', 'Proveedor 2', 'Proveedor 3']);
                    foreach ($productos_insumos_db as $producto_insumo_db) 
                    {
                        $row = [];
                        $row[0] = $producto_insumo_db['fecha'];
                        $row[1] = $producto_insumo_db['tipo_documento'];
                        $row[2] = $producto_insumo_db['prefijo'];
                        $row[3] = $producto_insumo_db['consecutivo'];
                        $row[4] = $producto_insumo_db['granja'];
                        $row[5] = $producto_insumo_db['nombre_granja'];
                        $row[6] = $producto_insumo_db['vendedor'];
                        $row[7] = $producto_insumo_db['forma_pago'];
                        $row[8] = $producto_insumo_db['ref'];
                        $row[9] = $producto_insumo_db["producto"];
                        $row[10] = $producto_insumo_db['cantidad'];
                        $row[11] = $producto_insumo_db['bodega'];
                        $row[12] = $producto_insumo_db['centro_costo'];
                        $row[13] = $producto_insumo_db['precio_insumo'];
                        $row[14] = $producto_insumo_db['estado'];
                        $row[15] = $producto_insumo_db['tipo_pedido'];
                        $row[16] = $producto_insumo_db['tipo_solicitud'];
                        $row[17] = $producto_insumo_db['proveedor_1'];
                        $row[18] = $producto_insumo_db['proveedor_2'];
                        $row[19] = $producto_insumo_db['proveedor_3'];
                        $sheet->appendRow($row);
                    }  
                });
            }
        })->export('csv');
    } 
    /**
    * permite descargar un archivo desde la vista list_pedidos_concentrados.blade.php
    * de acuerdo a los parametros que se le envian
    *
    * @var Granja 
    * @var Estado 
    * @var ConsecutivoConcentrado 
    * @param int $ini
    * @param int $fin
    * @param int $gr
    * @return Filtro de Pedidos.csv 
    */

    public function filtroPorPedidosConcentrados($ini,$fin,$gr)
    {
        Excel::create('Filtro de Pedidos', function($excel) use($ini, $fin, $gr)
        {
            if(Auth::User()->rol_id == 7)
            {
                $peds = ConsecutivoConcentrado::whereBetween('fecha_creacion', [$ini, $fin])->get();
            }
            else
            {
                $peds = ConsecutivoConcentrado::whereBetween('fecha_entrega', [$ini, $fin])->get();
            }
           
            $granjas = Granja::all();
            $estados = Estado::all();
            $pedidos = ConsecutivoConcentrado::all();
            foreach ($peds as $pe) 
            {
                foreach ($granjas as $g)  
                {
                    if ($pe->granja_id == $g->id)
                    {
                        if ($gr == $g->id) 
                        {
                            $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                            $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                            $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion;
                            $pedidos_db[$pe->id]["fecha_entrega"] = $pe->fecha_entrega;
                            $pedidos_db[$pe->id]["conductor"] = $pe->conductor_asignado;
                            $pedidos_db[$pe->id]["vehiculo"] = $pe->vehiculo_asignado;      
                        }
                        else if ($gr == '0') 
                        {
                            $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                            $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                            $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion;
                            $pedidos_db[$pe->id]["fecha_entrega"] = $pe->fecha_entrega; 
                            $pedidos_db[$pe->id]["conductor"] = $pe->conductor_asignado;
                            $pedidos_db[$pe->id]["vehiculo"] = $pe->vehiculo_asignado;            
                        }
                    }
                }
            }

            $excel->sheet('Pedidos de Concentrado', function($sheet) use($pedidos_db)
            {
                foreach ($pedidos_db as $pedido_db)
                {
                    $sheet->row(1, ['Consecutivo', 'Granja', 'Fecha', 'Fecha de Entrega','Conductor', 'Vehiculo']);
                    $row = [];
                    $row[0] = 'PCO'.$pedido_db['consecutivo'];
                    $row[1] = $pedido_db['granja'];
                    $row[2] = $pedido_db['fecha'];
                    $row[3] = $pedido_db['fecha_entrega'];
                    $row[4] = $pedido_db['conductor'];
                    $row[5] = $pedido_db['vehiculo'];

                    $sheet->appendRow($row);
                }
            });
        })->export('csv');
    }
    /**
    * permite descargar un archivo desde la vista list_concentrados.blade.php
    * todos los productos que lleva actualmente la base de datos
    *
    * @var Granja
    * @var Concentrado
    * @var PedidoConcentrado
    * @var ConsecutivoConcentrado
    * @param int $ini
    * @param int $fin
    * @param int $gr
    * @return Filtro Productos Concentrado.csv
    */

    public function filtroPorProductosConcentrados($ini,$fin,$gr)
    {
        Excel::create('Filtro Productos Concentrado', function($excel) use($ini, $fin, $gr)
        {
            $granjas = Granja::all();
            $concentrados = Concentrado::all();
            $productos = PedidoConcentrado::all();
            $pedidos = ConsecutivoConcentrado::all();
            if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 9)
            {
                $prods = Pedidoconcentrado::whereBetween('fecha_creacion', [$ini,$fin])->get();
            }
            else
            {
                $prods = Pedidoconcentrado::whereBetween('fecha_entrega', [$ini,$fin])->get();
            }
            
            foreach ($prods as $pr)  
            {
                foreach ($granjas as $g) 
                {
                    if ($pr->granja_id == $g->id)
                    {
                        foreach ($concentrados as $concentrado) 
                        {
                            if ($pr->concentrado_id == $concentrado->id) 
                            {
                                $iva = IvaConcentrado::where('concentrado_id', '=', $concentrado->id)->first();
                                if ($gr == $g->id)
                                {
                                    $iva_seleccionado = Iva::find($iva->iva_id);
                                    $productos_db[$pr->id]["granja"] = $g->descripcion_granja;
                                    $productos_db[$pr->id]["nombre_granja"] = $g->nombre_granja;
                                    $productos_db[$pr->id]["ref"] = $concentrado->ref_concentrado;
                                    $productos_db[$pr->id]["producto"] = $concentrado->nombre_concentrado;
                                    $productos_db[$pr->id]["fecha_creacion"] = $pr->fecha_creacion;
                                    $productos_db[$pr->id]["fecha_entrega"] = $pr->fecha_entrega;
                                    $productos_db[$pr->id]["bultos"] = $pr->no_bultos;
                                    $productos_db[$pr->id]["kilos"] = $pr->no_kilos;
                                    $productos_db[$pr->id]["tipo_documento"] = $pr->tipo_documento;
                                    $productos_db[$pr->id]["prefijo"] = $pr->prefijo;
                                    $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                    $productos_db[$pr->id]["bodega"] = 'XXX';
                                    $productos_db[$pr->id]["vendedor"] = '0';
                                    $productos_db[$pr->id]["centro_costo"] =  $g->centro_costo;
                                    $productos_db[$pr->id]["forma_pago"] = $g->forma_pago;
                                    $productos_db[$pr->id]["iva"] = $iva_seleccionado->valor_iva;
                                    $productos_db[$pr->id]["precio_concentrados"] = $concentrado->precio;
                                }
                                else if ($gr == '0') 
                                {
                                    $iva_seleccionado = Iva::find($iva->iva_id);
                                    $productos_db[$pr->id]["granja"] = $g->descripcion_granja;
                                    $productos_db[$pr->id]["nombre_granja"] = $g->nombre_granja;
                                    $productos_db[$pr->id]["ref"] = $concentrado->ref_concentrado;
                                    $productos_db[$pr->id]["producto"] = $concentrado->nombre_concentrado;
                                    $productos_db[$pr->id]["fecha_creacion"] = $pr->fecha_creacion;
                                    $productos_db[$pr->id]["fecha_entrega"] = $pr->fecha_entrega;
                                    $productos_db[$pr->id]["bultos"] = $pr->no_bultos;
                                    $productos_db[$pr->id]["kilos"] = $pr->no_kilos;
                                    $productos_db[$pr->id]["tipo_documento"] = $pr->tipo_documento;
                                    $productos_db[$pr->id]["prefijo"] = $pr->prefijo;
                                    $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                    $productos_db[$pr->id]["bodega"] = 'XXX'; 
                                    $productos_db[$pr->id]["vendedor"] = '0'; 
                                    $productos_db[$pr->id]["centro_costo"] =  $g->centro_costo;
                                    $productos_db[$pr->id]["forma_pago"] = $g->forma_pago;
                                    $productos_db[$pr->id]["iva"] = $iva_seleccionado->valor_iva;
                                    $productos_db[$pr->id]["precio_concentrados"] = $concentrado->precio;
                                }
                            }
                        }
                    }
                }
            }

            $productos_db = json_decode(json_encode($productos_db), true);
            $excel->sheet('Productos', function($sheet) use($productos_db)
            {
                $sheet->row(1, ['Fecha de Creacion', 'Tipo de Documento', 'Prefijo', 'Consecutivo', 'Granja', 'Nombre de granja', 'Vendedor', 'Forma de Pago', 'Referencia', 'Producto', 'Kilogramos', 'Bodega', 'Centro de Costo', 'Precio', 'Iva','Fecha de Entrega']);
                foreach ($productos_db as $producto_db) 
                {
                    $row = [];
                    $row[0] = $producto_db['fecha_creacion'];
                    $row[1] = $producto_db['tipo_documento'];
                    $row[2] = $producto_db['prefijo'];
                    $row[3] = $producto_db['consecutivo'];
                    $row[4] = $producto_db['granja'];
                    $row[5] = $producto_db['nombre_granja'];
                    $row[6] = $producto_db['vendedor'];
                    $row[7] = $producto_db['forma_pago'];
                    $row[8] = $producto_db['ref'];
                    $row[9] = $producto_db['producto'];
                    $row[10] = $producto_db['kilos'];
                    $row[11] = $producto_db['bodega'];
                    $row[12] = $producto_db['centro_costo'];
                    $row[13] = $producto_db['precio_concentrados'];
                    $row[14] = $producto_db['iva'];
                    $row[15] = $producto_db['fecha_entrega'];
                    $sheet->appendRow($row);
                }
            });
        })->export('csv');
    } 
    /**
    * permite descargar un archivo desde la vista list_pedido_cia.blade.php
    * todos los pedidos que lleva actualmente la base datos dependiendo los parametros
    * que se le envien
    *
    * @var Granja
    * @var ConsecutivoCia
    * @param int $ini 
    * @param int $fin
    * @param int $gr
    * @return Filtro Pedidos Cia.csv
    */

    public function filtroPorPedidosCia($ini,$fin,$gr)
    {
        Excel::create('Filtro Pedidos Cia', function($excel) use($ini, $fin, $gr)
        {
            $peds = ConsecutivoCia::whereBetween('fecha_creacion', [$ini, $fin])->get();
            $granjas = Granja::all();
            $pedidos = ConsecutivoCia::all();
            foreach ($peds as $pe) 
            {
                foreach ($granjas as $g)  
                {
                    if ($pe->granja_id == $g->id)
                    {
                        if ($gr == $g->id) 
                        { 
                            $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                            $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                            $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion;
                        }
                        else if ($gr == '0') 
                        {
                            $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                            $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                            $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion;    
                        }
                    }
                }
            }
            $pedidos_db = json_decode(json_encode($pedidos_db), true);

            $excel->sheet('Pedidos', function($sheet) use($pedidos_db)
            {
                foreach ($pedidos_db as $pedido_db) 
                {
                    $sheet->row(1, ['Consecutivo', 'Granja', 'Fecha']);
                    $row = [];
                    $row[0] = 'PSE'.$pedido_db['consecutivo'];
                    $row[1] = $pedido_db['granja'];
                    $row[2] = $pedido_db['fecha'];
                    $sheet->appendRow($row);
                }
            });
        })->export('csv');  
    }
    /**
    * permite descargar un archivo desde la vista list_pedidos_cia.blade.php todos los productos
    * que tiene actualmente la base de datos
    *
    * @var ProductoCia 
    * @var PedidoCia 
    * @var ConsecutivoCia 
    * @param int $ini
    * @param int $fin
    * @param int $gr
    * @return Filtro de Productos Cia.csv
    */

    public function filtroPorProductosCia($ini,$fin,$gr)
    { 
        Excel::create('Filtro de Productos Cia', function($excel) use($ini, $fin, $gr)
        {
            $granjas = Granja::all();
            $productos_cia = ProductoCia::all();
            $productos = PedidoCia::all();
            $pedidos = ConsecutivoCia::all();
            $prods = PedidoCia::whereBetween('fecha_pedido', [$ini,$fin])->get();
            foreach ($prods as $pr) 
            {
                foreach ($granjas as $g) 
                {
                    if ($pr->granja_id == $g->id)
                    {
                        foreach ($productos_cia as $producto_cia) 
                        {
                            if ($pr->producto_cia_id == $producto_cia->id) 
                            {
                                if ($gr == $g->id)
                                {
                                    $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                    $productos_db[$pr->id]["ref"] = $producto_cia->ref_producto_cia;
                                    $productos_db[$pr->id]["producto"] = $producto_cia->nombre_producto_cia;
                                    $productos_db[$pr->id]["fecha"] = $pr->fecha_pedido;
                                    $productos_db[$pr->id]["dosis"] = $pr->dosis;
                                    $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                }
                                else if ($gr == '0') 
                                {
                                    $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                    $productos_db[$pr->id]["ref"] = $producto_cia->ref_producto_cia;
                                    $productos_db[$pr->id]["producto"] = $producto_cia->nombre_producto_cia;
                                    $productos_db[$pr->id]["fecha"] = $pr->fecha_pedido;
                                    $productos_db[$pr->id]["dosis"] = $pr->dosis;
                                    $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                }
                            }
                        }
                    }
                }
            }
            $productos_db = json_decode(json_encode($productos_db), true);
            $excel->sheet('Productos', function($sheet) use($productos_db)
            {
                foreach ($productos_db as $producto_db) 
                {
                    $sheet->row(1, ['Granja', 'Codigo', 'Producto', 'Fecha', '# dosis', 'Consecutivo']);
                    $row = [];
                    $row[0] = $producto_db['granja'];
                    $row[1] = $producto_db['ref'];
                    $row[2] = $producto_db['producto'];
                    $row[3] = $producto_db['fecha'];
                    $row[4] = $producto_db['dosis'];
                    $row[5] = 'PSE'.$producto_db['consecutivo'];
                    $sheet->appendRow($row);
                }
            });
        })->export('csv');
    }
    /**
    * permite descargar un archivo desde la vista filtro_ceba.blade.php los lotes registrados
    * de acuerdo a los parametros que se enviaron desde la vista
    *
    * @var Granja
    * @var Ceba
    * @var AsociacionGranja
    * @param int gr
    * @param int lote
    * @param date fecha_inicial
    * @param date fecha_final
    * @return archivo.csv
    */

    public function filtroCeba($gr, $lote,$fecha_inicial,$fecha_final)
    {
        $date = Carbon::now();
        $date->format('D-M-Y');
        if($gr != 0 && $lote != 0)
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtro de Ceba por Granja,Lote y Fechas del dia '.$date,function ($excel) use($gr,$lote,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $cebas = Ceba::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = Ceba::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::User()->rol_id != 7) 
                        {
                        foreach ($fechas as $fecha) 
                        {
                            if($fecha->año > '2014')
                            {
                                if ($fecha->granja_id == $gr) 
                                {
                                    if ($fecha->lote == $lote) 
                                    {
                                        foreach ($granjas as $granja) 
                                        {
                                            if ($fecha->granja_id == $granja->id) 
                                            {
                                                if ($granja->id == $gr) 
                                                {
                                                    $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                                    $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                    $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                                    $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                                    $cebas_db[$fecha->id]["año"] = $fecha->año;
                                                    $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                                    $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                                    $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                                    $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                                    $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                                    $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                                    $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                                    $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                                    $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                                    $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                                    $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                                    $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                                    $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                                    $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                                    $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                                    $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                                    $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                                    $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                                    $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                                    $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                                    $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                                    $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                                    $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                                    $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                                    $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                                    $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                                    $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                                    $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                                    $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                                    $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                                    $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                                    $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                                    $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                                    $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                                    $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                                    $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Año, Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                if ($fecha->lote == $lote) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            if ($granja->id == $gr) 
                                            {
                                                $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                                $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                                $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                                $cebas_db[$fecha->id]["año"] = $fecha->año;
                                                $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                                $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                                $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                                $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                                $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                                $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                                $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                                $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                                $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                                $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                                $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                                $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                                $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                                $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                                $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                                $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                                $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                                $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                                $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                                $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                                $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                                $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                                $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                                $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                                $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                                $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                                $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                                $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                                $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                                $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                                $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                                $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                                $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                                $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                                $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                                $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Año as anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }else{
                Excel::create('Filtro de Ceba por Granja y Lote del dia '.$date, function($excel) use($gr, $lote)
                {
                    $granjas = Granja::all();
                    $cebas = Ceba::all();
                    $g_as = AsociacionGranja::all();

                    foreach ($cebas as $ceba) 
                    {
                        if ($ceba->lote == $lote) 
                        {
                            foreach ($granjas as $granja)
                            {
                                if ($ceba->granja_id == $granja->id) 
                                {
                                    if ($granja->id == $gr) 
                                    {
                                        $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                        $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                        $cebas_db[$ceba->id]["fecha_ingreso_lote"] = $ceba->fecha_ingreso_lote;
                                        $cebas_db[$ceba->id]["fecha_salida_lote"] = $ceba->fecha_salida_lote;
                                        $cebas_db[$ceba->id]["año"] = $ceba->año;
                                        $cebas_db[$ceba->id]["mes"] = $ceba->mes;
                                        $cebas_db[$ceba->id]["semana"] = $ceba->semana;
                                        $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                        $cebas_db[$ceba->id]["cerdos_descartados"] = $ceba->cerdos_descartados;
                                        $cebas_db[$ceba->id]["cerdos_livianos"] = $ceba->cerdos_livianos;
                                        $cebas_db[$ceba->id]["muertes"] = $ceba->muertes;
                                        $cebas_db[$ceba->id]["cant_final_cerdos"] = $ceba->cant_final_cerdos;
                                        $cebas_db[$ceba->id]["edad_inicial"] = $ceba->edad_inicial;
                                        $cebas_db[$ceba->id]["edad_inicial_total"] = $ceba->edad_inicial_total;
                                        $cebas_db[$ceba->id]["dias"] = $ceba->dias;
                                        $cebas_db[$ceba->id]["dias_permanencia"] = $ceba->dias_permanencia;
                                        $cebas_db[$ceba->id]["edad_final"] = $ceba->edad_final;
                                        $cebas_db[$ceba->id]["edad_final_total"] = $ceba->edad_final_total;
                                        $cebas_db[$ceba->id]["conf_edad_final"] = $ceba->conf_edad_final;
                                        $cebas_db[$ceba->id]["por_mortalidad"] = $ceba->por_mortalidad;
                                        $cebas_db[$ceba->id]["por_descartes"] = $ceba->por_descartes;
                                        $cebas_db[$ceba->id]["por_livianos"] = $ceba->por_livianos;
                                        $cebas_db[$ceba->id]["peso_total_ingresado"] = $ceba->peso_total_ingresado;
                                        $cebas_db[$ceba->id]["peso_promedio_ingresado"] = $ceba->peso_promedio_ingresado;
                                        $cebas_db[$ceba->id]["peso_total_vendido"] = $ceba->peso_total_vendido;
                                        $cebas_db[$ceba->id]["peso_promedio_vendido"] = $ceba->peso_promedio_vendido;
                                        $cebas_db[$ceba->id]["consumo_lote"] = $ceba->consumo_lote;
                                        $cebas_db[$ceba->id]["consumo_promedio_lote"] = $ceba->consumo_promedio_lote;
                                        $cebas_db[$ceba->id]["consumo_promedio_lote_dias"] = $ceba->consumo_promedio_lote_dias;
                                        $cebas_db[$ceba->id]["cons_promedio_ini"] = $ceba->cons_promedio_ini;
                                        $cebas_db[$ceba->id]["cons_promedio_dia_ini"] = $ceba->cons_promedio_dia_ini;
                                        $cebas_db[$ceba->id]["cons_ajustado_ini"] = $ceba->cons_ajustado_ini;
                                        $cebas_db[$ceba->id]["ato_promedio_ini"] = $ceba->ato_promedio_ini;
                                        $cebas_db[$ceba->id]["ato_promedio_dia_ini"] = $ceba->ato_promedio_dia_ini;
                                        $cebas_db[$ceba->id]["conversion_ini"] = $ceba->conversion_ini;
                                        $cebas_db[$ceba->id]["conversion_ajust_ini"] = $ceba->conversion_ajust_ini;
                                        $cebas_db[$ceba->id]["cons_ajustado_fin"] = $ceba->cons_ajustado_fin;
                                        $cebas_db[$ceba->id]["ato_promedio_fin"] = $ceba->ato_promedio_fin;
                                        $cebas_db[$ceba->id]["ato_promedio_dia_fin"] = $ceba->ato_promedio_dia_fin;
                                        $cebas_db[$ceba->id]["conversion_fin"] = $ceba->conversion_ini;
                                        $cebas_db[$ceba->id]["conversion_ajust_fin"] = $ceba->conversion_ajust_fin;
                                    }   
                                }   
                            }
                        }
                    }
                    $cebas_db = json_decode(json_encode($cebas_db), true);
                    $excel->sheet('Filtro', function($sheet) use($cebas_db)
                    {
                        foreach ($cebas_db as $ceba_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                            $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }
        }
        elseif($gr != '0')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtro de Ceba por Granja y Fecha del dia '.$date,function($excel) use($gr,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $cebas = Ceba::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = Ceba::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        if ($granja->id == $gr) 
                                        {
                                            $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                            $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                            $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                            $cebas_db[$fecha->id]["año"] = $fecha->año;
                                            $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                            $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                            $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                            $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                            $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                            $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                            $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                            $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                            $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                            $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                            $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                            $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                            $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                            $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                            $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                            $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                            $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                            $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                            $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                            $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                            $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                            $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                            $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                            $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                            $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                            $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                            $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                            $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                            $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                            $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                            $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                            $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                            $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                            $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                            $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                            $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                        }
                                    }
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']); 
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        if ($granja->id == $gr) 
                                        {
                                            $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                            $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                            $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                            $cebas_db[$fecha->id]["año"] = $fecha->año;
                                            $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                            $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                            $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                            $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                            $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                            $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                            $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                            $cebas_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos;
                                            $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                            $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                            $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                            $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                            $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                            $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                            $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                            $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                            $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                            $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                            $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                            $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                            $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                            $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                            $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                            $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                            $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                            $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                            $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                            $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                            $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                            $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                            $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                            $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                            $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                            $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                            $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                            $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                            $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                        }
                                    }
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']); 
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }else{
                Excel::create('Filtro de Ceba por Granja del dia '.$date, function($excel) use($gr)
                {
                    $granjas = Granja::all();
                    $cebas = Ceba::all();
                    $g_as = AsociacionGranja::all();

                    foreach ($cebas as $ceba) 
                    {
                        foreach ($granjas as $granja)
                        {
                            if ($ceba->granja_id == $granja->id) 
                            {
                                if ($granja->id == $gr) 
                                {
                                    $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                    $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                    $cebas_db[$ceba->id]["fecha_ingreso_lote"] = $ceba->fecha_ingreso_lote;
                                    $cebas_db[$ceba->id]["fecha_salida_lote"] = $ceba->fecha_salida_lote;
                                    $cebas_db[$ceba->id]["año"] = $ceba->año;
                                    $cebas_db[$ceba->id]["mes"] = $ceba->mes;
                                    $cebas_db[$ceba->id]["semana"] = $ceba->semana;
                                    $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                    $cebas_db[$ceba->id]["cerdos_descartados"] = $ceba->cerdos_descartados;
                                    $cebas_db[$ceba->id]["cerdos_livianos"] = $ceba->cerdos_livianos;
                                    $cebas_db[$ceba->id]["muertes"] = $ceba->muertes;
                                    $cebas_db[$ceba->id]["cant_final_cerdos"] = $ceba->cant_final_cerdos;
                                    $cebas_db[$ceba->id]["edad_inicial"] = $ceba->edad_inicial;
                                    $cebas_db[$ceba->id]["edad_inicial_total"] = $ceba->edad_inicial_total;
                                    $cebas_db[$ceba->id]["dias"] = $ceba->dias;
                                    $cebas_db[$ceba->id]["dias_permanencia"] = $ceba->dias_permanencia;
                                    $cebas_db[$ceba->id]["edad_final"] = $ceba->edad_final;
                                    $cebas_db[$ceba->id]["edad_final_total"] = $ceba->edad_final_total;
                                    $cebas_db[$ceba->id]["conf_edad_final"] = $ceba->conf_edad_final;
                                    $cebas_db[$ceba->id]["por_mortalidad"] = $ceba->por_mortalidad;
                                    $cebas_db[$ceba->id]["por_descartes"] = $ceba->por_descartes;
                                    $cebas_db[$ceba->id]["por_livianos"] = $ceba->por_livianos;
                                    $cebas_db[$ceba->id]["peso_total_ingresado"] = $ceba->peso_total_ingresado;
                                    $cebas_db[$ceba->id]["peso_promedio_ingresado"] = $ceba->peso_promedio_ingresado;
                                    $cebas_db[$ceba->id]["peso_total_vendido"] = $ceba->peso_total_vendido;
                                    $cebas_db[$ceba->id]["peso_promedio_vendido"] = $ceba->peso_promedio_vendido;
                                    $cebas_db[$ceba->id]["consumo_lote"] = $ceba->consumo_lote;
                                    $cebas_db[$ceba->id]["consumo_promedio_lote"] = $ceba->consumo_promedio_lote;
                                    $cebas_db[$ceba->id]["consumo_promedio_lote_dias"] = $ceba->consumo_promedio_lote_dias;
                                    $cebas_db[$ceba->id]["cons_promedio_ini"] = $ceba->cons_promedio_ini;
                                    $cebas_db[$ceba->id]["cons_promedio_dia_ini"] = $ceba->cons_promedio_dia_ini;
                                    $cebas_db[$ceba->id]["cons_ajustado_ini"] = $ceba->cons_ajustado_ini;
                                    $cebas_db[$ceba->id]["ato_promedio_ini"] = $ceba->ato_promedio_ini;
                                    $cebas_db[$ceba->id]["ato_promedio_dia_ini"] = $ceba->ato_promedio_dia_ini;
                                    $cebas_db[$ceba->id]["conversion_ini"] = $ceba->conversion_ini;
                                    $cebas_db[$ceba->id]["conversion_ajust_ini"] = $ceba->conversion_ajust_ini;
                                    $cebas_db[$ceba->id]["cons_ajustado_fin"] = $ceba->cons_ajustado_fin;
                                    $cebas_db[$ceba->id]["ato_promedio_fin"] = $ceba->ato_promedio_fin;
                                    $cebas_db[$ceba->id]["ato_promedio_dia_fin"] = $ceba->ato_promedio_dia_fin;
                                    $cebas_db[$ceba->id]["conversion_fin"] = $ceba->conversion_ini;
                                    $cebas_db[$ceba->id]["conversion_ajust_fin"] = $ceba->conversion_ajust_fin;
                                }   
                            }   
                        }
                    }
                    $cebas_db = json_decode(json_encode($cebas_db), true);
                    $excel->sheet('Filtro', function($sheet) use($cebas_db)
                    {
                        foreach ($cebas_db as $ceba_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']); 
                            $row = [];
                            $row[0] = $ceba_db["lote"];
                            $row[1] = $ceba_db["granja"];
                            $row[2] = $ceba_db["fecha_ingreso_lote"];
                            $row[3] = $ceba_db["fecha_salida_lote"];
                            $row[4] = $ceba_db["año"];
                            $row[5] = $ceba_db["mes"];
                            $row[6] = $ceba_db["semana"];
                            $row[7] = $ceba_db["inic"];
                            $row[8] = $ceba_db["cerdos_descartados"];
                            $row[9] = $ceba_db["cerdos_livianos"];
                            $row[10] = $ceba_db["muertes"];
                            $row[11] = $ceba_db["cant_final_cerdos"];
                            $row[12] = $ceba_db["edad_inicial"];
                            $row[13] = $ceba_db["edad_inicial_total"];
                            $row[14] = $ceba_db["dias"];
                            $row[15] = $ceba_db["dias_permanencia"];
                            $row[16] = $ceba_db["edad_final"];
                            $row[17] = $ceba_db["edad_final_total"];
                            $row[18] = $ceba_db["conf_edad_final"];
                            $row[19] = $ceba_db["por_mortalidad"];
                            $row[20] = $ceba_db["por_descartes"];
                            $row[21] = $ceba_db["por_livianos"];
                            $row[22] = $ceba_db["peso_total_ingresado"];
                            $row[23] = $ceba_db["peso_promedio_ingresado"];
                            $row[24] = $ceba_db["peso_total_vendido"];
                            $row[25] = $ceba_db["peso_promedio_vendido"];
                            $row[26] = $ceba_db["consumo_lote"];
                            $row[27] = $ceba_db["consumo_promedio_lote"];
                            $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                            $row[29] = $ceba_db["cons_promedio_ini"];
                            $row[30] = $ceba_db["cons_promedio_dia_ini"];
                            $row[31] = $ceba_db["cons_ajustado_ini"];
                            $row[32] = $ceba_db["ato_promedio_ini"];
                            $row[33] = $ceba_db["ato_promedio_dia_ini"];
                            $row[34] = $ceba_db["conversion_ini"];
                            $row[35] = $ceba_db["conversion_ajust_ini"];
                            $row[36] = $ceba_db["cons_ajustado_fin"];
                            $row[37] = $ceba_db["ato_promedio_fin"];
                            $row[38] = $ceba_db["ato_promedio_dia_fin"];
                            $row[39] = $ceba_db["conversion_fin"];
                            $row[40] = $ceba_db["conversion_ajust_fin"];
                            $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }
        }
        elseif($lote != '0')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtro de ceba por lote y Fecha del dia '.$date,function ($excel) use ($lote,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $cebas = Ceba::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = Ceba::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote) 
                            {
                                foreach ($g_as as $g) 
                                {
                                    if ($g->user_id == Auth::User()->id) 
                                        {
                                        if ($fecha->granja_id == $g->granja_id) 
                                        {
                                            foreach ($granjas as $granja) 
                                            {
                                                if ($fecha->granja_id == $granja->id) 
                                                {
                                                    $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                                    $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                    $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                                    $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                                    $cebas_db[$fecha->id]["año"] = $fecha->año;
                                                    $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                                    $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                                    $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                                    $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                                    $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                                    $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                                    $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                                    $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                                    $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                                    $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                                    $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                                    $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                                    $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                                    $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                                    $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                                    $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                                    $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                                    $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                                    $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                                    $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                                    $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                                    $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                                    $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                                    $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                                    $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                                    $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                                    $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                                    $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                                    $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                                    $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                                    $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                                    $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                                    $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                                    $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                                    $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                                    $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                        $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                        $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                        $cebas_db[$fecha->id]["año"] = $fecha->año;
                                        $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                        $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                        $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                        $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                        $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                        $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                        $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                        $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                        $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                        $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                        $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                        $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                        $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                        $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                        $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                        $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                        $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                        $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                        $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                        $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                        $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                        $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                        $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                        $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                        $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                        $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                        $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                        $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                        $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                        $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                        $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                        $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                        $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                        $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                        $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                        $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                    }
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
            else
            {
                Excel::create('Filtro de Ceba por Lote del dia '.$date, function($excel) use($lote)
                {
                    $granjas = Granja::all();
                    $cebas = Ceba::all();
                    $g_as = AsociacionGranja::all();

                    if (Auth::User()->rol_id != 7)  
                    {
                        foreach ($cebas as $ceba) 
                        {
                            if ($ceba->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($ceba->granja_id == $granja->id) 
                                    {   
                                        foreach ($g_as as $g) 
                                        {
                                            if ($g->user_id == Auth::User()->id) 
                                            {
                                                if ($ceba->granja_id == $g->granja_id)
                                                {
                                                    $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                                    $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                                    $cebas_db[$ceba->id]["fecha_ingreso_lote"] = $ceba->fecha_ingreso_lote;
                                                    $cebas_db[$ceba->id]["fecha_salida_lote"] = $ceba->fecha_salida_lote;
                                                    $cebas_db[$ceba->id]["año"] = $ceba->año;
                                                    $cebas_db[$ceba->id]["mes"] = $ceba->mes;
                                                    $cebas_db[$ceba->id]["semana"] = $ceba->semana;
                                                    $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                                    $cebas_db[$ceba->id]["cerdos_descartados"] = $ceba->cerdos_descartados;
                                                    $cebas_db[$ceba->id]["cerdos_livianos"] = $ceba->cerdos_livianos;
                                                    $cebas_db[$ceba->id]["muertes"] = $ceba->muertes;
                                                    $cebas_db[$ceba->id]["cant_final_cerdos"] = $ceba->cant_final_cerdos;
                                                    $cebas_db[$ceba->id]["edad_inicial"] = $ceba->edad_inicial;
                                                    $cebas_db[$ceba->id]["edad_inicial_total"] = $ceba->edad_inicial_total;
                                                    $cebas_db[$ceba->id]["dias"] = $ceba->dias;
                                                    $cebas_db[$ceba->id]["dias_permanencia"] = $ceba->dias_permanencia;
                                                    $cebas_db[$ceba->id]["edad_final"] = $ceba->edad_final;
                                                    $cebas_db[$ceba->id]["edad_final_total"] = $ceba->edad_final_total;
                                                    $cebas_db[$ceba->id]["conf_edad_final"] = $ceba->conf_edad_final;
                                                    $cebas_db[$ceba->id]["por_mortalidad"] = $ceba->por_mortalidad;
                                                    $cebas_db[$ceba->id]["por_descartes"] = $ceba->por_descartes;
                                                    $cebas_db[$ceba->id]["por_livianos"] = $ceba->por_livianos;
                                                    $cebas_db[$ceba->id]["peso_total_ingresado"] = $ceba->peso_total_ingresado;
                                                    $cebas_db[$ceba->id]["peso_promedio_ingresado"] = $ceba->peso_promedio_ingresado;
                                                    $cebas_db[$ceba->id]["peso_total_vendido"] = $ceba->peso_total_vendido;
                                                    $cebas_db[$ceba->id]["peso_promedio_vendido"] = $ceba->peso_promedio_vendido;
                                                    $cebas_db[$ceba->id]["consumo_lote"] = $ceba->consumo_lote;
                                                    $cebas_db[$ceba->id]["consumo_promedio_lote"] = $ceba->consumo_promedio_lote;
                                                    $cebas_db[$ceba->id]["consumo_promedio_lote_dias"] = $ceba->consumo_promedio_lote_dias;
                                                    $cebas_db[$ceba->id]["cons_promedio_ini"] = $ceba->cons_promedio_ini;
                                                    $cebas_db[$ceba->id]["cons_promedio_dia_ini"] = $ceba->cons_promedio_dia_ini;
                                                    $cebas_db[$ceba->id]["cons_ajustado_ini"] = $ceba->cons_ajustado_ini;
                                                    $cebas_db[$ceba->id]["ato_promedio_ini"] = $ceba->ato_promedio_ini;
                                                    $cebas_db[$ceba->id]["ato_promedio_dia_ini"] = $ceba->ato_promedio_dia_ini;
                                                    $cebas_db[$ceba->id]["conversion_ini"] = $ceba->conversion_ini;
                                                    $cebas_db[$ceba->id]["conversion_ajust_ini"] = $ceba->conversion_ajust_ini;
                                                    $cebas_db[$ceba->id]["cons_ajustado_fin"] = $ceba->cons_ajustado_fin;
                                                    $cebas_db[$ceba->id]["ato_promedio_fin"] = $ceba->ato_promedio_fin;
                                                    $cebas_db[$ceba->id]["ato_promedio_dia_fin"] = $ceba->ato_promedio_dia_fin;
                                                    $cebas_db[$ceba->id]["conversion_fin"] = $ceba->conversion_ini;
                                                    $cebas_db[$ceba->id]["conversion_ajust_fin"] = $ceba->conversion_ajust_fin;
                                                }
                                            }
                                        }
                                    }   
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($cebas as $ceba) 
                        {
                            if ($ceba->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($ceba->granja_id == $granja->id) 
                                    {   
                                        $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                        $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                        $cebas_db[$ceba->id]["fecha_ingreso_lote"] = $ceba->fecha_ingreso_lote;
                                        $cebas_db[$ceba->id]["fecha_salida_lote"] = $ceba->fecha_salida_lote;
                                        $cebas_db[$ceba->id]["año"] = $ceba->año;
                                        $cebas_db[$ceba->id]["mes"] = $ceba->mes;
                                        $cebas_db[$ceba->id]["semana"] = $ceba->semana;
                                        $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                        $cebas_db[$ceba->id]["cerdos_descartados"] = $ceba->cerdos_descartados;
                                        $cebas_db[$ceba->id]["cerdos_livianos"] = $ceba->cerdos_livianos;
                                        $cebas_db[$ceba->id]["muertes"] = $ceba->muertes;
                                        $cebas_db[$ceba->id]["cant_final_cerdos"] = $ceba->cant_final_cerdos;
                                        $cebas_db[$ceba->id]["edad_inicial"] = $ceba->edad_inicial;
                                        $cebas_db[$ceba->id]["edad_inicial_total"] = $ceba->edad_inicial_total;
                                        $cebas_db[$ceba->id]["dias"] = $ceba->dias;
                                        $cebas_db[$ceba->id]["dias_permanencia"] = $ceba->dias_permanencia;
                                        $cebas_db[$ceba->id]["edad_final"] = $ceba->edad_final;
                                        $cebas_db[$ceba->id]["edad_final_total"] = $ceba->edad_final_total;
                                        $cebas_db[$ceba->id]["conf_edad_final"] = $ceba->conf_edad_final;
                                        $cebas_db[$ceba->id]["por_mortalidad"] = $ceba->por_mortalidad;
                                        $cebas_db[$ceba->id]["por_descartes"] = $ceba->por_descartes;
                                        $cebas_db[$ceba->id]["por_livianos"] = $ceba->por_livianos;
                                        $cebas_db[$ceba->id]["peso_total_ingresado"] = $ceba->peso_total_ingresado;
                                        $cebas_db[$ceba->id]["peso_promedio_ingresado"] = $ceba->peso_promedio_ingresado;
                                        $cebas_db[$ceba->id]["peso_total_vendido"] = $ceba->peso_total_vendido;
                                        $cebas_db[$ceba->id]["peso_promedio_vendido"] = $ceba->peso_promedio_vendido;
                                        $cebas_db[$ceba->id]["consumo_lote"] = $ceba->consumo_lote;
                                        $cebas_db[$ceba->id]["consumo_promedio_lote"] = $ceba->consumo_promedio_lote;
                                        $cebas_db[$ceba->id]["consumo_promedio_lote_dias"] = $ceba->consumo_promedio_lote_dias;
                                        $cebas_db[$ceba->id]["cons_promedio_ini"] = $ceba->cons_promedio_ini;
                                        $cebas_db[$ceba->id]["cons_promedio_dia_ini"] = $ceba->cons_promedio_dia_ini;
                                        $cebas_db[$ceba->id]["cons_ajustado_ini"] = $ceba->cons_ajustado_ini;
                                        $cebas_db[$ceba->id]["ato_promedio_ini"] = $ceba->ato_promedio_ini;
                                        $cebas_db[$ceba->id]["ato_promedio_dia_ini"] = $ceba->ato_promedio_dia_ini;
                                        $cebas_db[$ceba->id]["conversion_ini"] = $ceba->conversion_ini;
                                        $cebas_db[$ceba->id]["conversion_ajust_ini"] = $ceba->conversion_ajust_ini;
                                        $cebas_db[$ceba->id]["cons_ajustado_fin"] = $ceba->cons_ajustado_fin;
                                        $cebas_db[$ceba->id]["ato_promedio_fin"] = $ceba->ato_promedio_fin;
                                        $cebas_db[$ceba->id]["ato_promedio_dia_fin"] = $ceba->ato_promedio_dia_fin;
                                        $cebas_db[$ceba->id]["conversion_fin"] = $ceba->conversion_ini;
                                        $cebas_db[$ceba->id]["conversion_ajust_fin"] = $ceba->conversion_ajust_fin;
                                    }   
                                }
                            }
                        }
                        $cebas_db = json_decode(json_encode($cebas_db), true);
                        $excel->sheet('Filtro', function($sheet) use($cebas_db)
                        {
                            foreach ($cebas_db as $ceba_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $ceba_db["lote"];
                                $row[1] = $ceba_db["granja"];
                                $row[2] = $ceba_db["fecha_ingreso_lote"];
                                $row[3] = $ceba_db["fecha_salida_lote"];
                                $row[4] = $ceba_db["año"];
                                $row[5] = $ceba_db["mes"];
                                $row[6] = $ceba_db["semana"];
                                $row[7] = $ceba_db["inic"];
                                $row[8] = $ceba_db["cerdos_descartados"];
                                $row[9] = $ceba_db["cerdos_livianos"];
                                $row[10] = $ceba_db["muertes"];
                                $row[11] = $ceba_db["cant_final_cerdos"];
                                $row[12] = $ceba_db["edad_inicial"];
                                $row[13] = $ceba_db["edad_inicial_total"];
                                $row[14] = $ceba_db["dias"];
                                $row[15] = $ceba_db["dias_permanencia"];
                                $row[16] = $ceba_db["edad_final"];
                                $row[17] = $ceba_db["edad_final_total"];
                                $row[18] = $ceba_db["conf_edad_final"];
                                $row[19] = $ceba_db["por_mortalidad"];
                                $row[20] = $ceba_db["por_descartes"];
                                $row[21] = $ceba_db["por_livianos"];
                                $row[22] = $ceba_db["peso_total_ingresado"];
                                $row[23] = $ceba_db["peso_promedio_ingresado"];
                                $row[24] = $ceba_db["peso_total_vendido"];
                                $row[25] = $ceba_db["peso_promedio_vendido"];
                                $row[26] = $ceba_db["consumo_lote"];
                                $row[27] = $ceba_db["consumo_promedio_lote"];
                                $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                                $row[29] = $ceba_db["cons_promedio_ini"];
                                $row[30] = $ceba_db["cons_promedio_dia_ini"];
                                $row[31] = $ceba_db["cons_ajustado_ini"];
                                $row[32] = $ceba_db["ato_promedio_ini"];
                                $row[33] = $ceba_db["ato_promedio_dia_ini"];
                                $row[34] = $ceba_db["conversion_ini"];
                                $row[35] = $ceba_db["conversion_ajust_ini"];
                                $row[36] = $ceba_db["cons_ajustado_fin"];
                                $row[37] = $ceba_db["ato_promedio_fin"];
                                $row[38] = $ceba_db["ato_promedio_dia_fin"];
                                $row[39] = $ceba_db["conversion_fin"];
                                $row[40] = $ceba_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
        }
        elseif ($fecha_inicial != '+' && $fecha_final != '+') 
        {
            Excel::create('Filtro de Ceba por Fechas del dia '.$date,function($excel) use($fecha_inicial,$fecha_final)
            {
                $granjas = Granja::all();
                $cebas = Ceba::all();
                $g_as = AsociacionGranja::all();
                $fechas = Ceba::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                if (Auth::User()->rol_id != 7) 
                {
                    foreach ($g_as as $g) 
                    {
                        if ($g->user_id == Auth::User()->id) 
                            {
                            foreach ($fechas as $fecha) 
                            {
                                if ($g->granja_id == $fecha->granja_id) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($granja->id == $fecha->granja_id) 
                                        {
                                            $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                            $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                            $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                            $cebas_db[$fecha->id]["año"] = $fecha->año;
                                            $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                            $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                            $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                            $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                            $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                            $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                            $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                            $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                            $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                            $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                            $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                            $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                            $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                            $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                            $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                            $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                            $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                            $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                            $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                            $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                            $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                            $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                            $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                            $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                            $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                            $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                            $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                            $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                            $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                            $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                            $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                            $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                            $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                            $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                            $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                            $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $cebas_db = json_decode(json_encode($cebas_db), true);
                    $excel->sheet('Filtro', function($sheet) use($cebas_db)
                    {
                        foreach ($cebas_db as $ceba_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                            $row = [];
                            $row[0] = $ceba_db["lote"];
                            $row[1] = $ceba_db["granja"];
                            $row[2] = $ceba_db["fecha_ingreso_lote"];
                            $row[3] = $ceba_db["fecha_salida_lote"];
                            $row[4] = $ceba_db["año"];
                            $row[5] = $ceba_db["mes"];
                            $row[6] = $ceba_db["semana"];
                            $row[7] = $ceba_db["inic"];
                            $row[8] = $ceba_db["cerdos_descartados"];
                            $row[9] = $ceba_db["cerdos_livianos"];
                            $row[10] = $ceba_db["muertes"];
                            $row[11] = $ceba_db["cant_final_cerdos"];
                            $row[12] = $ceba_db["edad_inicial"];
                            $row[13] = $ceba_db["edad_inicial_total"];
                            $row[14] = $ceba_db["dias"];
                            $row[15] = $ceba_db["dias_permanencia"];
                            $row[16] = $ceba_db["edad_final"];
                            $row[17] = $ceba_db["edad_final_total"];
                            $row[18] = $ceba_db["conf_edad_final"];
                            $row[19] = $ceba_db["por_mortalidad"];
                            $row[20] = $ceba_db["por_descartes"];
                            $row[21] = $ceba_db["por_livianos"];
                            $row[22] = $ceba_db["peso_total_ingresado"];
                            $row[23] = $ceba_db["peso_promedio_ingresado"];
                            $row[24] = $ceba_db["peso_total_vendido"];
                            $row[25] = $ceba_db["peso_promedio_vendido"];
                            $row[26] = $ceba_db["consumo_lote"];
                            $row[27] = $ceba_db["consumo_promedio_lote"];
                            $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                            $row[29] = $ceba_db["cons_promedio_ini"];
                            $row[30] = $ceba_db["cons_promedio_dia_ini"];
                            $row[31] = $ceba_db["cons_ajustado_ini"];
                            $row[32] = $ceba_db["ato_promedio_ini"];
                            $row[33] = $ceba_db["ato_promedio_dia_ini"];
                            $row[34] = $ceba_db["conversion_ini"];
                            $row[35] = $ceba_db["conversion_ajust_ini"];
                            $row[36] = $ceba_db["cons_ajustado_fin"];
                            $row[37] = $ceba_db["ato_promedio_fin"];
                            $row[38] = $ceba_db["ato_promedio_dia_fin"];
                            $row[39] = $ceba_db["conversion_fin"];
                            $row[40] = $ceba_db["conversion_ajust_fin"];
                            $sheet->appendRow($row);
                        }
                    });
                }
                else
                {
                    foreach ($fechas as $fecha) 
                    {
                        foreach ($granjas as $granja) 
                        {
                            if ($granja->id == $fecha->granja_id) 
                            {
                                $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                $cebas_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                $cebas_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                $cebas_db[$fecha->id]["año"] = $fecha->año;
                                $cebas_db[$fecha->id]["mes"] = $fecha->mes;
                                $cebas_db[$fecha->id]["semana"] = $fecha->semana;
                                $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                $cebas_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                $cebas_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                $cebas_db[$fecha->id]["muertes"] = $fecha->muertes;
                                $cebas_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                $cebas_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial;
                                $cebas_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                $cebas_db[$fecha->id]["dias"] = $fecha->dias;
                                $cebas_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia;
                                $cebas_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                $cebas_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total;
                                $cebas_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final;
                                $cebas_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad;
                                $cebas_db[$fecha->id]["por_descartes"] = $fecha->por_descartes;
                                $cebas_db[$fecha->id]["por_livianos"] = $fecha->por_livianos;
                                $cebas_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado;
                                $cebas_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado;
                                $cebas_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido;
                                $cebas_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                $cebas_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote;
                                $cebas_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote;
                                $cebas_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                $cebas_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                $cebas_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                $cebas_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                $cebas_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                $cebas_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                $cebas_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                $cebas_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                $cebas_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                $cebas_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                $cebas_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                $cebas_db[$fecha->id]["conversion_fin"] = $fecha->conversion_ini;
                                $cebas_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                            }
                        }
                    }
                    $cebas_db = json_decode(json_encode($cebas_db), true);
                    $excel->sheet('Filtro', function($sheet) use($cebas_db)
                    {
                        foreach ($cebas_db as $ceba_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Año as Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Descartes', 'Livianos', 'Muertes', 'Cantidad Final de Cerdos', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Peso Promedio Final', 'Consumo Lote', 'Consumo Promedio Final', 'Consumo Promedio Dias Final', 'Consumo Promedio Inicial', 'Consumo Promedio Dias Inicial', 'Consumo Ajustado Inicial', 'Ato Promedio Inicial', 'Ato Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'Ato Promedio Final', 'Ato Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                            $row = [];
                            $row[0] = $ceba_db["lote"];
                            $row[1] = $ceba_db["granja"];
                            $row[2] = $ceba_db["fecha_ingreso_lote"];
                            $row[3] = $ceba_db["fecha_salida_lote"];
                            $row[4] = $ceba_db["año"];
                            $row[5] = $ceba_db["mes"];
                            $row[6] = $ceba_db["semana"];
                            $row[7] = $ceba_db["inic"];
                            $row[8] = $ceba_db["cerdos_descartados"];
                            $row[9] = $ceba_db["cerdos_livianos"];
                            $row[10] = $ceba_db["muertes"];
                            $row[11] = $ceba_db["cant_final_cerdos"];
                            $row[12] = $ceba_db["edad_inicial"];
                            $row[13] = $ceba_db["edad_inicial_total"];
                            $row[14] = $ceba_db["dias"];
                            $row[15] = $ceba_db["dias_permanencia"];
                            $row[16] = $ceba_db["edad_final"];
                            $row[17] = $ceba_db["edad_final_total"];
                            $row[18] = $ceba_db["conf_edad_final"];
                            $row[19] = $ceba_db["por_mortalidad"];
                            $row[20] = $ceba_db["por_descartes"];
                            $row[21] = $ceba_db["por_livianos"];
                            $row[22] = $ceba_db["peso_total_ingresado"];
                            $row[23] = $ceba_db["peso_promedio_ingresado"];
                            $row[24] = $ceba_db["peso_total_vendido"];
                            $row[25] = $ceba_db["peso_promedio_vendido"];
                            $row[26] = $ceba_db["consumo_lote"];
                            $row[27] = $ceba_db["consumo_promedio_lote"];
                            $row[28] = $ceba_db["consumo_promedio_lote_dias"];
                            $row[29] = $ceba_db["cons_promedio_ini"];
                            $row[30] = $ceba_db["cons_promedio_dia_ini"];
                            $row[31] = $ceba_db["cons_ajustado_ini"];
                            $row[32] = $ceba_db["ato_promedio_ini"];
                            $row[33] = $ceba_db["ato_promedio_dia_ini"];
                            $row[34] = $ceba_db["conversion_ini"];
                            $row[35] = $ceba_db["conversion_ajust_ini"];
                            $row[36] = $ceba_db["cons_ajustado_fin"];
                            $row[37] = $ceba_db["ato_promedio_fin"];
                            $row[38] = $ceba_db["ato_promedio_dia_fin"];
                            $row[39] = $ceba_db["conversion_fin"];
                            $row[40] = $ceba_db["conversion_ajust_fin"];
                            $sheet->appendRow($row);
                        }
                    });
                }
            })->export('csv');
        }  
    }
    /**
    * permite descargar un archivo desde la vista filtro_precebo.blade.php
    * informacion desde la base de datos de acuerdo a los parametros que se le envian 
    * desde la vista
    *
    * @var Granja 
    * @var Precebo 
    * @var AsociacionGranja 
    * @param int $gr 
    * @param int $lote
    * @param date $fecha_inicial
    * @param date $fecha_final
    * @return archivo.csv
    */

    public function filtroPrecebo($gr, $lote, $fecha_inicial, $fecha_final)
    {
        $date = Carbon::now();
        $date->format('d-m-y');
        if($gr != 0 && $lote != '*')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') {
                Excel::create('Filtro por Granja,Lote y Fecha del dia '.$date,function($excel) use($gr,$lote,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $precebos = Precebo::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = Precebo::whereBetween('fecha_traslado',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                if ($fecha->lote == $lote) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            if ($granja->id == $gr) 
                                            {
                                                $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                                $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                                $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                                $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                                $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                                $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                                $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                                $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                                $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                                $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                                $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                                $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                                $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                                $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                                $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                                $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                                $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                                $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                                $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                                $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                                $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                                $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                                $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                                $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                                $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                                $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                                $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                                $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                                $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                                $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                                $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                                $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                                $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                                $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                                $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                                $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                                $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                                $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                                $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                                $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                                $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                                $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                                $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                                $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                                $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                                $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                                $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["cons_ajustado_fin"];
                                $row[43] = $precebo_db["ato_promedio_fin"];
                                $row[44] = $precebo_db["ato_promedio_dia_fin"];
                                $row[45] = $precebo_db["conversion_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                if ($fecha->lote == $lote) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            if ($granja->id == $gr) 
                                            {
                                                $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                                $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                                $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                                $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                                $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                                $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                                $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                                $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                                $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                                $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                                $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                                $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                                $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                                $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                                $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                                $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                                $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                                $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                                $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                                $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                                $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                                $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                                $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                                $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                                $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                                $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                                $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                                $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                                $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                                $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                                $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                                $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                                $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                                $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                                $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                                $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                                $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                                $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                                $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                                $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                                $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                                $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                                $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                                $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                                $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                                $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                                $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["cons_ajustado_fin"];
                                $row[43] = $precebo_db["ato_promedio_fin"];
                                $row[44] = $precebo_db["ato_promedio_dia_fin"];
                                $row[45] = $precebo_db["conversion_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
            else
            {
                Excel::create('Filtro de Precebo por Granja y Lote del dia '.$date, function($excel) use($gr, $lote)
                {
                    $granjas = Granja::all();
                    $precebos = Precebo::all();
                    $g_as = AsociacionGranja::all();

                    foreach ($precebos as $precebo) 
                    {
                        if ($precebo->lote == $lote) 
                        {
                            foreach ($granjas as $granja)
                            {
                                if ($precebo->granja_id == $granja->id) 
                                {
                                    if ($granja->id == $gr) 
                                    {
                                        $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                        $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                        $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                        $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                        $precebos_db[$precebo->id]["semana_destete"] = $precebo->semana_destete;
                                        $precebos_db[$precebo->id]["semana_traslado"] = $precebo->semana_traslado;
                                        $precebos_db[$precebo->id]["año_destete"] = $precebo->año_destete;
                                        $precebos_db[$precebo->id]["año_traslado"] = $precebo->año_traslado;
                                        $precebos_db[$precebo->id]["mes_traslado"] = $precebo->mes_traslado;
                                        $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                        $precebos_db[$precebo->id]["edad_destete"] = $precebo->edad_destete;
                                        $precebos_db[$precebo->id]["edad_inicial_total"] = $precebo->edad_inicial_total;
                                        $precebos_db[$precebo->id]["dias_jaulon"] = $precebo->dias_jaulon;
                                        $precebos_db[$precebo->id]["dias_totales_permanencia"] = $precebo->dias_totales_permanencia;
                                        $precebos_db[$precebo->id]["edad_final"] = $precebo->edad_final;
                                        $precebos_db[$precebo->id]["edad_final_ajustada"] = $precebo->edad_final_ajustada;
                                        $precebos_db[$precebo->id]["peso_esperado"] = $precebo->peso_esperado;
                                        $precebos_db[$precebo->id]["numero_muertes"] = $precebo->numero_muertes;
                                        $precebos_db[$precebo->id]["numero_descartes"] = $precebo->numero_descartes;
                                        $precebos_db[$precebo->id]["numero_livianos"] = $precebo->numero_livianos;
                                        $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                        $precebos_db[$precebo->id]["porciento_mortalidad"] = $precebo->porciento_mortalidad;
                                        $precebos_db[$precebo->id]["porciento_descartes"] = $precebo->porciento_destetes;
                                        $precebos_db[$precebo->id]["porciento_livianos"] = $precebo->porciento_livianos;
                                        $precebos_db[$precebo->id]["peso_ini"] = $precebo->peso_ini;
                                        $precebos_db[$precebo->id]["peso_promedio_ini"] = $precebo->peso_promedio_ini;
                                        $precebos_db[$precebo->id]["peso_ponderado_ini"] = $precebo->peso_ponderado_ini;
                                        $precebos_db[$precebo->id]["peso_fin"] = $precebo->peso_fin;
                                        $precebos_db[$precebo->id]["peso_promedio_fin"] = $precebo->peso_promedio_fin;
                                        $precebos_db[$precebo->id]["peso_ponderado_fin"] = $precebo->peso_ponderado_fin;
                                        $precebos_db[$precebo->id]["ind_peso_final"] = $precebo->ind_peso_final;
                                        $precebos_db[$precebo->id]["cons_total"] = $precebo->cons_total;
                                        $precebos_db[$precebo->id]["cons_promedio"] = $precebo->cons_promedio;
                                        $precebos_db[$precebo->id]["cons_ponderado"] = $precebo->cons_ponderado;
                                        $precebos_db[$precebo->id]["cons_promedio_dia"] = $precebo->cons_ponderado;
                                        $precebos_db[$precebo->id]["cons_promedio_ini"] = $precebo->cons_promedio_ini;
                                        $precebos_db[$precebo->id]["cons_ponderado_ini"] = $precebo->cons_ponderado_ini;
                                        $precebos_db[$precebo->id]["cons_promedio_dia_ini"] = $precebo->cons_promedio_dia_ini;
                                        $precebos_db[$precebo->id]["cons_ajustado_ini"] = $precebo->cons_ajustado_ini;
                                        $precebos_db[$precebo->id]["ato_promedio_ini"] = $precebo->ato_promedio_ini;
                                        $precebos_db[$precebo->id]["ato_promedio_dia_ini"] = $precebo->ato_promedio_dia_ini;
                                        $precebos_db[$precebo->id]["conversion_ini"] = $precebo->conversion_ini;
                                        $precebos_db[$precebo->id]["conversion_ajust_ini"] = $precebo->conversion_ajust_ini;
                                        $precebos_db[$precebo->id]["cons_ajustado_fin"] = $precebo->cons_ajustado_fin;
                                        $precebos_db[$precebo->id]["ato_promedio_fin"] = $precebo->ato_promedio_fin;
                                        $precebos_db[$precebo->id]["ato_promedio_dia_fin"] = $precebo->ato_promedio_dia_fin;
                                        $precebos_db[$precebo->id]["conversion_fin"] = $precebo->conversion_fin;
                                        $precebos_db[$precebo->id]["conversion_ajust_fin"] = $precebo->conversion_ajust_fin;
                                    }   
                                }   
                            }
                        }
                    }
                    $precebos_db = json_decode(json_encode($precebos_db), true);
                    $excel->sheet('Filtro', function($sheet) use($precebos_db)
                    {
                        foreach ($precebos_db as $precebo_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                            $row = [];
                            $row[0] = $precebo_db["lote"];
                            $row[1] = $precebo_db["granja"];
                            $row[2] = $precebo_db["fecha_destete"];
                            $row[3] = $precebo_db["fecha_traslado"];
                            $row[4] = $precebo_db["semana_destete"];
                            $row[5] = $precebo_db["semana_traslado"];
                            $row[6] = $precebo_db["año_destete"];
                            $row[7] = $precebo_db["año_traslado"];
                            $row[8] = $precebo_db["mes_traslado"];
                            $row[9] = $precebo_db["numero_inicial"];
                            $row[10] = $precebo_db["edad_destete"];
                            $row[11] = $precebo_db["edad_inicial_total"];
                            $row[12] = $precebo_db["dias_jaulon"];
                            $row[13] = $precebo_db["dias_totales_permanencia"];
                            $row[14] = $precebo_db["edad_final"];
                            $row[15] = $precebo_db["edad_final_ajustada"];
                            $row[16] = $precebo_db["peso_esperado"];
                            $row[17] = $precebo_db["numero_muertes"];
                            $row[18] = $precebo_db["numero_descartes"];
                            $row[19] = $precebo_db["numero_livianos"];
                            $row[20] = $precebo_db["numero_final"];
                            $row[21] = $precebo_db["porciento_mortalidad"];
                            $row[22] = $precebo_db["porciento_descartes"];
                            $row[23] = $precebo_db["porciento_livianos"];
                            $row[24] = $precebo_db["peso_ini"];
                            $row[25] = $precebo_db["peso_promedio_ini"];
                            $row[26] = $precebo_db["peso_ponderado_ini"];
                            $row[27] = $precebo_db["peso_fin"];
                            $row[28] = $precebo_db["peso_promedio_fin"];
                            $row[29] = $precebo_db["peso_ponderado_fin"];
                            $row[30] = $precebo_db["ind_peso_final"];
                            $row[31] = $precebo_db["cons_total"];
                            $row[32] = $precebo_db["cons_promedio"];
                            $row[33] = $precebo_db["cons_ponderado"];
                            $row[34] = $precebo_db["cons_promedio_dia"];
                            $row[35] = $precebo_db["cons_promedio_ini"];
                            $row[36] = $precebo_db["cons_ponderado_ini"];
                            $row[37] = $precebo_db["cons_promedio_dia_ini"];
                            $row[38] = $precebo_db["cons_ajustado_ini"];
                            $row[39] = $precebo_db["ato_promedio_ini"];
                            $row[40] = $precebo_db["ato_promedio_dia_ini"];
                            $row[41] = $precebo_db["conversion_ini"];
                            $row[42] = $precebo_db["cons_ajustado_fin"];
                            $row[43] = $precebo_db["ato_promedio_fin"];
                            $row[44] = $precebo_db["ato_promedio_dia_fin"];
                            $row[45] = $precebo_db["conversion_fin"];
                            $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }
        }
        elseif($gr != '0')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                $date = Carbon::now();
                $date->format('D-M-Y');

                Excel::create('Filtro de Precebo por Granja y Fecha Del dia '.$date,function($excel) use($gr,$fecha_inicial,$fecha_final){
                    $granjas = Granja::all();
                    $precebos = Precebo::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = Precebo::whereBetween('fecha_traslado',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        if ($granja->id == $gr) 
                                        {
                                            $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                            $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                            $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                            $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                            $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                            $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                            $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                            $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                            $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                            $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                            $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                            $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                            $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                            $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                            $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                            $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                            $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                            $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                            $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                            $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                            $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                            $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                            $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                            $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                            $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                            $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                            $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                            $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                            $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                            $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                            $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                            $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                            $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                            $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                            $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                            $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                            $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                            $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                            $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                            $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                            $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                            $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                            $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                            $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                            $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                            $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                            $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                        }
                                    }
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["conversion_ajust_ini"];
                                $row[43] = $precebo_db["cons_ajustado_fin"];
                                $row[44] = $precebo_db["ato_promedio_fin"];
                                $row[45] = $precebo_db["ato_promedio_dia_fin"];
                                $row[46] = $precebo_db["conversion_fin"];
                                $row[47] = $precebo_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr)
                             {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        if ($granja->id == $gr) 
                                        {
                                            $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                            $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                            $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                            $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                            $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                            $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                            $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                            $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                            $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                            $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                            $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                            $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                            $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                            $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                            $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                            $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                            $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                            $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                            $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                            $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                            $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                            $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                            $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                            $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                            $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                            $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                            $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                            $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                            $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                            $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                            $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                            $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                            $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                            $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                            $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                            $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                            $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                            $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                            $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                            $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                            $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                            $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                            $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                            $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                            $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                            $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                            $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                        }
                                    }
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["conversion_ajust_ini"];
                                $row[43] = $precebo_db["cons_ajustado_fin"];
                                $row[44] = $precebo_db["ato_promedio_fin"];
                                $row[45] = $precebo_db["ato_promedio_dia_fin"];
                                $row[46] = $precebo_db["conversion_fin"];
                                $row[47] = $precebo_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }else{
                Excel::create('Filtro de Precebo por Granja del dia '.$date, function($excel) use($gr)
                {
                    $granjas = Granja::all();
                    $precebos = Precebo::all();
                    $g_as = AsociacionGranja::all();

                    foreach ($precebos as $precebo) 
                    {
                        foreach ($granjas as $granja)
                        {
                            if ($precebo->granja_id == $granja->id) 
                            {
                                if ($granja->id == $gr) 
                                {
                                    $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                    $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                    $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                    $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                    $precebos_db[$precebo->id]["semana_destete"] = $precebo->semana_destete;
                                    $precebos_db[$precebo->id]["semana_traslado"] = $precebo->semana_traslado;
                                    $precebos_db[$precebo->id]["año_destete"] = $precebo->año_destete;
                                    $precebos_db[$precebo->id]["año_traslado"] = $precebo->año_traslado;
                                    $precebos_db[$precebo->id]["mes_traslado"] = $precebo->mes_traslado;
                                    $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                    $precebos_db[$precebo->id]["edad_destete"] = $precebo->edad_destete;
                                    $precebos_db[$precebo->id]["edad_inicial_total"] = $precebo->edad_inicial_total;
                                    $precebos_db[$precebo->id]["dias_jaulon"] = $precebo->dias_jaulon;
                                    $precebos_db[$precebo->id]["dias_totales_permanencia"] = $precebo->dias_totales_permanencia;
                                    $precebos_db[$precebo->id]["edad_final"] = $precebo->edad_final;
                                    $precebos_db[$precebo->id]["edad_final_ajustada"] = $precebo->edad_final_ajustada;
                                    $precebos_db[$precebo->id]["peso_esperado"] = $precebo->peso_esperado;
                                    $precebos_db[$precebo->id]["numero_muertes"] = $precebo->numero_muertes;
                                    $precebos_db[$precebo->id]["numero_descartes"] = $precebo->numero_descartes;
                                    $precebos_db[$precebo->id]["numero_livianos"] = $precebo->numero_livianos;
                                    $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                    $precebos_db[$precebo->id]["porciento_mortalidad"] = $precebo->porciento_mortalidad;
                                    $precebos_db[$precebo->id]["porciento_descartes"] = $precebo->porciento_destetes;
                                    $precebos_db[$precebo->id]["porciento_livianos"] = $precebo->porciento_livianos;
                                    $precebos_db[$precebo->id]["peso_ini"] = $precebo->peso_ini;
                                    $precebos_db[$precebo->id]["peso_promedio_ini"] = $precebo->peso_promedio_ini;
                                    $precebos_db[$precebo->id]["peso_ponderado_ini"] = $precebo->peso_ponderado_ini;
                                    $precebos_db[$precebo->id]["peso_fin"] = $precebo->peso_fin;
                                    $precebos_db[$precebo->id]["peso_promedio_fin"] = $precebo->peso_promedio_fin;
                                    $precebos_db[$precebo->id]["peso_ponderado_fin"] = $precebo->peso_ponderado_fin;
                                    $precebos_db[$precebo->id]["ind_peso_final"] = $precebo->ind_peso_final;
                                    $precebos_db[$precebo->id]["cons_total"] = $precebo->cons_total;
                                    $precebos_db[$precebo->id]["cons_promedio"] = $precebo->cons_promedio;
                                    $precebos_db[$precebo->id]["cons_ponderado"] = $precebo->cons_ponderado;
                                    $precebos_db[$precebo->id]["cons_promedio_dia"] = $precebo->cons_ponderado;
                                    $precebos_db[$precebo->id]["cons_promedio_ini"] = $precebo->cons_promedio_ini;
                                    $precebos_db[$precebo->id]["cons_ponderado_ini"] = $precebo->cons_ponderado_ini;
                                    $precebos_db[$precebo->id]["cons_promedio_dia_ini"] = $precebo->cons_promedio_dia_ini;
                                    $precebos_db[$precebo->id]["cons_ajustado_ini"] = $precebo->cons_ajustado_ini;
                                    $precebos_db[$precebo->id]["ato_promedio_ini"] = $precebo->ato_promedio_ini;
                                    $precebos_db[$precebo->id]["ato_promedio_dia_ini"] = $precebo->ato_promedio_dia_ini;
                                    $precebos_db[$precebo->id]["conversion_ini"] = $precebo->conversion_ini;
                                    $precebos_db[$precebo->id]["conversion_ajust_ini"] = $precebo->conversion_ajust_ini;
                                    $precebos_db[$precebo->id]["cons_ajustado_fin"] = $precebo->cons_ajustado_fin;
                                    $precebos_db[$precebo->id]["ato_promedio_fin"] = $precebo->ato_promedio_fin;
                                    $precebos_db[$precebo->id]["ato_promedio_dia_fin"] = $precebo->ato_promedio_dia_fin;
                                    $precebos_db[$precebo->id]["conversion_fin"] = $precebo->conversion_fin;
                                    $precebos_db[$precebo->id]["conversion_ajust_fin"] = $precebo->conversion_ajust_fin;
                                }   
                            }   
                        }
                    }
                    $precebos_db = json_decode(json_encode($precebos_db), true);
                    $excel->sheet('Filtro', function($sheet) use($precebos_db)
                    {
                        foreach ($precebos_db as $precebo_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                            $row = [];
                            $row[0] = $precebo_db["lote"];
                            $row[1] = $precebo_db["granja"];
                            $row[2] = $precebo_db["fecha_destete"];
                            $row[3] = $precebo_db["fecha_traslado"];
                            $row[4] = $precebo_db["semana_destete"];
                            $row[5] = $precebo_db["semana_traslado"];
                            $row[6] = $precebo_db["año_destete"];
                            $row[7] = $precebo_db["año_traslado"];
                            $row[8] = $precebo_db["mes_traslado"];
                            $row[9] = $precebo_db["numero_inicial"];
                            $row[10] = $precebo_db["edad_destete"];
                            $row[11] = $precebo_db["edad_inicial_total"];
                            $row[12] = $precebo_db["dias_jaulon"];
                            $row[13] = $precebo_db["dias_totales_permanencia"];
                            $row[14] = $precebo_db["edad_final"];
                            $row[15] = $precebo_db["edad_final_ajustada"];
                            $row[16] = $precebo_db["peso_esperado"];
                            $row[17] = $precebo_db["numero_muertes"];
                            $row[18] = $precebo_db["numero_descartes"];
                            $row[19] = $precebo_db["numero_livianos"];
                            $row[20] = $precebo_db["numero_final"];
                            $row[21] = $precebo_db["porciento_mortalidad"];
                            $row[22] = $precebo_db["porciento_descartes"];
                            $row[23] = $precebo_db["porciento_livianos"];
                            $row[24] = $precebo_db["peso_ini"];
                            $row[25] = $precebo_db["peso_promedio_ini"];
                            $row[26] = $precebo_db["peso_ponderado_ini"];
                            $row[27] = $precebo_db["peso_fin"];
                            $row[28] = $precebo_db["peso_promedio_fin"];
                            $row[29] = $precebo_db["peso_ponderado_fin"];
                            $row[30] = $precebo_db["ind_peso_final"];
                            $row[31] = $precebo_db["cons_total"];
                            $row[32] = $precebo_db["cons_promedio"];
                            $row[33] = $precebo_db["cons_ponderado"];
                            $row[34] = $precebo_db["cons_promedio_dia"];
                            $row[35] = $precebo_db["cons_promedio_ini"];
                            $row[36] = $precebo_db["cons_ponderado_ini"];
                            $row[37] = $precebo_db["cons_promedio_dia_ini"];
                            $row[38] = $precebo_db["cons_ajustado_ini"];
                            $row[39] = $precebo_db["ato_promedio_ini"];
                            $row[40] = $precebo_db["ato_promedio_dia_ini"];
                            $row[41] = $precebo_db["conversion_ini"];
                            $row[42] = $precebo_db["conversion_ajust_ini"];
                            $row[43] = $precebo_db["cons_ajustado_fin"];
                            $row[44] = $precebo_db["ato_promedio_fin"];
                            $row[45] = $precebo_db["ato_promedio_dia_fin"];
                            $row[46] = $precebo_db["conversion_fin"];
                            $row[47] = $precebo_db["conversion_ajust_fin"];
                            $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }
        }
        elseif($lote != '*')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                $date = Carbon::now();
                $date->format('D-M-Y');

                Excel::create('Fitro de Precebo por lote y fecha del dia '.$date,function ($excel) use($lote,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $precebos = Precebo::all();
                    $g_as = AsociacionGranja::all();

                    $fechas = Precebo::whereBetween('fecha_traslado',[$fecha_inicial, $fecha_final] )->get();
                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote) 
                            {
                                foreach ($g_as as $g) 
                                {
                                    if ($g->user_id == Auth::User()->id) 
                                        {
                                        if ($fecha->granja_id == $g->granja_id) 
                                        {
                                            foreach ($granjas as $granja) 
                                            {
                                                if ($fecha->granja_id == $granja->id) 
                                                {
                                                    $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                                    $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                    $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                                    $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                                    $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                                    $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                                    $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                                    $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                                    $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                                    $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                                    $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                                    $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                                    $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                                    $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                                    $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                                    $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                                    $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                                    $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                                    $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                                    $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                                    $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                                    $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                                    $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                                    $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                                    $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                                    $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                                    $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                                    $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                                    $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                                    $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                                    $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                                    $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                                    $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                                    $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                                    $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                                    $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                                    $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                                    $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                                    $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                                    $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                                    $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                                    $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                                    $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                                    $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                                    $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                                    $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                                    $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                                    $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["conversion_ajust_ini"];
                                $row[43] = $precebo_db["cons_ajustado_fin"];
                                $row[44] = $precebo_db["ato_promedio_fin"];
                                $row[45] = $precebo_db["ato_promedio_dia_fin"];
                                $row[46] = $precebo_db["conversion_fin"];
                                $row[47] = $precebo_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                        $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                        $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                        $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                        $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                        $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                        $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                        $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                        $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                        $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                        $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                        $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                        $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                        $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                        $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                        $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                        $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                        $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                        $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                        $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                        $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                        $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                        $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                        $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                        $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                        $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                        $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                        $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                        $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                        $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                        $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                        $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                        $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                        $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                        $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                        $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                        $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                        $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                        $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                        $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                        $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                        $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                        $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                        $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                        $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                        $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                        $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                    }
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["conversion_ajust_ini"];
                                $row[43] = $precebo_db["cons_ajustado_fin"];
                                $row[44] = $precebo_db["ato_promedio_fin"];
                                $row[45] = $precebo_db["ato_promedio_dia_fin"];
                                $row[46] = $precebo_db["conversion_fin"];
                                $row[47] = $precebo_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }else{

                Excel::create('Filtro de Precebo por Lote del dia '.$date, function($excel) use($lote)
                {
                    $granjas = Granja::all();
                    $precebos = Precebo::all();
                    $g_as = AsociacionGranja::all();

                    if (Auth::User()->rol_id != 7) {  
                        foreach ($precebos as $precebo) 
                        {
                            if ($precebo->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($precebo->granja_id == $granja->id) 
                                    {   
                                        foreach ($g_as as $g) 
                                        {
                                            if ($g->user_id == Auth::User()->id) 
                                            {
                                                if ($precebo->granja_id == $g->granja_id)
                                                {
                                                    $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                                    $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                                    $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                                    $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                                    $precebos_db[$precebo->id]["semana_destete"] = $precebo->semana_destete;
                                                    $precebos_db[$precebo->id]["semana_traslado"] = $precebo->semana_traslado;
                                                    $precebos_db[$precebo->id]["año_destete"] = $precebo->año_destete;
                                                    $precebos_db[$precebo->id]["año_traslado"] = $precebo->año_traslado;
                                                    $precebos_db[$precebo->id]["mes_traslado"] = $precebo->mes_traslado;
                                                    $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                                    $precebos_db[$precebo->id]["edad_destete"] = $precebo->edad_destete;
                                                    $precebos_db[$precebo->id]["edad_inicial_total"] = $precebo->edad_inicial_total;
                                                    $precebos_db[$precebo->id]["dias_jaulon"] = $precebo->dias_jaulon;
                                                    $precebos_db[$precebo->id]["dias_totales_permanencia"] = $precebo->dias_totales_permanencia;
                                                    $precebos_db[$precebo->id]["edad_final"] = $precebo->edad_final;
                                                    $precebos_db[$precebo->id]["edad_final_ajustada"] = $precebo->edad_final_ajustada;
                                                    $precebos_db[$precebo->id]["peso_esperado"] = $precebo->peso_esperado;
                                                    $precebos_db[$precebo->id]["numero_muertes"] = $precebo->numero_muertes;
                                                    $precebos_db[$precebo->id]["numero_descartes"] = $precebo->numero_descartes;
                                                    $precebos_db[$precebo->id]["numero_livianos"] = $precebo->numero_livianos;
                                                    $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                                    $precebos_db[$precebo->id]["porciento_mortalidad"] = $precebo->porciento_mortalidad;
                                                    $precebos_db[$precebo->id]["porciento_descartes"] = $precebo->porciento_destetes;
                                                    $precebos_db[$precebo->id]["porciento_livianos"] = $precebo->porciento_livianos;
                                                    $precebos_db[$precebo->id]["peso_ini"] = $precebo->peso_ini;
                                                    $precebos_db[$precebo->id]["peso_promedio_ini"] = $precebo->peso_promedio_ini;
                                                    $precebos_db[$precebo->id]["peso_ponderado_ini"] = $precebo->peso_ponderado_ini;
                                                    $precebos_db[$precebo->id]["peso_fin"] = $precebo->peso_fin;
                                                    $precebos_db[$precebo->id]["peso_promedio_fin"] = $precebo->peso_promedio_fin;
                                                    $precebos_db[$precebo->id]["peso_ponderado_fin"] = $precebo->peso_ponderado_fin;
                                                    $precebos_db[$precebo->id]["ind_peso_final"] = $precebo->ind_peso_final;
                                                    $precebos_db[$precebo->id]["cons_total"] = $precebo->cons_total;
                                                    $precebos_db[$precebo->id]["cons_promedio"] = $precebo->cons_promedio;
                                                    $precebos_db[$precebo->id]["cons_ponderado"] = $precebo->cons_ponderado;
                                                    $precebos_db[$precebo->id]["cons_promedio_dia"] = $precebo->cons_ponderado;
                                                    $precebos_db[$precebo->id]["cons_promedio_ini"] = $precebo->cons_promedio_ini;
                                                    $precebos_db[$precebo->id]["cons_ponderado_ini"] = $precebo->cons_ponderado_ini;
                                                    $precebos_db[$precebo->id]["cons_promedio_dia_ini"] = $precebo->cons_promedio_dia_ini;
                                                    $precebos_db[$precebo->id]["cons_ajustado_ini"] = $precebo->cons_ajustado_ini;
                                                    $precebos_db[$precebo->id]["ato_promedio_ini"] = $precebo->ato_promedio_ini;
                                                    $precebos_db[$precebo->id]["ato_promedio_dia_ini"] = $precebo->ato_promedio_dia_ini;
                                                    $precebos_db[$precebo->id]["conversion_ini"] = $precebo->conversion_ini;
                                                    $precebos_db[$precebo->id]["conversion_ajust_ini"] = $precebo->conversion_ajust_ini;
                                                    $precebos_db[$precebo->id]["cons_ajustado_fin"] = $precebo->cons_ajustado_fin;
                                                    $precebos_db[$precebo->id]["ato_promedio_fin"] = $precebo->ato_promedio_fin;
                                                    $precebos_db[$precebo->id]["ato_promedio_dia_fin"] = $precebo->ato_promedio_dia_fin;
                                                    $precebos_db[$precebo->id]["conversion_fin"] = $precebo->conversion_fin;
                                                    $precebos_db[$precebo->id]["conversion_ajust_fin"] = $precebo->conversion_ajust_fin;
                                                }
                                            }
                                        }
                                    }   
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["conversion_ajust_ini"];
                                $row[43] = $precebo_db["cons_ajustado_fin"];
                                $row[44] = $precebo_db["ato_promedio_fin"];
                                $row[45] = $precebo_db["ato_promedio_dia_fin"];
                                $row[46] = $precebo_db["conversion_fin"];
                                $row[47] = $precebo_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }else{
                        foreach ($precebos as $precebo) 
                        {
                            if ($precebo->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($precebo->granja_id == $granja->id) 
                                    {   
                                        $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                        $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                        $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                        $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                        $precebos_db[$precebo->id]["semana_destete"] = $precebo->semana_destete;
                                        $precebos_db[$precebo->id]["semana_traslado"] = $precebo->semana_traslado;
                                        $precebos_db[$precebo->id]["año_destete"] = $precebo->año_destete;
                                        $precebos_db[$precebo->id]["año_traslado"] = $precebo->año_traslado;
                                        $precebos_db[$precebo->id]["mes_traslado"] = $precebo->mes_traslado;
                                        $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                        $precebos_db[$precebo->id]["edad_destete"] = $precebo->edad_destete;
                                        $precebos_db[$precebo->id]["edad_inicial_total"] = $precebo->edad_inicial_total;
                                        $precebos_db[$precebo->id]["dias_jaulon"] = $precebo->dias_jaulon;
                                        $precebos_db[$precebo->id]["dias_totales_permanencia"] = $precebo->dias_totales_permanencia;
                                        $precebos_db[$precebo->id]["edad_final"] = $precebo->edad_final;
                                        $precebos_db[$precebo->id]["edad_final_ajustada"] = $precebo->edad_final_ajustada;
                                        $precebos_db[$precebo->id]["peso_esperado"] = $precebo->peso_esperado;
                                        $precebos_db[$precebo->id]["numero_muertes"] = $precebo->numero_muertes;
                                        $precebos_db[$precebo->id]["numero_descartes"] = $precebo->numero_descartes;
                                        $precebos_db[$precebo->id]["numero_livianos"] = $precebo->numero_livianos;
                                        $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                        $precebos_db[$precebo->id]["porciento_mortalidad"] = $precebo->porciento_mortalidad;
                                        $precebos_db[$precebo->id]["porciento_descartes"] = $precebo->porciento_destetes;
                                        $precebos_db[$precebo->id]["porciento_livianos"] = $precebo->porciento_livianos;
                                        $precebos_db[$precebo->id]["peso_ini"] = $precebo->peso_ini;
                                        $precebos_db[$precebo->id]["peso_promedio_ini"] = $precebo->peso_promedio_ini;
                                        $precebos_db[$precebo->id]["peso_ponderado_ini"] = $precebo->peso_ponderado_ini;
                                        $precebos_db[$precebo->id]["peso_fin"] = $precebo->peso_fin;
                                        $precebos_db[$precebo->id]["peso_promedio_fin"] = $precebo->peso_promedio_fin;
                                        $precebos_db[$precebo->id]["peso_ponderado_fin"] = $precebo->peso_ponderado_fin;
                                        $precebos_db[$precebo->id]["ind_peso_final"] = $precebo->ind_peso_final;
                                        $precebos_db[$precebo->id]["cons_total"] = $precebo->cons_total;
                                        $precebos_db[$precebo->id]["cons_promedio"] = $precebo->cons_promedio;
                                        $precebos_db[$precebo->id]["cons_ponderado"] = $precebo->cons_ponderado;
                                        $precebos_db[$precebo->id]["cons_promedio_dia"] = $precebo->cons_ponderado;
                                        $precebos_db[$precebo->id]["cons_promedio_ini"] = $precebo->cons_promedio_ini;
                                        $precebos_db[$precebo->id]["cons_ponderado_ini"] = $precebo->cons_ponderado_ini;
                                        $precebos_db[$precebo->id]["cons_promedio_dia_ini"] = $precebo->cons_promedio_dia_ini;
                                        $precebos_db[$precebo->id]["cons_ajustado_ini"] = $precebo->cons_ajustado_ini;
                                        $precebos_db[$precebo->id]["ato_promedio_ini"] = $precebo->ato_promedio_ini;
                                        $precebos_db[$precebo->id]["ato_promedio_dia_ini"] = $precebo->ato_promedio_dia_ini;
                                        $precebos_db[$precebo->id]["conversion_ini"] = $precebo->conversion_ini;
                                        $precebos_db[$precebo->id]["conversion_ajust_ini"] = $precebo->conversion_ajust_ini;
                                        $precebos_db[$precebo->id]["cons_ajustado_fin"] = $precebo->cons_ajustado_fin;
                                        $precebos_db[$precebo->id]["ato_promedio_fin"] = $precebo->ato_promedio_fin;
                                        $precebos_db[$precebo->id]["ato_promedio_dia_fin"] = $precebo->ato_promedio_dia_fin;
                                        $precebos_db[$precebo->id]["conversion_fin"] = $precebo->conversion_fin;
                                        $precebos_db[$precebo->id]["conversion_ajust_fin"] = $precebo->conversion_ajust_fin;
                                    }   
                                }
                            }
                        }
                        $precebos_db = json_decode(json_encode($precebos_db), true);
                        $excel->sheet('Filtro', function($sheet) use($precebos_db)
                        {
                            foreach ($precebos_db as $precebo_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                                $row = [];
                                $row[0] = $precebo_db["lote"];
                                $row[1] = $precebo_db["granja"];
                                $row[2] = $precebo_db["fecha_destete"];
                                $row[3] = $precebo_db["fecha_traslado"];
                                $row[4] = $precebo_db["semana_destete"];
                                $row[5] = $precebo_db["semana_traslado"];
                                $row[6] = $precebo_db["año_destete"];
                                $row[7] = $precebo_db["año_traslado"];
                                $row[8] = $precebo_db["mes_traslado"];
                                $row[9] = $precebo_db["numero_inicial"];
                                $row[10] = $precebo_db["edad_destete"];
                                $row[11] = $precebo_db["edad_inicial_total"];
                                $row[12] = $precebo_db["dias_jaulon"];
                                $row[13] = $precebo_db["dias_totales_permanencia"];
                                $row[14] = $precebo_db["edad_final"];
                                $row[15] = $precebo_db["edad_final_ajustada"];
                                $row[16] = $precebo_db["peso_esperado"];
                                $row[17] = $precebo_db["numero_muertes"];
                                $row[18] = $precebo_db["numero_descartes"];
                                $row[19] = $precebo_db["numero_livianos"];
                                $row[20] = $precebo_db["numero_final"];
                                $row[21] = $precebo_db["porciento_mortalidad"];
                                $row[22] = $precebo_db["porciento_descartes"];
                                $row[23] = $precebo_db["porciento_livianos"];
                                $row[24] = $precebo_db["peso_ini"];
                                $row[25] = $precebo_db["peso_promedio_ini"];
                                $row[26] = $precebo_db["peso_ponderado_ini"];
                                $row[27] = $precebo_db["peso_fin"];
                                $row[28] = $precebo_db["peso_promedio_fin"];
                                $row[29] = $precebo_db["peso_ponderado_fin"];
                                $row[30] = $precebo_db["ind_peso_final"];
                                $row[31] = $precebo_db["cons_total"];
                                $row[32] = $precebo_db["cons_promedio"];
                                $row[33] = $precebo_db["cons_ponderado"];
                                $row[34] = $precebo_db["cons_promedio_dia"];
                                $row[35] = $precebo_db["cons_promedio_ini"];
                                $row[36] = $precebo_db["cons_ponderado_ini"];
                                $row[37] = $precebo_db["cons_promedio_dia_ini"];
                                $row[38] = $precebo_db["cons_ajustado_ini"];
                                $row[39] = $precebo_db["ato_promedio_ini"];
                                $row[40] = $precebo_db["ato_promedio_dia_ini"];
                                $row[41] = $precebo_db["conversion_ini"];
                                $row[42] = $precebo_db["conversion_ajust_ini"];
                                $row[43] = $precebo_db["cons_ajustado_fin"];
                                $row[44] = $precebo_db["ato_promedio_fin"];
                                $row[45] = $precebo_db["ato_promedio_dia_fin"];
                                $row[46] = $precebo_db["conversion_fin"];
                                $row[47] = $precebo_db["conversion_ajust_fin"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
        }
        elseif ($fecha_inicial != '+' && $fecha_final != '+') 
        {
            $date = Carbon::now();
            $date->format('d-m-y');
            Excel::create('Filtrado de Precebo por fechas del dia '.$date ,function ($excel) use($fecha_inicial,$fecha_final)
            {

                $granjas = Granja::all();
                $precebos = Precebo::all();
                $g_as = AsociacionGranja::all();

                $fechas = Precebo::whereBetween('fecha_traslado',[$fecha_inicial, $fecha_final] )->get();

                if (Auth::User()->rol_id != 7) 
                {
                    foreach ($g_as as $g) 
                    {
                        if ($g->user_id == Auth::User()->id) 
                            {
                            foreach ($fechas as $fecha) 
                            {
                                if ($g->granja_id == $fecha->granja_id) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($granja->id == $fecha->granja_id) 
                                        {
                                            $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                            $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                            $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                            $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                            $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                            $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                            $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                            $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                            $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                            $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                            $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                            $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                            $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                            $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                            $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                            $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                            $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                            $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                            $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                            $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                            $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                            $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                            $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                            $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                            $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                            $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                            $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                            $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                            $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                            $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                            $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                            $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                            $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                            $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                            $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                            $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                            $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                            $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                            $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                            $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                            $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                            $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                            $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                            $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                            $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                            $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                            $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $precebos_db = json_decode(json_encode($precebos_db), true);
                    $excel->sheet('Filtro', function($sheet) use($precebos_db)
                    {
                        foreach ($precebos_db as $precebo_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                            $row = [];
                            $row[0] = $precebo_db["lote"];
                            $row[1] = $precebo_db["granja"];
                            $row[2] = $precebo_db["fecha_destete"];
                            $row[3] = $precebo_db["fecha_traslado"];
                            $row[4] = $precebo_db["semana_destete"];
                            $row[5] = $precebo_db["semana_traslado"];
                            $row[6] = $precebo_db["año_destete"];
                            $row[7] = $precebo_db["año_traslado"];
                            $row[8] = $precebo_db["mes_traslado"];
                            $row[9] = $precebo_db["numero_inicial"];
                            $row[10] = $precebo_db["edad_destete"];
                            $row[11] = $precebo_db["edad_inicial_total"];
                            $row[12] = $precebo_db["dias_jaulon"];
                            $row[13] = $precebo_db["dias_totales_permanencia"];
                            $row[14] = $precebo_db["edad_final"];
                            $row[15] = $precebo_db["edad_final_ajustada"];
                            $row[16] = $precebo_db["peso_esperado"];
                            $row[17] = $precebo_db["numero_muertes"];
                            $row[18] = $precebo_db["numero_descartes"];
                            $row[19] = $precebo_db["numero_livianos"];
                            $row[20] = $precebo_db["numero_final"];
                            $row[21] = $precebo_db["porciento_mortalidad"];
                            $row[22] = $precebo_db["porciento_descartes"];
                            $row[23] = $precebo_db["porciento_livianos"];
                            $row[24] = $precebo_db["peso_ini"];
                            $row[25] = $precebo_db["peso_promedio_ini"];
                            $row[26] = $precebo_db["peso_ponderado_ini"];
                            $row[27] = $precebo_db["peso_fin"];
                            $row[28] = $precebo_db["peso_promedio_fin"];
                            $row[29] = $precebo_db["peso_ponderado_fin"];
                            $row[30] = $precebo_db["ind_peso_final"];
                            $row[31] = $precebo_db["cons_total"];
                            $row[32] = $precebo_db["cons_promedio"];
                            $row[33] = $precebo_db["cons_ponderado"];
                            $row[34] = $precebo_db["cons_promedio_dia"];
                            $row[35] = $precebo_db["cons_promedio_ini"];
                            $row[36] = $precebo_db["cons_ponderado_ini"];
                            $row[37] = $precebo_db["cons_promedio_dia_ini"];
                            $row[38] = $precebo_db["cons_ajustado_ini"];
                            $row[39] = $precebo_db["ato_promedio_ini"];
                            $row[40] = $precebo_db["ato_promedio_dia_ini"];
                            $row[41] = $precebo_db["conversion_ini"];
                            $row[42] = $precebo_db["conversion_ajust_ini"];
                            $row[43] = $precebo_db["cons_ajustado_fin"];
                            $row[44] = $precebo_db["ato_promedio_fin"];
                            $row[45] = $precebo_db["ato_promedio_dia_fin"];
                            $row[46] = $precebo_db["conversion_fin"];
                            $row[47] = $precebo_db["conversion_ajust_fin"];
                            $sheet->appendRow($row);
                        }
                    });
                }
                else
                {
                    foreach ($fechas as $fecha) 
                    {
                        foreach ($granjas as $granja) 
                        {
                            if ($granja->id == $fecha->granja_id) 
                            {
                                $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                $precebos_db[$fecha->id]["semana_destete"] = $fecha->semana_destete;
                                $precebos_db[$fecha->id]["semana_traslado"] = $fecha->semana_traslado;
                                $precebos_db[$fecha->id]["año_destete"] = $fecha->año_destete;
                                $precebos_db[$fecha->id]["año_traslado"] = $fecha->año_traslado;
                                $precebos_db[$fecha->id]["mes_traslado"] = $fecha->mes_traslado;
                                $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                $precebos_db[$fecha->id]["edad_destete"] = $fecha->edad_destete;
                                $precebos_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total;
                                $precebos_db[$fecha->id]["dias_jaulon"] = $fecha->dias_jaulon;
                                $precebos_db[$fecha->id]["dias_totales_permanencia"] = $fecha->dias_totales_permanencia;
                                $precebos_db[$fecha->id]["edad_final"] = $fecha->edad_final;
                                $precebos_db[$fecha->id]["edad_final_ajustada"] = $fecha->edad_final_ajustada;
                                $precebos_db[$fecha->id]["peso_esperado"] = $fecha->peso_esperado;
                                $precebos_db[$fecha->id]["numero_muertes"] = $fecha->numero_muertes;
                                $precebos_db[$fecha->id]["numero_descartes"] = $fecha->numero_descartes;
                                $precebos_db[$fecha->id]["numero_livianos"] = $fecha->numero_livianos;
                                $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;
                                $precebos_db[$fecha->id]["porciento_mortalidad"] = $fecha->porciento_mortalidad;
                                $precebos_db[$fecha->id]["porciento_descartes"] = $fecha->porciento_destetes;
                                $precebos_db[$fecha->id]["porciento_livianos"] = $fecha->porciento_livianos;
                                $precebos_db[$fecha->id]["peso_ini"] = $fecha->peso_ini;
                                $precebos_db[$fecha->id]["peso_promedio_ini"] = $fecha->peso_promedio_ini;
                                $precebos_db[$fecha->id]["peso_ponderado_ini"] = $fecha->peso_ponderado_ini;
                                $precebos_db[$fecha->id]["peso_fin"] = $fecha->peso_fin;
                                $precebos_db[$fecha->id]["peso_promedio_fin"] = $fecha->peso_promedio_fin;
                                $precebos_db[$fecha->id]["peso_ponderado_fin"] = $fecha->peso_ponderado_fin;
                                $precebos_db[$fecha->id]["ind_peso_final"] = $fecha->ind_peso_final;
                                $precebos_db[$fecha->id]["cons_total"] = $fecha->cons_total;
                                $precebos_db[$fecha->id]["cons_promedio"] = $fecha->cons_promedio;
                                $precebos_db[$fecha->id]["cons_ponderado"] = $fecha->cons_ponderado;
                                $precebos_db[$fecha->id]["cons_promedio_dia"] = $fecha->cons_ponderado;
                                $precebos_db[$fecha->id]["cons_promedio_ini"] = $fecha->cons_promedio_ini;
                                $precebos_db[$fecha->id]["cons_ponderado_ini"] = $fecha->cons_ponderado_ini;
                                $precebos_db[$fecha->id]["cons_promedio_dia_ini"] = $fecha->cons_promedio_dia_ini;
                                $precebos_db[$fecha->id]["cons_ajustado_ini"] = $fecha->cons_ajustado_ini;
                                $precebos_db[$fecha->id]["ato_promedio_ini"] = $fecha->ato_promedio_ini;
                                $precebos_db[$fecha->id]["ato_promedio_dia_ini"] = $fecha->ato_promedio_dia_ini;
                                $precebos_db[$fecha->id]["conversion_ini"] = $fecha->conversion_ini;
                                $precebos_db[$fecha->id]["conversion_ajust_ini"] = $fecha->conversion_ajust_ini;
                                $precebos_db[$fecha->id]["cons_ajustado_fin"] = $fecha->cons_ajustado_fin;
                                $precebos_db[$fecha->id]["ato_promedio_fin"] = $fecha->ato_promedio_fin;
                                $precebos_db[$fecha->id]["ato_promedio_dia_fin"] = $fecha->ato_promedio_dia_fin;
                                $precebos_db[$fecha->id]["conversion_fin"] = $fecha->conversion_fin;
                                $precebos_db[$fecha->id]["conversion_ajust_fin"] = $fecha->conversion_ajust_fin;
                            }
                        }   
                    }
                    $precebos_db = json_decode(json_encode($precebos_db), true);
                    $excel->sheet('Filtro', function($sheet) use($precebos_db)
                    {
                        foreach ($precebos_db as $precebo_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', '# Muertes', '# Descartes', '# Livianos', '# Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final']);
                            $row = [];
                            $row[0] = $precebo_db["lote"];
                            $row[1] = $precebo_db["granja"];
                            $row[2] = $precebo_db["fecha_destete"];
                            $row[3] = $precebo_db["fecha_traslado"];
                            $row[4] = $precebo_db["semana_destete"];
                            $row[5] = $precebo_db["semana_traslado"];
                            $row[6] = $precebo_db["año_destete"];
                            $row[7] = $precebo_db["año_traslado"];
                            $row[8] = $precebo_db["mes_traslado"];
                            $row[9] = $precebo_db["numero_inicial"];
                            $row[10] = $precebo_db["edad_destete"];
                            $row[11] = $precebo_db["edad_inicial_total"];
                            $row[12] = $precebo_db["dias_jaulon"];
                            $row[13] = $precebo_db["dias_totales_permanencia"];
                            $row[14] = $precebo_db["edad_final"];
                            $row[15] = $precebo_db["edad_final_ajustada"];
                            $row[16] = $precebo_db["peso_esperado"];
                            $row[17] = $precebo_db["numero_muertes"];
                            $row[18] = $precebo_db["numero_descartes"];
                            $row[19] = $precebo_db["numero_livianos"];
                            $row[20] = $precebo_db["numero_final"];
                            $row[21] = $precebo_db["porciento_mortalidad"];
                            $row[22] = $precebo_db["porciento_descartes"];
                            $row[23] = $precebo_db["porciento_livianos"];
                            $row[24] = $precebo_db["peso_ini"];
                            $row[25] = $precebo_db["peso_promedio_ini"];
                            $row[26] = $precebo_db["peso_ponderado_ini"];
                            $row[27] = $precebo_db["peso_fin"];
                            $row[28] = $precebo_db["peso_promedio_fin"];
                            $row[29] = $precebo_db["peso_ponderado_fin"];
                            $row[30] = $precebo_db["ind_peso_final"];
                            $row[31] = $precebo_db["cons_total"];
                            $row[32] = $precebo_db["cons_promedio"];
                            $row[33] = $precebo_db["cons_ponderado"];
                            $row[34] = $precebo_db["cons_promedio_dia"];
                            $row[35] = $precebo_db["cons_promedio_ini"];
                            $row[36] = $precebo_db["cons_ponderado_ini"];
                            $row[37] = $precebo_db["cons_promedio_dia_ini"];
                            $row[38] = $precebo_db["cons_ajustado_ini"];
                            $row[39] = $precebo_db["ato_promedio_ini"];
                            $row[40] = $precebo_db["ato_promedio_dia_ini"];
                            $row[41] = $precebo_db["conversion_ini"];
                            $row[42] = $precebo_db["conversion_ajust_ini"];
                            $row[43] = $precebo_db["cons_ajustado_fin"];
                            $row[44] = $precebo_db["ato_promedio_fin"];
                            $row[45] = $precebo_db["ato_promedio_dia_fin"];
                            $row[46] = $precebo_db["conversion_fin"];
                            $row[47] = $precebo_db["conversion_ajust_fin"];
                            $sheet->appendRow($row);
                        }
                    });
                }
            })->export('csv');
        }    
    }
    /**
    * permite descargar un archivo que viene desde la vista 
    * filtro_mortalidad_precebo_ceba.blade.php dependiendo de los parametros que vienen
    * desde dicha vista
    *
    * @var Granja
    * @var ReporteMortalidadPreceboCeba
    * @var AsociacionGranja
    * @var CausaMuerte
    * @var Alimento
    * @param int $gr 
    * @param int $lote
    * @param date $fecha_inicial
    * @param date $fecha_final
    * @return archivo.csv
    */

    public function filtroPorMortalidadPreceboCeba($gr, $lote,$fecha_inicial,$fecha_final)
    {
        $date = Carbon::now();
        $date->format('D-M-Y');
        if($gr != 0 && $lote != '*')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') {
                Excel::create('Filtro de Mortalidad Precebo y Ceba con Granja, Lote y Fecha del dia '.$date,function($excel) use($gr,$lote,$fecha_inicial,$fecha_final){
                    $granjas = Granja::all();
                    $reportes = ReporteMortalidadPreceboCeba::all();
                    $g_as = AsociacionGranja::all();
                    $causas = CausaMuerte::all();
                    $alimentos = Alimento::all();
                    $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$fecha_inicial, $fecha_final])->get();
                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                if ($fecha->lote == $lote) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id)
                                        {
                                            foreach ($causas as $causa) 
                                            {
                                                if ($fecha->causa_id == $causa->id) 
                                                {
                                                    foreach ($alimentos as $alimento) 
                                                    {
                                                        if ($fecha->alimento_id == $alimento->id) 
                                                        {
                                                            $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                            $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                            $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                            $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                            $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                            $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                            $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                            $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                            $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                            $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                            $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                            $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                            $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                if ($fecha->lote == $lote) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            foreach ($causas as $causa) 
                                            {
                                                if ($fecha->causa_id == $causa->id) 
                                                {
                                                    foreach ($alimentos as $alimento) 
                                                    {
                                                        if ($fecha->alimento_id == $alimento->id) 
                                                        {
                                                            $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                            $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                            $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                            $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                            $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                            $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                            $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                            $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                            $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                            $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                            $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                            $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                            $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        });
                    }       
                })->export('csv');
            }else{
                Excel::create('Filtro de Mortalidad Precebo y Ceba por Granja y Lote del dia '.$date, function($excel) use($gr, $lote)
                {
                    $granjas = Granja::all();
                    $reportes = ReporteMortalidadPreceboCeba::all();
                    $g_as = AsociacionGranja::all();
                    $causas = CausaMuerte::all();
                    $alimentos = Alimento::all();

                    foreach ($reportes as $reporte) 
                    {
                        if ($reporte->lote == $lote) 
                        {
                            foreach ($granjas as $granja)
                            {
                                if ($reporte->granja_id == $granja->id) 
                                {
                                    if ($granja->id == $gr) 
                                    { 
                                        foreach ($causas as $causa) 
                                        {
                                            if ($reporte->causa_id == $causa->id) 
                                            {
                                                foreach ($alimentos as $alimento) 
                                                {
                                                    if ($reporte->alimento_id == $alimento->id) 
                                                    {
                                                        $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                                        $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                                        $reportes_db[$reporte->id]["sala"] = $reporte->sala;
                                                        $reportes_db[$reporte->id]["numero_cerdos"] = $reporte->numero_cerdos;
                                                        $reportes_db[$reporte->id]["sexo_cerdo"] = $reporte->sexo_cerdo;
                                                        $reportes_db[$reporte->id]["peso_cerdo"] = $reporte->peso_cerdo;
                                                        $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                                        $reportes_db[$reporte->id]["dia_muerte"] = $reporte->dia_muerte;
                                                        $reportes_db[$reporte->id]["año_muerte"] = $reporte->año_muerte;
                                                        $reportes_db[$reporte->id]["mes_muerte"] = $reporte->mes_muerte;
                                                        $reportes_db[$reporte->id]["semana_muerte"] = $reporte->semana_muerte;
                                                        $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                                        $reportes_db[$reporte->id]["alimento"] = $alimento->nombre_alimento;
                                                    }
                                                }
                                            }
                                        }   
                                    }   
                                }   
                            }
                        }
                    }
                    $reportes_db = json_decode(json_encode($reportes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($reportes_db)
                    {
                        foreach ($reportes_db as $reporte_db) 
                        {
                            $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                            $row = [];
                            $row[0] = $reporte_db["granja"];
                            $row[1] = $reporte_db["lote"];
                            $row[2] = $reporte_db["sala"];
                            $row[3] = $reporte_db["numero_cerdos"];
                            $row[4] = $reporte_db["sexo_cerdo"];
                            $row[5] = $reporte_db["peso_cerdo"];
                            $row[6] = $reporte_db["fecha"];
                            $row[7] = $reporte_db["dia_muerte"];
                            $row[8] = $reporte_db["año_muerte"];
                            $row[9] = $reporte_db["mes_muerte"];
                            $row[10] = $reporte_db["semana_muerte"];
                            $row[11] = $reporte_db["causa"];
                            $row[12] = $reporte_db["alimento"];
                            $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }
        }
        elseif($gr != '0')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtro de Mortalidad de Precebo y Ceba por Granja y Fecha del dia '.$date,function($excel) use($gr,$fecha_inicial,$fecha_final)
                {

                    $granjas = Granja::all();
                    $reportes = ReporteMortalidadPreceboCeba::all();
                    $g_as = AsociacionGranja::all();
                    $causas = CausaMuerte::all();
                    $alimentos = Alimento::all();
                    $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$fecha_inicial, $fecha_final])->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        foreach ($causas as $causa) 
                                        {
                                            if ($fecha->causa_id == $causa->id) 
                                            {
                                                foreach ($alimentos as $alimento) 
                                                {
                                                    if ($fecha->alimento_id == $alimento->id) 
                                                    {
                                                        $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                        $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                        $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                        $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                        $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                        $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                        $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                        $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                        $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                        $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                        $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                        $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                        $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento; 
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        foreach ($causas as $causa) 
                                        {
                                            if ($fecha->causa_id == $causa->id) 
                                            {
                                                foreach ($alimentos as $alimento) 
                                                {
                                                    if ($fecha->alimento_id == $alimento->id) 
                                                    {
                                                       $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                        $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                        $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                        $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                        $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                        $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                        $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                        $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                        $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                        $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                        $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                        $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                        $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento; 
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
            else
            {
                Excel::create('Filtro de Mortalidad Precebo y Ceba por Granja del dia '.$date, function($excel) use($gr)
                {
                    $granjas = Granja::all();
                    $reportes = ReporteMortalidadPreceboCeba::all();
                    $g_as = AsociacionGranja::all();
                    $causas = CausaMuerte::all();
                    $alimentos = Alimento::all();

                    foreach ($reportes as $reporte) 
                    {
                        foreach ($granjas as $granja)
                        {
                            if ($reporte->granja_id == $granja->id) 
                            {
                                if ($granja->id == $gr) 
                                {
                                    foreach ($causas as $causa) 
                                    {
                                        if ($reporte->causa_id == $causa->id) 
                                        {
                                            foreach ($alimentos as $alimento) 
                                            {
                                                if ($reporte->alimento_id == $alimento->id) 
                                                {
                                                    $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                                    $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                                    $reportes_db[$reporte->id]["sala"] = $reporte->sala;
                                                    $reportes_db[$reporte->id]["numero_cerdos"] = $reporte->numero_cerdos;
                                                    $reportes_db[$reporte->id]["sexo_cerdo"] = $reporte->sexo_cerdo;
                                                    $reportes_db[$reporte->id]["peso_cerdo"] = $reporte->peso_cerdo;
                                                    $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                                    $reportes_db[$reporte->id]["dia_muerte"] = $reporte->dia_muerte;
                                                    $reportes_db[$reporte->id]["año_muerte"] = $reporte->año_muerte;
                                                    $reportes_db[$reporte->id]["mes_muerte"] = $reporte->mes_muerte;
                                                    $reportes_db[$reporte->id]["semana_muerte"] = $reporte->semana_muerte;
                                                    $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                                    $reportes_db[$reporte->id]["alimento"] = $alimento->nombre_alimento;
                                                }
                                            }
                                        }
                                    }   
                                }   
                            }   
                        }
                    }
                    $reportes_db = json_decode(json_encode($reportes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($reportes_db)
                    {
                        foreach ($reportes_db as $reporte_db) 
                        {
                            $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                            $row = [];
                            $row[0] = $reporte_db["granja"];
                            $row[1] = $reporte_db["lote"];
                            $row[2] = $reporte_db["sala"];
                            $row[3] = $reporte_db["numero_cerdos"];
                            $row[4] = $reporte_db["sexo_cerdo"];
                            $row[5] = $reporte_db["peso_cerdo"];
                            $row[6] = $reporte_db["fecha"];
                            $row[7] = $reporte_db["dia_muerte"];
                            $row[8] = $reporte_db["año_muerte"];
                            $row[9] = $reporte_db["mes_muerte"];
                            $row[10] = $reporte_db["semana_muerte"];
                            $row[11] = $reporte_db["causa"];
                            $row[12] = $reporte_db["alimento"];
                            $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }
        }
        elseif($lote != '*')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtrado de Mortalidad Precebo y Ceba por Lote y Fecha del dia '.$date,function ($excel) use($lote,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $reportes = ReporteMortalidadPreceboCeba::all();
                    $g_as = AsociacionGranja::all();
                    $causas = CausaMuerte::all();
                    $alimentos = Alimento::all();
                    $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$fecha_inicial, $fecha_final])->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote) 
                            {
                                foreach ($g_as as $g) 
                                {
                                    if ($g->user_id == Auth::User()->id) 
                                        {
                                        if ($fecha->granja_id == $g->granja_id) 
                                        {
                                            foreach ($granjas as $granja) 
                                            {
                                                if ($fecha->granja_id == $granja->id) 
                                                {
                                                    foreach ($causas as $causa) 
                                                    {
                                                        if ($fecha->causa_id == $causa->id) 
                                                        {
                                                            foreach ($alimentos as $alimento) 
                                                            {
                                                                if ($fecha->alimento_id == $alimento->id) {
                                                                    $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                                    $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                                    $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                                    $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                                    $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                                    $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                                    $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                                    $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                                    $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                                    $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                                    $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                                    $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                                    $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento; 
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        foreach ($causas as $causa) 
                                        {
                                            if ($fecha->causa_id == $causa->id) 
                                            {
                                                foreach ($alimentos as $alimento) 
                                                {
                                                    if ($fecha->alimento_id == $alimento->id) 
                                                    {
                                                        $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                        $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                        $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                        $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                        $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                        $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                        $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                        $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                        $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                        $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                        $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                        $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                        $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento; 
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }else{
                Excel::create('Filtro de Mortalidad Precebo y Ceba por Lote del dia '.$date, function($excel) use($lote)
                {
                    $granjas = Granja::all();
                    $reportes = ReporteMortalidadPreceboCeba::all();
                    $g_as = AsociacionGranja::all();
                    $causas = CausaMuerte::all();
                    $alimentos = Alimento::all();

                    if (Auth::User()->rol_id != 7) {
                        foreach ($reportes as $reporte) 
                        {
                            if ($reporte->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($reporte->granja_id == $granja->id) 
                                    {
                                        foreach ($causas as $causa) 
                                        {
                                            if ($reporte->causa_id == $causa->id) 
                                            {
                                                foreach ($alimentos as $alimento) 
                                                {
                                                    if ($reporte->alimento_id == $alimento->id) 
                                                    {
                                                        foreach ($g_as as $g) 
                                                        {
                                                            if ($g->user_id == Auth::User()->id) 
                                                            {
                                                                if ($g->granja_id == $reporte->granja_id) 
                                                                {
                                                                    $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                                                    $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                                                    $reportes_db[$reporte->id]["sala"] = $reporte->sala;
                                                                    $reportes_db[$reporte->id]["numero_cerdos"] = $reporte->numero_cerdos;
                                                                    $reportes_db[$reporte->id]["sexo_cerdo"] = $reporte->sexo_cerdo;
                                                                    $reportes_db[$reporte->id]["peso_cerdo"] = $reporte->peso_cerdo;
                                                                    $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                                                    $reportes_db[$reporte->id]["dia_muerte"] = $reporte->dia_muerte;
                                                                    $reportes_db[$reporte->id]["año_muerte"] = $reporte->año_muerte;
                                                                    $reportes_db[$reporte->id]["mes_muerte"] = $reporte->mes_muerte;
                                                                    $reportes_db[$reporte->id]["semana_muerte"] = $reporte->semana_muerte;
                                                                    $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                                                    $reportes_db[$reporte->id]["alimento"] = $alimento->nombre_alimento;
                                                                }
                                                            }
                                                        } 
                                                    }
                                                }
                                            }
                                        }      
                                    }   
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        });
                    }else{
                       foreach ($reportes as $reporte) 
                        {
                            if ($reporte->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($reporte->granja_id == $granja->id) 
                                    {
                                        foreach ($causas as $causa) 
                                        {
                                            if ($reporte->causa_id == $causa->id) 
                                            {
                                                foreach ($alimentos as $alimento) 
                                                {
                                                    if ($reporte->alimento_id == $alimento->id) 
                                                    {
                                                        $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                                        $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                                        $reportes_db[$reporte->id]["sala"] = $reporte->sala;
                                                        $reportes_db[$reporte->id]["numero_cerdos"] = $reporte->numero_cerdos;
                                                        $reportes_db[$reporte->id]["sexo_cerdo"] = $reporte->sexo_cerdo;
                                                        $reportes_db[$reporte->id]["peso_cerdo"] = $reporte->peso_cerdo;
                                                        $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                                        $reportes_db[$reporte->id]["dia_muerte"] = $reporte->dia_muerte;
                                                        $reportes_db[$reporte->id]["año_muerte"] = $reporte->año_muerte;
                                                        $reportes_db[$reporte->id]["mes_muerte"] = $reporte->mes_muerte;
                                                        $reportes_db[$reporte->id]["semana_muerte"] = $reporte->semana_muerte;
                                                        $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                                        $reportes_db[$reporte->id]["alimento"] = $alimento->nombre_alimento;
                                                    }
                                                }
                                            }
                                        }      
                                    }   
                                }
                            }
                        }
                        $reportes_db = json_decode(json_encode($reportes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($reportes_db)
                        {
                            foreach ($reportes_db as $reporte_db) 
                            {
                                $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                                $row = [];
                                $row[0] = $reporte_db["granja"];
                                $row[1] = $reporte_db["lote"];
                                $row[2] = $reporte_db["sala"];
                                $row[3] = $reporte_db["numero_cerdos"];
                                $row[4] = $reporte_db["sexo_cerdo"];
                                $row[5] = $reporte_db["peso_cerdo"];
                                $row[6] = $reporte_db["fecha"];
                                $row[7] = $reporte_db["dia_muerte"];
                                $row[8] = $reporte_db["año_muerte"];
                                $row[9] = $reporte_db["mes_muerte"];
                                $row[10] = $reporte_db["semana_muerte"];
                                $row[11] = $reporte_db["causa"];
                                $row[12] = $reporte_db["alimento"];
                                $sheet->appendRow($row);
                            }
                        }); 
                    }
                })->export('csv');  
            }
        }
        elseif ($fecha_inicial != '+' && $fecha_final != '+') 
        {
            Excel::create('Filtrado de Mortalidad de Precebo y Ceba por Fecha del dia '.$date,function ($excel) use($fecha_inicial,$fecha_final){
                $granjas = Granja::all();
                $reportes = ReporteMortalidadPreceboCeba::all();
                $g_as = AsociacionGranja::all();
                $causas = CausaMuerte::all();
                $alimentos = Alimento::all();
                $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$fecha_inicial, $fecha_final])->get();

                if (Auth::User()->rol_id != 7) 
                {
                    foreach ($g_as as $g) 
                    {
                        if ($g->user_id == Auth::User()->id) 
                            {
                            foreach ($fechas as $fecha) 
                            {
                                if ($g->granja_id == $fecha->granja_id) 
                                {
                                    foreach ($granjas as $granja) {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            foreach ($causas as $causa) 
                                            {
                                                if ($fecha->causa_id == $causa->id) 
                                                {
                                                    foreach ($alimentos as $alimento) 
                                                    {
                                                        if ($fecha->alimento_id == $alimento->id) 
                                                        {
                                                            $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                            $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                            $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                            $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                            $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                            $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                            $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                            $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                            $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                            $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                            $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                            $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                            $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $reportes_db = json_decode(json_encode($reportes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($reportes_db)
                    {
                        foreach ($reportes_db as $reporte_db) 
                        {
                            $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                            $row = [];
                            $row[0] = $reporte_db["granja"];
                            $row[1] = $reporte_db["lote"];
                            $row[2] = $reporte_db["sala"];
                            $row[3] = $reporte_db["numero_cerdos"];
                            $row[4] = $reporte_db["sexo_cerdo"];
                            $row[5] = $reporte_db["peso_cerdo"];
                            $row[6] = $reporte_db["fecha"];
                            $row[7] = $reporte_db["dia_muerte"];
                            $row[8] = $reporte_db["año_muerte"];
                            $row[9] = $reporte_db["mes_muerte"];
                            $row[10] = $reporte_db["semana_muerte"];
                            $row[11] = $reporte_db["causa"];
                            $row[12] = $reporte_db["alimento"];
                            $sheet->appendRow($row);
                        }
                    });
                }
                else
                {
                    foreach ($fechas as $fecha) 
                    {
                        foreach ($granjas as $granja) 
                        {
                            if ($fecha->granja_id == $granja->id) 
                            {
                                foreach ($causas as $causa) 
                                {
                                    if ($fecha->causa_id == $causa->id) 
                                    {
                                        foreach ($alimentos as $alimento) 
                                        {
                                            if ($fecha->alimento_id == $alimento->id) 
                                            {
                                                $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                $reportes_db[$fecha->id]["sala"] = $fecha->sala;
                                                $reportes_db[$fecha->id]["numero_cerdos"] = $fecha->numero_cerdos;
                                                $reportes_db[$fecha->id]["sexo_cerdo"] = $fecha->sexo_cerdo;
                                                $reportes_db[$fecha->id]["peso_cerdo"] = $fecha->peso_cerdo;
                                                $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                $reportes_db[$fecha->id]["dia_muerte"] = $fecha->dia_muerte;
                                                $reportes_db[$fecha->id]["año_muerte"] = $fecha->año_muerte;
                                                $reportes_db[$fecha->id]["mes_muerte"] = $fecha->mes_muerte;
                                                $reportes_db[$fecha->id]["semana_muerte"] = $fecha->semana_muerte;
                                                $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                $reportes_db[$fecha->id]["alimento"] = $alimento->nombre_alimento;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $reportes_db = json_decode(json_encode($reportes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($reportes_db)
                    {
                        foreach ($reportes_db as $reporte_db) 
                        {
                            $sheet->row(1, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                            $row = [];
                            $row[0] = $reporte_db["granja"];
                            $row[1] = $reporte_db["lote"];
                            $row[2] = $reporte_db["sala"];
                            $row[3] = $reporte_db["numero_cerdos"];
                            $row[4] = $reporte_db["sexo_cerdo"];
                            $row[5] = $reporte_db["peso_cerdo"];
                            $row[6] = $reporte_db["fecha"];
                            $row[7] = $reporte_db["dia_muerte"];
                            $row[8] = $reporte_db["año_muerte"];
                            $row[9] = $reporte_db["mes_muerte"];
                            $row[10] = $reporte_db["semana_muerte"];
                            $row[11] = $reporte_db["causa"];
                            $row[12] = $reporte_db["alimento"];
                            $sheet->appendRow($row);
                        }
                    });
                }
            })->export('csv');
        }
    }
    /**
    * permite descargar un archivo desde la vista filtro_destete_finalizacion.blade.php
    * registros desde la base de datos de acuerdo a los parametros que se le envien de la vista
    *
    * @var Granja
    * @var DesteteFinalizacion
    * @var AsociacionGranja
    * @param int $gr
    * @param int $lote
    * @param date $fecha_inicial
    * @param date $fecha_final
    * @return archivo.csv
    */

    public function filtroDesteteFinalizacion($gr, $lote,$fecha_inicial,$fecha_final)
    {
        $date = Carbon::now();
        $date->format('D-M-Y');
        if($gr != 0 && $lote != '0')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtro de Destete Finalización por Granja,Lote y Fecha del dia '.$date,function($excel) use($gr,$lote,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $destetes = DesteteFinalizacion::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = DesteteFinalizacion::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                if ($fecha->lote == $lote) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            if ($granja->id == $gr) 
                                            {
                                                $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                                $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                                $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                                $destetes_db[$fecha->id]["año"] = $fecha->año;
                                                $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                                $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                                $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                                $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                                $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                                $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                                $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                                $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                                $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                                $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                                $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                                $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                                $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                                $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                                $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                                $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                                $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                                $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                                $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                                $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                                $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                                $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                                $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                                $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                                $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                if ($fecha->lote == $lote) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            if ($granja->id == $gr) 
                                            {
                                                $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                                $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                                $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                                $destetes_db[$fecha->id]["año"] = $fecha->año;
                                                $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                                $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                                $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                                $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                                $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                                $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                                $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                                $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                                $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                                $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                                $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                                $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                                $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                                $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                                $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                                $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                                $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                                $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                                $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                                $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                                $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                                $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                                $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                                $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                                $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }else{
                Excel::create('Filtro de Destete Finalizacion Por Granja y Lote del dia '.$date, function($excel) use($gr, $lote)
                {
                    $granjas = Granja::all();
                    $destetes = DesteteFinalizacion::all();
                    $g_as = AsociacionGranja::all();

                    foreach ($destetes as $destete) 
                    {
                        if ($destete->lote == $lote) 
                        {
                            foreach ($granjas as $granja)
                            {
                                if ($destete->granja_id == $granja->id) 
                                {
                                    if ($granja->id == $gr) 
                                    {
                                        
                                        $destetes_db[$destete->id]["lote"] = $destete->lote;
                                        $destetes_db[$destete->id]["granja"] = $granja->nombre_granja;
                                        $destetes_db[$destete->id]["fecha_ingreso_lote"] = $destete->fecha_ingreso_lote;
                                        $destetes_db[$destete->id]["fecha_salida_lote"] = $destete->fecha_salida_lote;
                                        $destetes_db[$destete->id]["año"] = $destete->año;
                                        $destetes_db[$destete->id]["mes"] = $destete->mes;
                                        $destetes_db[$destete->id]["semana"] = $destete->semana;
                                        $destetes_db[$destete->id]["inic"] = $destete->inic;
                                        $destetes_db[$destete->id]["cerdos_descartados"] = $destete->cerdos_descartados;
                                        $destetes_db[$destete->id]["cerdos_livianos"] = $destete->cerdos_livianos;
                                        $destetes_db[$destete->id]["muertes"] = $destete->muertes;
                                        $destetes_db[$destete->id]["cant_final_cerdos"] = $destete->cant_final_cerdos;
                                        $destetes_db[$destete->id]["meta_cerdos"] = $destete->meta_cerdos; 
                                        $destetes_db[$destete->id]["edad_inicial"] = $destete->edad_inicial; 
                                        $destetes_db[$destete->id]["edad_inicial_total"] = $destete->edad_inicial_total; 
                                        $destetes_db[$destete->id]["dias"] = $destete->dias;  
                                        $destetes_db[$destete->id]["dias_permanencia"] = $destete->dias_permanencia; 
                                        $destetes_db[$destete->id]["edad_final"] = $destete->edad_final; 
                                        $destetes_db[$destete->id]["edad_final_total"] = $destete->edad_final_total; 
                                        $destetes_db[$destete->id]["conf_edad_final"] = $destete->conf_edad_final; 
                                        $destetes_db[$destete->id]["por_mortalidad"] = $destete->por_mortalidad; 
                                        $destetes_db[$destete->id]["por_descartes"] = $destete->por_descartes; 
                                        $destetes_db[$destete->id]["por_livianos"] = $destete->por_livianos; 
                                        $destetes_db[$destete->id]["peso_total_ingresado"] = $destete->peso_total_ingresado; 
                                        $destetes_db[$destete->id]["peso_promedio_ingresado"] = $destete->peso_promedio_ingresado; 
                                        $destetes_db[$destete->id]["peso_total_vendido"] = $destete->peso_total_vendido; 
                                        $destetes_db[$destete->id]["peso_promedio_vendido"] = $destete->peso_promedio_vendido;
                                        $destetes_db[$destete->id]["consumo_lote"] = $destete->consumo_lote; 
                                        $destetes_db[$destete->id]["consumo_promedio_lote"] = $destete->consumo_promedio_lote; 
                                        $destetes_db[$destete->id]["consumo_promedio_lote_dias"] = $destete->consumo_promedio_lote_dias;      
                                    }   
                                }   
                            }
                        }
                    }
                    $destetes_db = json_decode(json_encode($destetes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($destetes_db)
                    {
                        foreach ($destetes_db as $destete_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                            $row = [];
                            $row[0] = $destete_db["lote"];
                            $row[1] = $destete_db["granja"];
                            $row[2] = $destete_db["fecha_ingreso_lote"];
                            $row[3] = $destete_db["fecha_salida_lote"];
                            $row[4] = $destete_db["año"];
                            $row[5] = $destete_db["mes"];
                            $row[6] = $destete_db["semana"];
                            $row[7] = $destete_db["inic"];
                            $row[8] = $destete_db["cerdos_descartados"];
                            $row[9] = $destete_db["cerdos_livianos"];
                            $row[10] = $destete_db["muertes"];
                            $row[11] = $destete_db["cant_final_cerdos"];
                            $row[12] = $destete_db["meta_cerdos"];
                            $row[13] = $destete_db["edad_inicial"];
                            $row[14] = $destete_db["edad_inicial_total"];
                            $row[15] = $destete_db["dias"];
                            $row[16] = $destete_db["dias_permanencia"];
                            $row[17] = $destete_db["edad_final"];
                            $row[18] = $destete_db["edad_final_total"];
                            $row[19] = $destete_db["conf_edad_final"];
                            $row[20] = $destete_db["por_mortalidad"];
                            $row[21] = $destete_db["por_descartes"];
                            $row[22] = $destete_db["por_livianos"];
                            $row[23] = $destete_db["peso_total_ingresado"];
                            $row[24] = $destete_db["peso_promedio_ingresado"];
                            $row[25] = $destete_db["peso_total_vendido"];
                            $row[26] = $destete_db["peso_promedio_vendido"];
                            $row[27] = $destete_db["consumo_lote"];
                            $row[28] = $destete_db["consumo_promedio_lote"];
                            $row[29] = $destete_db["consumo_promedio_lote_dias"];
                            $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }
        }
        elseif($gr != '0')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtro de Destete Finalización por Granja y Fecha del dia '.$date,function($excel) use($gr,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $destetes = DesteteFinalizacion::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = DesteteFinalizacion::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        if ($granja->id == $gr) 
                                        {
                                            $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                            $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                            $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                            $destetes_db[$fecha->id]["año"] = $fecha->año;
                                            $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                            $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                            $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                            $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                            $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                            $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                            $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                            $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                            $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                            $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                            $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                            $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                            $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                            $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                            $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                            $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                            $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                            $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                            $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                            $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                            $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                            $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                            $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                            $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                            $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                        }
                                    }
                                }
                            }
                        }
                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->granja_id == $gr) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        if ($granja->id == $gr) 
                                        {
                                            $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                            $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                            $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                            $destetes_db[$fecha->id]["año"] = $fecha->año;
                                            $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                            $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                            $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                            $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                            $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                            $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                            $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                            $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                            $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                            $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                            $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                            $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                            $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                            $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                            $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                            $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                            $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                            $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                            $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                            $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                            $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                            $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                            $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                            $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                            $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                        }
                                    }
                                }
                            }
                        }
                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
            else
            {
                Excel::create('Filtro de Destete Finalizacion por Granja del dia '.$date, function($excel) use($gr)
                {
                    $granjas = Granja::all();
                    $destetes = DesteteFinalizacion::all();
                    $g_as = AsociacionGranja::all();

                    foreach ($destetes as $destete) 
                    {
                        foreach ($granjas as $granja)
                        {
                            if ($destete->granja_id == $granja->id) 
                            {
                                if ($granja->id == $gr) 
                                {
                                    $destetes_db[$destete->id]["lote"] = $destete->lote;
                                    $destetes_db[$destete->id]["granja"] = $granja->nombre_granja;
                                    $destetes_db[$destete->id]["fecha_ingreso_lote"] = $destete->fecha_ingreso_lote;
                                    $destetes_db[$destete->id]["fecha_salida_lote"] = $destete->fecha_salida_lote;
                                    $destetes_db[$destete->id]["año"] = $destete->año;
                                    $destetes_db[$destete->id]["mes"] = $destete->mes;
                                    $destetes_db[$destete->id]["semana"] = $destete->semana;
                                    $destetes_db[$destete->id]["inic"] = $destete->inic;
                                    $destetes_db[$destete->id]["cerdos_descartados"] = $destete->cerdos_descartados;
                                    $destetes_db[$destete->id]["cerdos_livianos"] = $destete->cerdos_livianos;
                                    $destetes_db[$destete->id]["muertes"] = $destete->muertes;
                                    $destetes_db[$destete->id]["cant_final_cerdos"] = $destete->cant_final_cerdos;
                                    $destetes_db[$destete->id]["meta_cerdos"] = $destete->meta_cerdos; 
                                    $destetes_db[$destete->id]["edad_inicial"] = $destete->edad_inicial; 
                                    $destetes_db[$destete->id]["edad_inicial_total"] = $destete->edad_inicial_total; 
                                    $destetes_db[$destete->id]["dias"] = $destete->dias;  
                                    $destetes_db[$destete->id]["dias_permanencia"] = $destete->dias_permanencia; 
                                    $destetes_db[$destete->id]["edad_final"] = $destete->edad_final; 
                                    $destetes_db[$destete->id]["edad_final_total"] = $destete->edad_final_total; 
                                    $destetes_db[$destete->id]["conf_edad_final"] = $destete->conf_edad_final; 
                                    $destetes_db[$destete->id]["por_mortalidad"] = $destete->por_mortalidad; 
                                    $destetes_db[$destete->id]["por_descartes"] = $destete->por_descartes; 
                                    $destetes_db[$destete->id]["por_livianos"] = $destete->por_livianos; 
                                    $destetes_db[$destete->id]["peso_total_ingresado"] = $destete->peso_total_ingresado; 
                                    $destetes_db[$destete->id]["peso_promedio_ingresado"] = $destete->peso_promedio_ingresado; 
                                    $destetes_db[$destete->id]["peso_total_vendido"] = $destete->peso_total_vendido; 
                                    $destetes_db[$destete->id]["peso_promedio_vendido"] = $destete->peso_promedio_vendido;
                                    $destetes_db[$destete->id]["consumo_lote"] = $destete->consumo_lote; 
                                    $destetes_db[$destete->id]["consumo_promedio_lote"] = $destete->consumo_promedio_lote; 
                                    $destetes_db[$destete->id]["consumo_promedio_lote_dias"] = $destete->consumo_promedio_lote_dias;
                                               
                                }   
                            }   
                        }
                    }
                    $destetes_db = json_decode(json_encode($destetes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($destetes_db)
                    {
                        foreach ($destetes_db as $destete_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                            $row = [];
                            $row[0] = $destete_db["lote"];
                            $row[1] = $destete_db["granja"];
                            $row[2] = $destete_db["fecha_ingreso_lote"];
                            $row[3] = $destete_db["fecha_salida_lote"];
                            $row[4] = $destete_db["año"];
                            $row[5] = $destete_db["mes"];
                            $row[6] = $destete_db["semana"];
                            $row[7] = $destete_db["inic"];
                            $row[8] = $destete_db["cerdos_descartados"];
                            $row[9] = $destete_db["cerdos_livianos"];
                            $row[10] = $destete_db["muertes"];
                            $row[11] = $destete_db["cant_final_cerdos"];
                            $row[12] = $destete_db["meta_cerdos"];
                            $row[13] = $destete_db["edad_inicial"];
                            $row[14] = $destete_db["edad_inicial_total"];
                            $row[15] = $destete_db["dias"];
                            $row[16] = $destete_db["dias_permanencia"];
                            $row[17] = $destete_db["edad_final"];
                            $row[18] = $destete_db["edad_final_total"];
                            $row[19] = $destete_db["conf_edad_final"];
                            $row[20] = $destete_db["por_mortalidad"];
                            $row[21] = $destete_db["por_descartes"];
                            $row[22] = $destete_db["por_livianos"];
                            $row[23] = $destete_db["peso_total_ingresado"];
                            $row[24] = $destete_db["peso_promedio_ingresado"];
                            $row[25] = $destete_db["peso_total_vendido"];
                            $row[26] = $destete_db["peso_promedio_vendido"];
                            $row[27] = $destete_db["consumo_lote"];
                            $row[28] = $destete_db["consumo_promedio_lote"];
                            $row[29] = $destete_db["consumo_promedio_lote_dias"];
                            $sheet->appendRow($row);
                        }
                    });
                })->export('csv');
            }

        }
        elseif($lote != '0')
        {
            if ($fecha_inicial != '+' && $fecha_final != '+') 
            {
                Excel::create('Filtro de Destete Finalización por Lote y Fecha del dia '.$date,function($excel) use($lote,$fecha_inicial,$fecha_final)
                {
                    $granjas = Granja::all();
                    $destetes = DesteteFinalizacion::all();
                    $g_as = AsociacionGranja::all();
                    $fechas = DesteteFinalizacion::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                    if (Auth::user()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote)
                            {
                                foreach ($g_as as $g) 
                                {
                                    if ($g->user_id == Auth::User()->id) 
                                    {
                                        if ($fecha->granja_id == $g->granja_id) 
                                        {
                                            foreach ($granjas as $granja) 
                                            {
                                                if ($fecha->granja_id == $granja->id) 
                                                {
                                                    $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                                    $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                    $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                                    $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                                    $destetes_db[$fecha->id]["año"] = $fecha->año;
                                                    $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                                    $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                                    $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                                    $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                                    $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                                    $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                                    $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                                    $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                                    $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                                    $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                                    $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                                    $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                                    $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                                    $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                                    $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                                    $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                                    $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                                    $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                                    $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                                    $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                                    $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                                    $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                                    $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                                    $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                                    $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if ($fecha->lote == $lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                        $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                        $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                        $destetes_db[$fecha->id]["año"] = $fecha->año;
                                        $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                        $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                        $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                        $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                        $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                        $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                        $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                        $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                        $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                        $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                        $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                        $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                        $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                        $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                        $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                        $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                        $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                        $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                        $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                        $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                        $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                        $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                        $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                        $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                        $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                    }
                                }
                            }
                        }

                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
            else
            {
                Excel::create('Filtro de Destete Finalizacion por Lote del dia '.$date, function($excel) use($lote)
                {
                    $granjas = Granja::all();
                    $destetes = DesteteFinalizacion::all();
                    $g_as = AsociacionGranja::all();

                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($destetes as $destete) 
                        {
                            if ($destete->lote == $lote) 
                            {
                                foreach ($g_as as $g) 
                                {
                                    if ($g->user_id == Auth::User()->id) 
                                    {
                                        if ($destete->granja_id == $g->granja_id) 
                                        {
                                            foreach ($granjas as $granja)
                                            {
                                                if ($destete->granja_id == $granja->id) 
                                                {
                                                    $destetes_db[$destete->id]["lote"] = $destete->lote;
                                                    $destetes_db[$destete->id]["granja"] = $granja->nombre_granja;
                                                    $destetes_db[$destete->id]["fecha_ingreso_lote"] = $destete->fecha_ingreso_lote;
                                                    $destetes_db[$destete->id]["fecha_salida_lote"] = $destete->fecha_salida_lote;
                                                    $destetes_db[$destete->id]["año"] = $destete->año;
                                                    $destetes_db[$destete->id]["mes"] = $destete->mes;
                                                    $destetes_db[$destete->id]["semana"] = $destete->semana;
                                                    $destetes_db[$destete->id]["inic"] = $destete->inic;
                                                    $destetes_db[$destete->id]["cerdos_descartados"] = $destete->cerdos_descartados;
                                                    $destetes_db[$destete->id]["cerdos_livianos"] = $destete->cerdos_livianos;
                                                    $destetes_db[$destete->id]["muertes"] = $destete->muertes;
                                                    $destetes_db[$destete->id]["cant_final_cerdos"] = $destete->cant_final_cerdos;
                                                    $destetes_db[$destete->id]["meta_cerdos"] = $destete->meta_cerdos; 
                                                    $destetes_db[$destete->id]["edad_inicial"] = $destete->edad_inicial; 
                                                    $destetes_db[$destete->id]["edad_inicial_total"] = $destete->edad_inicial_total; 
                                                    $destetes_db[$destete->id]["dias"] = $destete->dias;  
                                                    $destetes_db[$destete->id]["dias_permanencia"] = $destete->dias_permanencia; 
                                                    $destetes_db[$destete->id]["edad_final"] = $destete->edad_final; 
                                                    $destetes_db[$destete->id]["edad_final_total"] = $destete->edad_final_total; 
                                                    $destetes_db[$destete->id]["conf_edad_final"] = $destete->conf_edad_final; 
                                                    $destetes_db[$destete->id]["por_mortalidad"] = $destete->por_mortalidad; 
                                                    $destetes_db[$destete->id]["por_descartes"] = $destete->por_descartes; 
                                                    $destetes_db[$destete->id]["por_livianos"] = $destete->por_livianos; 
                                                    $destetes_db[$destete->id]["peso_total_ingresado"] = $destete->peso_total_ingresado; 
                                                    $destetes_db[$destete->id]["peso_promedio_ingresado"] = $destete->peso_promedio_ingresado; 
                                                    $destetes_db[$destete->id]["peso_total_vendido"] = $destete->peso_total_vendido; 
                                                    $destetes_db[$destete->id]["peso_promedio_vendido"] = $destete->peso_promedio_vendido;
                                                    $destetes_db[$destete->id]["consumo_lote"] = $destete->consumo_lote; 
                                                    $destetes_db[$destete->id]["consumo_promedio_lote"] = $destete->consumo_promedio_lote; 
                                                    $destetes_db[$destete->id]["consumo_promedio_lote"] = $destete->consumo_promedio_lote; 
                                                    $destetes_db[$destete->id]["consumo_promedio_lote_dias"] = $destete->consumo_promedio_lote_dias; 
                                                }   
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                    else
                    {
                        foreach ($destetes as $destete) 
                        {
                            if ($destete->lote == $lote) 
                            {
                                foreach ($granjas as $granja)
                                {
                                    if ($destete->granja_id == $granja->id) 
                                    {
                                        $destetes_db[$destete->id]["lote"] = $destete->lote;
                                        $destetes_db[$destete->id]["granja"] = $granja->nombre_granja;
                                        $destetes_db[$destete->id]["fecha_ingreso_lote"] = $destete->fecha_ingreso_lote;
                                        $destetes_db[$destete->id]["fecha_salida_lote"] = $destete->fecha_salida_lote;
                                        $destetes_db[$destete->id]["año"] = $destete->año;
                                        $destetes_db[$destete->id]["mes"] = $destete->mes;
                                        $destetes_db[$destete->id]["semana"] = $destete->semana;
                                        $destetes_db[$destete->id]["inic"] = $destete->inic;
                                        $destetes_db[$destete->id]["cerdos_descartados"] = $destete->cerdos_descartados;
                                        $destetes_db[$destete->id]["cerdos_livianos"] = $destete->cerdos_livianos;
                                        $destetes_db[$destete->id]["muertes"] = $destete->muertes;
                                        $destetes_db[$destete->id]["cant_final_cerdos"] = $destete->cant_final_cerdos;
                                        $destetes_db[$destete->id]["meta_cerdos"] = $destete->meta_cerdos; 
                                        $destetes_db[$destete->id]["edad_inicial"] = $destete->edad_inicial; 
                                        $destetes_db[$destete->id]["edad_inicial_total"] = $destete->edad_inicial_total; 
                                        $destetes_db[$destete->id]["dias"] = $destete->dias;  
                                        $destetes_db[$destete->id]["dias_permanencia"] = $destete->dias_permanencia; 
                                        $destetes_db[$destete->id]["edad_final"] = $destete->edad_final; 
                                        $destetes_db[$destete->id]["edad_final_total"] = $destete->edad_final_total; 
                                        $destetes_db[$destete->id]["conf_edad_final"] = $destete->conf_edad_final; 
                                        $destetes_db[$destete->id]["por_mortalidad"] = $destete->por_mortalidad; 
                                        $destetes_db[$destete->id]["por_descartes"] = $destete->por_descartes; 
                                        $destetes_db[$destete->id]["por_livianos"] = $destete->por_livianos; 
                                        $destetes_db[$destete->id]["peso_total_ingresado"] = $destete->peso_total_ingresado; 
                                        $destetes_db[$destete->id]["peso_promedio_ingresado"] = $destete->peso_promedio_ingresado; 
                                        $destetes_db[$destete->id]["peso_total_vendido"] = $destete->peso_total_vendido; 
                                        $destetes_db[$destete->id]["peso_promedio_vendido"] = $destete->peso_promedio_vendido;
                                        $destetes_db[$destete->id]["consumo_lote"] = $destete->consumo_lote; 
                                        $destetes_db[$destete->id]["consumo_promedio_lote"] = $destete->consumo_promedio_lote; 
                                        $destetes_db[$destete->id]["consumo_promedio_lote"] = $destete->consumo_promedio_lote; 
                                        $destetes_db[$destete->id]["consumo_promedio_lote_dias"] = $destete->consumo_promedio_lote_dias; 
                                    }   
                                }
                            }
                        }
                        $destetes_db = json_decode(json_encode($destetes_db), true);
                        $excel->sheet('Filtro', function($sheet) use($destetes_db)
                        {
                            foreach ($destetes_db as $destete_db) 
                            {
                                $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                                $row = [];
                                $row[0] = $destete_db["lote"];
                                $row[1] = $destete_db["granja"];
                                $row[2] = $destete_db["fecha_ingreso_lote"];
                                $row[3] = $destete_db["fecha_salida_lote"];
                                $row[4] = $destete_db["año"];
                                $row[5] = $destete_db["mes"];
                                $row[6] = $destete_db["semana"];
                                $row[7] = $destete_db["inic"];
                                $row[8] = $destete_db["cerdos_descartados"];
                                $row[9] = $destete_db["cerdos_livianos"];
                                $row[10] = $destete_db["muertes"];
                                $row[11] = $destete_db["cant_final_cerdos"];
                                $row[12] = $destete_db["meta_cerdos"];
                                $row[13] = $destete_db["edad_inicial"];
                                $row[14] = $destete_db["edad_inicial_total"];
                                $row[15] = $destete_db["dias"];
                                $row[16] = $destete_db["dias_permanencia"];
                                $row[17] = $destete_db["edad_final"];
                                $row[18] = $destete_db["edad_final_total"];
                                $row[19] = $destete_db["conf_edad_final"];
                                $row[20] = $destete_db["por_mortalidad"];
                                $row[21] = $destete_db["por_descartes"];
                                $row[22] = $destete_db["por_livianos"];
                                $row[23] = $destete_db["peso_total_ingresado"];
                                $row[24] = $destete_db["peso_promedio_ingresado"];
                                $row[25] = $destete_db["peso_total_vendido"];
                                $row[26] = $destete_db["peso_promedio_vendido"];
                                $row[27] = $destete_db["consumo_lote"];
                                $row[28] = $destete_db["consumo_promedio_lote"];
                                $row[29] = $destete_db["consumo_promedio_lote_dias"];
                                $sheet->appendRow($row);
                            }
                        });
                    }
                })->export('csv');
            }
        }
        elseif ($fecha_inicial != '+' && $fecha_final != '+') 
        {
            Excel::create('Filtro de Destete Finalización Por Fecha del dia '.$date,function ($excel) use($fecha_inicial,$fecha_final)
            {
                $granjas = Granja::all();
                $destetes = DesteteFinalizacion::all();
                $g_as = AsociacionGranja::all();
                $fechas = DesteteFinalizacion::whereBetween('fecha_salida_lote',[$fecha_inicial, $fecha_final] )->get();

                if (Auth::User()->rol_id != 7) 
                {
                    foreach ($g_as as $g) 
                    {
                        if ($g->user_id == Auth::User()->id) 
                        {
                            foreach ($fechas as $fecha) 
                            {
                                if ($g->granja_id == $fecha->granja_id) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($granja->id == $fecha->granja_id) 
                                        {
                                            $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                            $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                            $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                            $destetes_db[$fecha->id]["año"] = $fecha->año;
                                            $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                            $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                            $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                            $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                            $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                            $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                            $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                            $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                            $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                            $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                            $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                            $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                            $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                            $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                            $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                            $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                            $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                            $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                            $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                            $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                            $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                            $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                            $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                            $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                            $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $destetes_db = json_decode(json_encode($destetes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($destetes_db)
                    {
                        foreach ($destetes_db as $destete_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                            $row = [];
                            $row[0] = $destete_db["lote"];
                            $row[1] = $destete_db["granja"];
                            $row[2] = $destete_db["fecha_ingreso_lote"];
                            $row[3] = $destete_db["fecha_salida_lote"];
                            $row[4] = $destete_db["año"];
                            $row[5] = $destete_db["mes"];
                            $row[6] = $destete_db["semana"];
                            $row[7] = $destete_db["inic"];
                            $row[8] = $destete_db["cerdos_descartados"];
                            $row[9] = $destete_db["cerdos_livianos"];
                            $row[10] = $destete_db["muertes"];
                            $row[11] = $destete_db["cant_final_cerdos"];
                            $row[12] = $destete_db["meta_cerdos"];
                            $row[13] = $destete_db["edad_inicial"];
                            $row[14] = $destete_db["edad_inicial_total"];
                            $row[15] = $destete_db["dias"];
                            $row[16] = $destete_db["dias_permanencia"];
                            $row[17] = $destete_db["edad_final"];
                            $row[18] = $destete_db["edad_final_total"];
                            $row[19] = $destete_db["conf_edad_final"];
                            $row[20] = $destete_db["por_mortalidad"];
                            $row[21] = $destete_db["por_descartes"];
                            $row[22] = $destete_db["por_livianos"];
                            $row[23] = $destete_db["peso_total_ingresado"];
                            $row[24] = $destete_db["peso_promedio_ingresado"];
                            $row[25] = $destete_db["peso_total_vendido"];
                            $row[26] = $destete_db["peso_promedio_vendido"];
                            $row[27] = $destete_db["consumo_lote"];
                            $row[28] = $destete_db["consumo_promedio_lote"];
                            $row[29] = $destete_db["consumo_promedio_lote_dias"];
                            $sheet->appendRow($row);
                        }
                    });
                }
                else
                {
                    foreach ($fechas as $fecha) 
                    {
                        foreach ($granjas as $granja) 
                        {
                            if ($granja->id == $fecha->granja_id) 
                            {
                                $destetes_db[$fecha->id]["lote"] = $fecha->lote;
                                $destetes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                $destetes_db[$fecha->id]["fecha_ingreso_lote"] = $fecha->fecha_ingreso_lote;
                                $destetes_db[$fecha->id]["fecha_salida_lote"] = $fecha->fecha_salida_lote;
                                $destetes_db[$fecha->id]["año"] = $fecha->año;
                                $destetes_db[$fecha->id]["mes"] = $fecha->mes;
                                $destetes_db[$fecha->id]["semana"] = $fecha->semana;
                                $destetes_db[$fecha->id]["inic"] = $fecha->inic;
                                $destetes_db[$fecha->id]["cerdos_descartados"] = $fecha->cerdos_descartados;
                                $destetes_db[$fecha->id]["cerdos_livianos"] = $fecha->cerdos_livianos;
                                $destetes_db[$fecha->id]["muertes"] = $fecha->muertes;
                                $destetes_db[$fecha->id]["cant_final_cerdos"] = $fecha->cant_final_cerdos;
                                $destetes_db[$fecha->id]["meta_cerdos"] = $fecha->meta_cerdos; 
                                $destetes_db[$fecha->id]["edad_inicial"] = $fecha->edad_inicial; 
                                $destetes_db[$fecha->id]["edad_inicial_total"] = $fecha->edad_inicial_total; 
                                $destetes_db[$fecha->id]["dias"] = $fecha->dias;  
                                $destetes_db[$fecha->id]["dias_permanencia"] = $fecha->dias_permanencia; 
                                $destetes_db[$fecha->id]["edad_final"] = $fecha->edad_final; 
                                $destetes_db[$fecha->id]["edad_final_total"] = $fecha->edad_final_total; 
                                $destetes_db[$fecha->id]["conf_edad_final"] = $fecha->conf_edad_final; 
                                $destetes_db[$fecha->id]["por_mortalidad"] = $fecha->por_mortalidad; 
                                $destetes_db[$fecha->id]["por_descartes"] = $fecha->por_descartes; 
                                $destetes_db[$fecha->id]["por_livianos"] = $fecha->por_livianos; 
                                $destetes_db[$fecha->id]["peso_total_ingresado"] = $fecha->peso_total_ingresado; 
                                $destetes_db[$fecha->id]["peso_promedio_ingresado"] = $fecha->peso_promedio_ingresado; 
                                $destetes_db[$fecha->id]["peso_total_vendido"] = $fecha->peso_total_vendido; 
                                $destetes_db[$fecha->id]["peso_promedio_vendido"] = $fecha->peso_promedio_vendido;
                                $destetes_db[$fecha->id]["consumo_lote"] = $fecha->consumo_lote; 
                                $destetes_db[$fecha->id]["consumo_promedio_lote"] = $fecha->consumo_promedio_lote; 
                                $destetes_db[$fecha->id]["consumo_promedio_lote_dias"] = $fecha->consumo_promedio_lote_dias;
                            }
                        }
                    }
                    $destetes_db = json_decode(json_encode($destetes_db), true);
                    $excel->sheet('Filtro', function($sheet) use($destetes_db)
                    {
                        foreach ($destetes_db as $destete_db) 
                        {
                            $sheet->row(1, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Inic', 'Descartes', 'Livianos', 'Muertes', '#Final Cerdos', 'Meta', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', '% Mortalidad', '% Descartes', '% Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                            $row = [];
                            $row[0] = $destete_db["lote"];
                            $row[1] = $destete_db["granja"];
                            $row[2] = $destete_db["fecha_ingreso_lote"];
                            $row[3] = $destete_db["fecha_salida_lote"];
                            $row[4] = $destete_db["año"];
                            $row[5] = $destete_db["mes"];
                            $row[6] = $destete_db["semana"];
                            $row[7] = $destete_db["inic"];
                            $row[8] = $destete_db["cerdos_descartados"];
                            $row[9] = $destete_db["cerdos_livianos"];
                            $row[10] = $destete_db["muertes"];
                            $row[11] = $destete_db["cant_final_cerdos"];
                            $row[12] = $destete_db["meta_cerdos"];
                            $row[13] = $destete_db["edad_inicial"];
                            $row[14] = $destete_db["edad_inicial_total"];
                            $row[15] = $destete_db["dias"];
                            $row[16] = $destete_db["dias_permanencia"];
                            $row[17] = $destete_db["edad_final"];
                            $row[18] = $destete_db["edad_final_total"];
                            $row[19] = $destete_db["conf_edad_final"];
                            $row[20] = $destete_db["por_mortalidad"];
                            $row[21] = $destete_db["por_descartes"];
                            $row[22] = $destete_db["por_livianos"];
                            $row[23] = $destete_db["peso_total_ingresado"];
                            $row[24] = $destete_db["peso_promedio_ingresado"];
                            $row[25] = $destete_db["peso_total_vendido"];
                            $row[26] = $destete_db["peso_promedio_vendido"];
                            $row[27] = $destete_db["consumo_lote"];
                            $row[28] = $destete_db["consumo_promedio_lote"];
                            $row[29] = $destete_db["consumo_promedio_lote_dias"];
                            $sheet->appendRow($row);
                        }
                    });
                }
            })->export('csv');
        }
    }
    /**
    * permite descargar un archivo desde la vista filtro_destetos_semana.blade.php 
    * todos los registros que se enviaron por medio de parametros desde la vista
    *
    * @var Granja
    * @var DestetosSemana
    * @var AsociacionGranja
    * @param int $gr
    * @param int $lote
    * @return archivo.csv
    */

    public function filtroPorDestetosSemana($gr, $lote)
    {
        if($gr != 0 && $lote != '0')
        {
            Excel::create('Filtro de Lechones Destetados', function($excel) use($gr, $lote)
            {
                $granjas = Granja::all();
                $destetosS = DestetosSemana::all();
                $g_as = AsociacionGranja::all();

                foreach ($destetosS as $destetoS) 
                {
                    if ($destetoS->lote == $lote) 
                    {
                        foreach ($granjas as $granja)
                        {
                            if ($destetoS->granja_id == $granja->id) 
                            {
                                if ($granja->id == $gr) 
                                {
                                    $destetosS_db[$destetoS->id]["granja_cria_id"] = $destetoS->granja_cria_id;
                                    $destetosS_db[$destetoS->id]["lote"] = $granja->lote;
                                    $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                    $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                    $destetosS_db[$destetoS->id]["numero_destetos"] = $destetoS->numero_destetos;
                                    $destetosS_db[$destetoS->id]["mortalidad_precebo"] = $destetoS->mortalidad_precebo;
                                    $destetosS_db[$destetoS->id]["traslado_a_ceba"] = $destetoS->traslado_a_ceba;
                                    $destetosS_db[$destetoS->id]["cantidad_a_ceba"] = $destetoS->cantidad_a_ceba;
                                    $destetosS_db[$destetoS->id]["mortalidad_ceba"] = $destetoS->mortalidad_ceba;
                                    $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                    $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                    $destetosS_db[$destetoS->id]["disponibilidad_venta"] = $destetoS->disponibilidad_venta;
                                    $destetosS_db[$destetoS->id]["kilos_venta"] = $destetoS->kilos_venta; 
                                    $destetosS_db[$destetoS->id]["semana_1_fase_1"] = $destetoS->semana_1_fase_1; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_1_fase_1"] = $destetoS->consumo_semana_1_fase_1;   
                                    $destetosS_db[$destetoS->id]["semana_2_fase_1"] = $destetoS->semana_2_fase_1; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_2_fase_1"] = $destetoS->consumo_semana_2_fase_1; 
                                    $destetosS_db[$destetoS->id]["semana_1_fase_2"] = $destetoS->semana_1_fase_2; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_1_fase_2"] = $destetoS->consumo_semana_1_fase_2; 
                                    $destetosS_db[$destetoS->id]["semana_2_fase_2"] = $destetoS->semana_2_fase_2; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_2_fase_2"] = $destetoS->consumo_semana_2_fase_2; 
                                    $destetosS_db[$destetoS->id]["semana_1_fase_3"] = $destetoS->semana_1_fase_3; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_1_fase_3"] = $destetoS->consumo_semana_1_fase_3; 
                                    $destetosS_db[$destetoS->id]["semana_2_fase_3"] = $destetoS->semana_2_fase_3; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_2_fase_3"] = $destetoS->consumo_semana_2_fase_3; 
                                    $destetosS_db[$destetoS->id]["semana_3_fase_3"] = $destetoS->semana_3_fase_3;
                                    $destetosS_db[$destetoS->id]["consumo_lote"] = $destetoS->consumo_lote; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_3_fase_3"] = $destetoS->consumo_semana_3_fase_3; 
                                    $destetosS_db[$destetoS->id]["semana_1_iniciacion"] = $destetoS->semana_1_iniciacion;
                                    $destetosS_db[$destetoS->id]["consumo_semana_1_iniciacion"] = $destetoS->consumo_semana_1_iniciacion;
                                    $destetosS_db[$destetoS->id]["semana_2_iniciacion"] = $destetoS->semana_2_iniciacion;
                                    $destetosS_db[$destetoS->id]["consumo_semana_2_iniciacion"] = $destetoS->consumo_semana_2_iniciacion;
                                    $destetosS_db[$destetoS->id]["semana_1_levante"] = $destetoS->semana_1_levante;
                                    $destetosS_db[$destetoS->id]["consumo_semana_1_levante"] = $destetoS->consumo_semana_1_levante;
                                    $destetosS_db[$destetoS->id]["semana_2_levante"] = $destetoS->semana_2_levante;
                                    $destetosS_db[$destetoS->id]["consumo_semana_2_levante"] = $destetoS->consumo_semana_2_levante;  
                                    $destetosS_db[$destetoS->id]["semana_3_levante"] = $destetoS->semana_3_levante;
                                    $destetosS_db[$destetoS->id]["consumo_semana_3_levante"] = $destetoS->consumo_semana_3_levante;
                                    $destetosS_db[$destetoS->id]["semana_4_levante"] = $destetoS->semana_4_levante;
                                    $destetosS_db[$destetoS->id]["consumo_semana_4_levante"] = $destetoS->consumo_semana_4_levante;
                                    $destetosS_db[$destetoS->id]["semana_1_engorde_1"] = $destetoS->semana_1_engorde_1; 
                                    $destetosS_db[$destetoS->id]["consumo_semana_1_engorde_1"] = $destetoS->consumo_semana_1_engorde_1;
                                    $destetosS_db[$destetoS->id]["semana_2_engorde_1"] = $destetoS->semana_2_engorde_1;
                                    $destetosS_db[$destetoS->id]["semana_1_engorde_1"] = $destetoS->semana_1_engorde_1;
                                    $destetosS_db[$destetoS->id]["consumo_semana_2_engorde_1"] = $destetoS->consumo_semana_2_engorde_1;
                                    $destetosS_db[$destetoS->id]["semana_1_engorde_2"] = $destetoS->semana_1_engorde_2;
                                    $destetosS_db[$destetoS->id]["consumo_semana_1_engorde_2"] = $destetoS->consumo_semana_1_engorde_2;
                                    $destetosS_db[$destetoS->id]["semana_2_engorde_2"] = $destetoS->semana_2_engorde_2;
                                    $destetosS_db[$destetoS->id]["consumo_semana_2_engorde_2"] = $destetoS->consumo_semana_2_engorde_2;
                                    $destetosS_db[$destetoS->id]["semana_3_engorde_2"] = $destetoS->semana_3_engorde_2;
                                    $destetosS_db[$destetoS->id]["consumo_semana_3_engorde_2"] = $destetoS->consumo_semana_3_engorde_2;
                                    $destetosS_db[$destetoS->id]["semana_4_engorde_2"] = $destetoS->semana_4_engorde_2;
                                    $destetosS_db[$destetoS->id]["consumo_semana_4_engorde_2"] = $destetoS->consumo_semana_4_engorde_2;
                                }   
                            }   
                        }
                    }
                }
                $destetosS_db = json_decode(json_encode($destetosS_db), true);
                $excel->sheet('Filtro', function($sheet) use($destetosS_db)
                {
                    foreach ($destetosS_db as $destetoS_db) 
                    {
                        $sheet->row(1, ['Granja ', 'lote', 'Anno Destete', 'Semana Destete', ' #Destetos', ' Mortalidad %Precebo', 'Traslado Ceba','Cantidad Ceba', 'Mortalidad %Ceba', 'Semana Venta', 'Anno Venta', 'Disponibilidad Venta', ' Kilos Venta', 'Semana1 Fase1', 'Consumo Semana1 Fase1', 'Semana2 Fase1', 'Consumo Semana2 Fase1', 'Semana1 Fase2', 'Consumo Semana1 Fase2', 'Semana2 Fase2', 'Consumo Semana2 Fase2', 'Semana1 Fase3', 'Consumo Semana1 Fase3', 'Semana2 Fase3', 'Consumo Semana2 Fase3', 'Semana3 Fase3', 'Consumo Semana3 Fase3', 'Semana1 Iniciacion', 'Consumo Semana1 Iniciacion','Semana2 Iniciacion', 'Consumo Semana2 Iniciacion', 'Semana1 Levante', 'Consumo Semana1 Levante', 'Semana2 Levante', 'Consumo Semana2 Levante', 'Semana3 Levante', 'Consumo Semana3 Levante', 'Semana4 Levante', 'Consumo Semana4 Levante', 'Semana1 Engorde1', 'Consumo Semana1 Engorde1', 'Semana2 Engorde1', 'Consumo Semana2 Engorde1', 'Semana1 Engorde2', 'Consumo Semana1 Engorde2', 'Semana2 Engorde2', 'Consumo Semana2 Engorde2', 'Semana3 Engorde2', 'Consumo Semana3 Engorde2', 'Semana4 Engorde2', 'Consumo Semana4 Engorde2']);
                        $row = [];
                        $row[0] = $destetoS_db["lote"];
                        $row[1] = $destetoS_db["granja"];
                        $row[2] = $destetoS_db["fecha_ingreso_lote"];
                        $row[3] = $destetoS_db["fecha_salida_lote"];
                        $row[4] = $destetoS_db["año"];
                        $row[5] = $destetoS_db["mes"];
                        $row[6] = $destetoS_db["semana"];
                        $row[7] = $destetoS_db["inic"];
                        $row[8] = $destetoS_db["cerdos_descartados"];
                        $row[9] = $destetoS_db["cerdos_livianos"];
                        $row[10] = $destetoS_db["muertes"];
                        $row[11] = $destetoS_db["cant_final_cerdos"];
                        $row[12] = $destetoS_db["meta_cerdos"];
                        $row[13] = $destetoS_db["edad_inicial"];
                        $row[14] = $destetoS_db["edad_inicial_total"];
                        $row[15] = $destetoS_db["dias"];
                        $row[16] = $destetoS_db["dias_permanencia"];
                        $row[17] = $destetoS_db["edad_final"];
                        $row[18] = $destetoS_db["edad_final_total"];
                        $row[19] = $destetoS_db["conf_edad_final"];
                        $row[20] = $destetoS_db["por_mortalidad"];
                        $row[21] = $destetoS_db["por_descartes"];
                        $row[22] = $destetoS_db["por_livianos"];
                        $row[23] = $destetoS_db["peso_total_ingresado"];
                        $row[24] = $destetoS_db["peso_promedio_ingresado"];
                        $row[25] = $destetoS_db["peso_total_vendido"];
                        $row[26] = $destetoS_db["peso_promedio_vendido"];
                        $row[27] = $destetoS_db["consumo_lote"];
                        $row[28] = $destetoS_db["consumo_promedio_lote"];
                        $row[29] = $destetoS_db["consumo_promedio_lote_dias"];
                        $sheet->appendRow($row);
                    }
                });
            })->export('csv');
        }
        elseif($gr != '0')
        {
            Excel::create('Filtro de Lechones Destetados', function($excel) use($gr, $lote)
            {
                $granjas = Granja::all();
                $destetosS = DestetosSemana::all();
                $g_as = AsociacionGranja::all();

                foreach ($destetosS as $destetoS) 
                {
                    foreach ($granjas as $granja)
                    {
                        if ($destetoS->granja_cria_id == $granja->id) 
                        {
                            if ($granja->id == $gr) 
                            {
                                $destetosS_db[$destetoS->id]["granja_cria_id"] = $granja->nombre_granja;
                                $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                $destetosS_db[$destetoS->id]["numero_destetos"] = $destetoS->numero_destetos;
                                $destetosS_db[$destetoS->id]["mortalidad_precebo"] = $destetoS->mortalidad_precebo;
                                $destetosS_db[$destetoS->id]["traslado_a_ceba"] = $destetoS->traslado_a_ceba;
                                $destetosS_db[$destetoS->id]["cantidad_a_ceba"] = $destetoS->cantidad_a_ceba;
                                $destetosS_db[$destetoS->id]["mortalidad_ceba"] = $destetoS->mortalidad_ceba;
                                $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                $destetosS_db[$destetoS->id]["disponibilidad_venta"] = $destetoS->disponibilidad_venta;
                                $destetosS_db[$destetoS->id]["kilos_venta"] = $destetoS->kilos_venta; 
                                $destetosS_db[$destetoS->id]["semana_1_fase_1"] = $destetoS->semana_1_fase_1; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_fase_1"] = $destetoS->consumo_semana_1_fase_1;   
                                $destetosS_db[$destetoS->id]["semana_2_fase_1"] = $destetoS->semana_2_fase_1; 
                                $destetosS_db[$destetoS->id]["consumo_semana_2_fase_1"] = $destetoS->consumo_semana_2_fase_1; 
                                $destetosS_db[$destetoS->id]["semana_1_fase_2"] = $destetoS->semana_1_fase_2; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_fase_2"] = $destetoS->consumo_semana_1_fase_2; 
                                $destetosS_db[$destetoS->id]["semana_2_fase_2"] = $destetoS->semana_2_fase_2; 
                                $destetosS_db[$destetoS->id]["consumo_semana_2_fase_2"] = $destetoS->consumo_semana_2_fase_2; 
                                $destetosS_db[$destetoS->id]["semana_1_fase_3"] = $destetoS->semana_1_fase_3; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_fase_3"] = $destetoS->consumo_semana_1_fase_3; 
                                $destetosS_db[$destetoS->id]["semana_2_fase_3"] = $destetoS->semana_2_fase_3; 
                                $destetosS_db[$destetoS->id]["consumo_semana_2_fase_3"] = $destetoS->consumo_semana_2_fase_3; 
                                $destetosS_db[$destetoS->id]["semana_3_fase_3"] = $destetoS->semana_3_fase_3;
                                $destetosS_db[$destetoS->id]["consumo_lote"] = $destetoS->consumo_lote; 
                                $destetosS_db[$destetoS->id]["consumo_semana_3_fase_3"] = $destetoS->consumo_semana_3_fase_3; 
                                $destetosS_db[$destetoS->id]["semana_1_iniciacion"] = $destetoS->semana_1_iniciacion;
                                $destetosS_db[$destetoS->id]["consumo_semana_1_iniciacion"] = $destetoS->consumo_semana_1_iniciacion;
                                $destetosS_db[$destetoS->id]["semana_2_iniciacion"] = $destetoS->semana_2_iniciacion;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_iniciacion"] = $destetoS->consumo_semana_2_iniciacion;
                                $destetosS_db[$destetoS->id]["semana_1_levante"] = $destetoS->semana_1_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_1_levante"] = $destetoS->consumo_semana_1_levante;
                                $destetosS_db[$destetoS->id]["semana_2_levante"] = $destetoS->semana_2_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_levante"] = $destetoS->consumo_semana_2_levante;  
                                $destetosS_db[$destetoS->id]["semana_3_levante"] = $destetoS->semana_3_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_3_levante"] = $destetoS->consumo_semana_3_levante;
                                $destetosS_db[$destetoS->id]["semana_4_levante"] = $destetoS->semana_4_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_4_levante"] = $destetoS->consumo_semana_4_levante;
                                $destetosS_db[$destetoS->id]["semana_1_engorde_1"] = $destetoS->semana_1_engorde_1; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_engorde_1"] = $destetoS->consumo_semana_1_engorde_1;
                                $destetosS_db[$destetoS->id]["semana_2_engorde_1"] = $destetoS->semana_2_engorde_1;
                                $destetosS_db[$destetoS->id]["semana_1_engorde_1"] = $destetoS->semana_1_engorde_1;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_engorde_1"] = $destetoS->consumo_semana_2_engorde_1;
                                $destetosS_db[$destetoS->id]["semana_1_engorde_2"] = $destetoS->semana_1_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_1_engorde_2"] = $destetoS->consumo_semana_1_engorde_2;
                                $destetosS_db[$destetoS->id]["semana_2_engorde_2"] = $destetoS->semana_2_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_engorde_2"] = $destetoS->consumo_semana_2_engorde_2;
                                $destetosS_db[$destetoS->id]["semana_3_engorde_2"] = $destetoS->semana_3_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_3_engorde_2"] = $destetoS->consumo_semana_3_engorde_2;
                                $destetosS_db[$destetoS->id]["semana_4_engorde_2"] = $destetoS->semana_4_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_4_engorde_2"] = $destetoS->consumo_semana_4_engorde_2;              
                            }   
                        }   
                    }
                }
                $destetosS_db = json_decode(json_encode($destetosS_db), true);
                $excel->sheet('Filtro', function($sheet) use($destetosS_db)
                {
                    foreach ($destetosS_db as $destetoS_db) 
                    {
                        $sheet->row(1, ['Granja ', 'lote', 'Anno Destete', 'Semana Destete', ' #Destetos', ' Mortalidad %Precebo', 'Traslado Ceba','Cantidad Ceba', 'Mortalidad %Ceba', 'Semana Venta', 'Anno Venta', 'Disponibilidad Venta', ' Kilos Venta', 'Semana1 Fase1', 'Consumo Semana1 Fase1', 'Semana2 Fase1', 'Consumo Semana2 Fase1', 'Semana1 Fase2', 'Consumo Semana1 Fase2', 'Semana2 Fase2', 'Consumo Semana2 Fase2', 'Semana1 Fase3', 'Consumo Semana1 Fase3', 'Semana2 Fase3', 'Consumo Semana2 Fase3', 'Semana3 Fase3', 'Consumo Semana3 Fase3', 'Semana1 Iniciacion', 'Consumo Semana1 Iniciacion','Semana2 Iniciacion', 'Consumo Semana2 Iniciacion', 'Semana1 Levante', 'Consumo Semana1 Levante', 'Semana2 Levante', 'Consumo Semana2 Levante', 'Semana3 Levante', 'Consumo Semana3 Levante', 'Semana4 Levante', 'Consumo Semana4 Levante', 'Semana1 Engorde1', 'Consumo Semana1 Engorde1', 'Semana2 Engorde1', 'Consumo Semana2 Engorde1', 'Semana1 Engorde2', 'Consumo Semana1 Engorde2', 'Semana2 Engorde2', 'Consumo Semana2 Engorde2', 'Semana3 Engorde2', 'Consumo Semana3 Engorde2', 'Semana4 Engorde2', 'Consumo Semana4 Engorde2']);
                        $row = [];
                        $row[0] = $destetoS_db["granja_cria_id"];
                        $row[1] = $destetoS_db["lote"];
                        $row[2] = $destetoS_db["año_destete"];
                        $row[3] = $destetoS_db["semana_destete"];
                        $row[4] = $destetoS_db["numero_destetos"];
                        $row[5] = $destetoS_db["mortalidad_precebo"];
                        $row[6] = $destetoS_db["traslado_a_ceba"];
                        $row[7] = $destetoS_db["cantidad_a_ceba"];
                        $row[8] = $destetoS_db["mortalidad_ceba"];
                        $row[9] = $destetoS_db["semana_venta"];
                        $row[10] = $destetoS_db["año_venta"];
                        $row[11] = $destetoS_db["disponibilidad_venta"];
                        $row[12] = $destetoS_db["kilos_venta"];
                        $row[13] = $destetoS_db["semana_1_fase_1"];
                        $row[14] = $destetoS_db["consumo_semana_1_fase_1"];
                        $row[15] = $destetoS_db["semana_2_fase_1"];
                        $row[16] = $destetoS_db["consumo_semana_2_fase_1"];
                        $row[17] = $destetoS_db["semana_1_fase_2"];
                        $row[18] = $destetoS_db["consumo_semana_1_fase_2"];
                        $row[19] = $destetoS_db["semana_2_fase_2"];
                        $row[20] = $destetoS_db["consumo_semana_2_fase_2"];
                        $row[21] = $destetoS_db["semana_1_fase_3"];
                        $row[22] = $destetoS_db["consumo_semana_1_fase_3"];
                        $row[23] = $destetoS_db["semana_2_fase_3"];
                        $row[24] = $destetoS_db["consumo_semana_2_fase_3"];
                        $row[25] = $destetoS_db["semana_3_fase_3"];
                        $row[26] = $destetoS_db["consumo_semana_3_fase_3"];
                        $row[27] = $destetoS_db["semana_1_iniciacion"];
                        $row[28] = $destetoS_db["consumo_semana_1_iniciacion"];
                        $row[29] = $destetoS_db["semana_2_iniciacion"];
                        $row[30] = $destetoS_db["consumo_semana_2_iniciacion"];
                        $row[31] = $destetoS_db["semana_1_levante"];
                        $row[32] = $destetoS_db["consumo_semana_1_levante"];
                        $row[33] = $destetoS_db["semana_2_levante"];
                        $row[34] = $destetoS_db["consumo_semana_2_levante"];
                        $row[35] = $destetoS_db["semana_3_levante"];
                        $row[36] = $destetoS_db["consumo_semana_3_levante"];
                        $row[37] = $destetoS_db["semana_4_levante"];
                        $row[38] = $destetoS_db["consumo_semana_4_levante"];
                        $row[39] = $destetoS_db["semana_1_engorde_1"];
                        $row[40] = $destetoS_db["consumo_semana_1_engorde_1"];
                        $row[41] = $destetoS_db["semana_2_engorde_1"];
                        $row[42] = $destetoS_db["consumo_semana_2_engorde_1"];
                        $row[43] = $destetoS_db["semana_1_engorde_2"];
                        $row[44] = $destetoS_db["consumo_semana_1_engorde_2"];
                        $row[45] = $destetoS_db["semana_2_engorde_2"];
                        $row[46] = $destetoS_db["consumo_semana_2_engorde_2"];
                        $row[47] = $destetoS_db["semana_3_engorde_2"];
                        $row[48] = $destetoS_db["consumo_semana_3_engorde_2"];
                        $row[49] = $destetoS_db["semana_4_engorde_2"];
                        $row[50] = $destetoS_db["consumo_semana_4_engorde_2"];
                        $sheet->appendRow($row);
                    }
                });
            })->export('csv');
        }
    
        elseif($lote != '0')
        {
            Excel::create('Filtro de Lechones Destetados', function($excel) use($gr, $lote)
            {
                $granjas = Granja::all();
                $destetosS = DestetosSemana::all();
                $g_as = AsociacionGranja::all();

                foreach ($destetosS as $destetoS) 
                {
                    if ($destetoS->lote == $lote) 
                    {
                        foreach ($granjas as $granja)
                        {
                            if ($destetoS->granja_cria_id == $granja->id) 
                            {
                                $destetosS_db[$destetoS->id]["granja_cria_id"] = $granja->nombre_granja;
                                $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                $destetosS_db[$destetoS->id]["numero_destetos"] = $destetoS->numero_destetos;
                                $destetosS_db[$destetoS->id]["mortalidad_precebo"] = $destetoS->mortalidad_precebo;
                                $destetosS_db[$destetoS->id]["traslado_a_ceba"] = $destetoS->traslado_a_ceba;
                                $destetosS_db[$destetoS->id]["cantidad_a_ceba"] = $destetoS->cantidad_a_ceba;
                                $destetosS_db[$destetoS->id]["mortalidad_ceba"] = $destetoS->mortalidad_ceba;
                                $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                $destetosS_db[$destetoS->id]["disponibilidad_venta"] = $destetoS->disponibilidad_venta;
                                $destetosS_db[$destetoS->id]["kilos_venta"] = $destetoS->kilos_venta; 
                                $destetosS_db[$destetoS->id]["semana_1_fase_1"] = $destetoS->semana_1_fase_1; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_fase_1"] = $destetoS->consumo_semana_1_fase_1;   
                                $destetosS_db[$destetoS->id]["semana_2_fase_1"] = $destetoS->semana_2_fase_1; 
                                $destetosS_db[$destetoS->id]["consumo_semana_2_fase_1"] = $destetoS->consumo_semana_2_fase_1; 
                                $destetosS_db[$destetoS->id]["semana_1_fase_2"] = $destetoS->semana_1_fase_2; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_fase_2"] = $destetoS->consumo_semana_1_fase_2; 
                                $destetosS_db[$destetoS->id]["semana_2_fase_2"] = $destetoS->semana_2_fase_2; 
                                $destetosS_db[$destetoS->id]["consumo_semana_2_fase_2"] = $destetoS->consumo_semana_2_fase_2; 
                                $destetosS_db[$destetoS->id]["semana_1_fase_3"] = $destetoS->semana_1_fase_3; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_fase_3"] = $destetoS->consumo_semana_1_fase_3; 
                                $destetosS_db[$destetoS->id]["semana_2_fase_3"] = $destetoS->semana_2_fase_3; 
                                $destetosS_db[$destetoS->id]["consumo_semana_2_fase_3"] = $destetoS->consumo_semana_2_fase_3; 
                                $destetosS_db[$destetoS->id]["semana_3_fase_3"] = $destetoS->semana_3_fase_3;
                                $destetosS_db[$destetoS->id]["consumo_lote"] = $destetoS->consumo_lote; 
                                $destetosS_db[$destetoS->id]["consumo_semana_3_fase_3"] = $destetoS->consumo_semana_3_fase_3; 
                                $destetosS_db[$destetoS->id]["semana_1_iniciacion"] = $destetoS->semana_1_iniciacion;
                                $destetosS_db[$destetoS->id]["consumo_semana_1_iniciacion"] = $destetoS->consumo_semana_1_iniciacion;
                                $destetosS_db[$destetoS->id]["semana_2_iniciacion"] = $destetoS->semana_2_iniciacion;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_iniciacion"] = $destetoS->consumo_semana_2_iniciacion;
                                $destetosS_db[$destetoS->id]["semana_1_levante"] = $destetoS->semana_1_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_1_levante"] = $destetoS->consumo_semana_1_levante;
                                $destetosS_db[$destetoS->id]["semana_2_levante"] = $destetoS->semana_2_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_levante"] = $destetoS->consumo_semana_2_levante;  
                                $destetosS_db[$destetoS->id]["semana_3_levante"] = $destetoS->semana_3_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_3_levante"] = $destetoS->consumo_semana_3_levante;
                                $destetosS_db[$destetoS->id]["semana_4_levante"] = $destetoS->semana_4_levante;
                                $destetosS_db[$destetoS->id]["consumo_semana_4_levante"] = $destetoS->consumo_semana_4_levante;
                                $destetosS_db[$destetoS->id]["semana_1_engorde_1"] = $destetoS->semana_1_engorde_1; 
                                $destetosS_db[$destetoS->id]["consumo_semana_1_engorde_1"] = $destetoS->consumo_semana_1_engorde_1;
                                $destetosS_db[$destetoS->id]["semana_2_engorde_1"] = $destetoS->semana_2_engorde_1;
                                $destetosS_db[$destetoS->id]["semana_1_engorde_1"] = $destetoS->semana_1_engorde_1;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_engorde_1"] = $destetoS->consumo_semana_2_engorde_1;
                                $destetosS_db[$destetoS->id]["semana_1_engorde_2"] = $destetoS->semana_1_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_1_engorde_2"] = $destetoS->consumo_semana_1_engorde_2;
                                $destetosS_db[$destetoS->id]["semana_2_engorde_2"] = $destetoS->semana_2_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_2_engorde_2"] = $destetoS->consumo_semana_2_engorde_2;
                                $destetosS_db[$destetoS->id]["semana_3_engorde_2"] = $destetoS->semana_3_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_3_engorde_2"] = $destetoS->consumo_semana_3_engorde_2;
                                $destetosS_db[$destetoS->id]["semana_4_engorde_2"] = $destetoS->semana_4_engorde_2;
                                $destetosS_db[$destetoS->id]["consumo_semana_4_engorde_2"] = $destetoS->consumo_semana_4_engorde_2; 
                            }   
                        }
                    }
                }
                $destetosS_db = json_decode(json_encode($destetosS_db), true);
                $excel->sheet('Filtro', function($sheet) use($destetosS_db)
                {
                    foreach ($destetosS_db as $destetos_db) 
                    {
                        $sheet->row(1, ['Granja ', 'lote', 'Anno Destete', 'Semana Destete', ' #Destetos', ' Mortalidad %Precebo', 'Traslado Ceba','Cantidad Ceba', 'Mortalidad %Ceba', 'Semana Venta', 'Anno Venta', 'Disponibilidad Venta', ' Kilos Venta', 'Semana1 Fase1', 'Consumo Semana1 Fase1', 'Semana2 Fase1', 'Consumo Semana2 Fase1', 'Semana1 Fase2', 'Consumo Semana1 Fase2', 'Semana2 Fase2', 'Consumo Semana2 Fase2', 'Semana1 Fase3', 'Consumo Semana1 Fase3', 'Semana2 Fase3', 'Consumo Semana2 Fase3', 'Semana3 Fase3', 'Consumo Semana3 Fase3', 'Semana1 Iniciacion', 'Consumo Semana1 Iniciacion','Semana2 Iniciacion', 'Consumo Semana2 Iniciacion', 'Semana1 Levante', 'Consumo Semana1 Levante', 'Semana2 Levante', 'Consumo Semana2 Levante', 'Semana3 Levante', 'Consumo Semana3 Levante', 'Semana4 Levante', 'Consumo Semana4 Levante', 'Semana1 Engorde1', 'Consumo Semana1 Engorde1', 'Semana2 Engorde1', 'Consumo Semana2 Engorde1', 'Semana1 Engorde2', 'Consumo Semana1 Engorde2', 'Semana2 Engorde2', 'Consumo Semana2 Engorde2', 'Semana3 Engorde2', 'Consumo Semana3 Engorde2', 'Semana4 Engorde2', 'Consumo Semana4 Engorde2']);
                        $row = [];
                        $row[0] = $destetoS_db["granja_cria_id"];
                        $row[1] = $destetoS_db["lote"];
                        $row[2] = $destetoS_db["año_destete"];
                        $row[3] = $destetoS_db["semana_destete"];
                        $row[4] = $destetoS_db["numero_destetos"];
                        $row[5] = $destetoS_db["mortalidad_precebo"];
                        $row[6] = $destetoS_db["traslado_a_ceba"];
                        $row[7] = $destetoS_db["cantidad_a_ceba"];
                        $row[8] = $destetoS_db["mortalidad_ceba"];
                        $row[9] = $destetoS_db["semana_venta"];
                        $row[10] = $destetoS_db["año_venta"];
                        $row[11] = $destetoS_db["disponibilidad_venta"];
                        $row[12] = $destetoS_db["kilos_venta"];
                        $row[13] = $destetoS_db["semana_1_fase_1"];
                        $row[14] = $destetoS_db["consumo_semana_1_fase_1"];
                        $row[15] = $destetoS_db["semana_2_fase_1"];
                        $row[16] = $destetoS_db["consumo_semana_2_fase_1"];
                        $row[17] = $destetoS_db["semana_1_fase_2"];
                        $row[18] = $destetoS_db["consumo_semana_1_fase_2"];
                        $row[19] = $destetoS_db["semana_2_fase_2"];
                        $row[20] = $destetoS_db["consumo_semana_2_fase_2"];
                        $row[21] = $destetoS_db["semana_1_fase_3"];
                        $row[22] = $destetoS_db["consumo_semana_1_fase_3"];
                        $row[23] = $destetoS_db["semana_2_fase_3"];
                        $row[24] = $destetoS_db["consumo_semana_2_fase_3"];
                        $row[25] = $destetoS_db["semana_3_fase_3"];
                        $row[26] = $destetoS_db["consumo_semana_3_fase_3"];
                        $row[27] = $destetoS_db["semana_1_iniciacion"];
                        $row[28] = $destetoS_db["consumo_semana_1_iniciacion"];
                        $row[29] = $destetoS_db["semana_2_iniciacion"];
                        $row[30] = $destetoS_db["consumo_semana_2_iniciacion"];
                        $row[31] = $destetoS_db["semana_1_levante"];
                        $row[32] = $destetoS_db["consumo_semana_1_levante"];
                        $row[33] = $destetoS_db["semana_2_levante"];
                        $row[34] = $destetoS_db["consumo_semana_2_levante"];
                        $row[35] = $destetoS_db["semana_3_levante"];
                        $row[36] = $destetoS_db["consumo_semana_3_levante"];
                        $row[37] = $destetoS_db["semana_4_levante"];
                        $row[38] = $destetoS_db["consumo_semana_4_levante"];
                        $row[39] = $destetoS_db["semana_1_engorde_1"];
                        $row[40] = $destetoS_db["consumo_semana_1_engorde_1"];
                        $row[41] = $destetoS_db["semana_2_engorde_1"];
                        $row[42] = $destetoS_db["consumo_semana_2_engorde_1"];
                        $row[43] = $destetoS_db["semana_1_engorde_2"];
                        $row[44] = $destetoS_db["consumo_semana_1_engorde_2"];
                        $row[45] = $destetoS_db["semana_2_engorde_2"];
                        $row[46] = $destetoS_db["consumo_semana_2_engorde_2"];
                        $row[47] = $destetoS_db["semana_3_engorde_2"];
                        $row[48] = $destetoS_db["consumo_semana_3_engorde_2"];
                        $row[49] = $destetoS_db["semana_4_engorde_2"];
                        $row[50] = $destetoS_db["consumo_semana_4_engorde_2"];
                        $sheet->appendRow($row);
                    }
                });
            })->export('csv');
        }
    }
    /**
    * permite descargar un archivo individual con el registro seleccionado desde la vista list_precebos.blade.php
    *
    * @var Precebo 
    * @var Granja
    * @param int $id
    * @return filtroPreceboIndividual.csv
    */

    public function excelPreceboIndividual($id)
    { 
       Excel::create('filtroPreceboIndividual', function($excel) use ($id) 
       {
            $lote = Precebo::find($id);
            $granja = Granja::find($lote->granja_id);
            $excel->sheet($granja->nombre_granja, function($sheet) use ($id, $granja, $lote) 
            {
                $sheet->mergeCells('A1:AV1');
                $sheet->row(1,['Reporte de Precebo de la Granja '. $granja->nombre_granja] );
                $sheet->row(2,['Lote', 'Granja', 'Fecha de Destete', 'Fecha de Traslado', 'Semana Destete', 'Semana Traslado', 'Anno Destete', 'Anno Traslado', 'Mes Traslado', 'Numero Inicial de Cerdos', 'Edad Destete', 'Edad Inicial Total', 'Dias Jaulon', 'Dias Permanencia', 'Edad Final', 'Edad Final Ajustada', 'Peso Esperado', 'Numero de Muertes', 'Numero de Descartes', 'Numero de Livianos', 'Numero Final', 'Porcentaje de Mortalidad', 'Porcentaje de Descartes', 'Porcentaje de Livianos', 'Peso Inicial', 'Peso Promedio Inicial', 'Peso Ponderado Inicial', 'Peso Final', 'Peso Promedio Final', 'Peso Ponderado Final', 'Ind. de Peso Final', 'Consumo Total', 'Consumo Promedio', 'Consumo Ponderado', 'Consumo Promediado por Dias', 'Consumo Promedio Inicial', 'Consumo Ponderado Inicial', 'Consumo Promediado por Dias Iniciales', 'Consumo Ajustado Inicial', 'ATO Promedio Inicial', 'ATO Promedio Dia Inicial', 'Conversion Inicial', 'Conversion Ajustada Inicial', 'Consumo Ajustado Final', 'ATO Promedio Final', 'ATO Promedio Dia Final', 'Conversion Final', 'Conversion Ajustada Final'] );

                $row = [];
                $row[0] = $lote->lote;
                $row[1] = $granja->nombre_granja;
                $row[2] = $lote->fecha_destete;
                $row[3] = $lote->fecha_traslado;
                $row[4] = $lote->semana_destete;
                $row[5] = $lote->semana_traslado;
                $row[6] = $lote->año_destete;
                $row[7] = $lote->año_traslado;
                $row[8] = $lote->mes_traslado;
                $row[9] = $lote->numero_inicial;
                $row[10] = $lote->edad_destete;
                $row[11] = $lote->edad_inicial_total;
                $row[12] = $lote->dias_jaulon;
                $row[13] = $lote->dias_totales_permanencia;
                $row[14] = $lote->edad_final;
                $row[15] = $lote->edad_final_ajustada;
                $row[16] = $lote->peso_esperado;
                $row[17] = $lote->numero_muertes;
                $row[18] = $lote->numero_descartes;
                $row[19] = $lote->numero_livianos;
                $row[20] = $lote->numero_final;
                $row[21] = $lote->porciento_mortalidad;
                $row[22] = $lote->porciento_descartes;
                $row[23] = $lote->porciento_livianos;
                $row[24] = $lote->peso_ini;
                $row[25] = $lote->peso_promedio_ini;
                $row[26] = $lote->peso_ponderado_ini;
                $row[27] = $lote->peso_fin;
                $row[28] = $lote->peso_promedio_fin;
                $row[29] = $lote->peso_ponderado_fin;
                $row[30] = $lote->ind_peso_final;
                $row[31] = $lote->cons_total;
                $row[32] = $lote->cons_promedio;
                $row[33] = $lote->cons_ponderado;
                $row[34] = $lote->cons_promedio_dia;
                $row[35] = $lote->cons_promedio_ini;
                $row[36] = $lote->cons_ponderado_ini;
                $row[37] = $lote->cons_promedio_dia_ini;
                $row[38] = $lote->cons_ajustado_ini;
                $row[39] = $lote->ato_promedio_ini;
                $row[40] = $lote->ato_promedio_dia_ini;
                $row[41] = $lote->conversion_ini;
                $row[42] = $lote->cons_ajustado_fin;
                $row[43] = $lote->ato_promedio_fin;
                $row[44] = $lote->ato_promedio_dia_fin;
                $row[45] = $lote->conversion_fin;
                $sheet->appendRow($row); 
            });
        })->export('csv');
    }
    /**
    * permite descargar un archivo individual desde la vista list_cebas.blade.php el registro seleccionado
    *
    * @var Ceba
    * @var Granja
    * @param int $id
    * @return filtroCebaIndividual.csv
    */

    public function excelCebaIndividual($id)
    {
        Excel::create('filtroCebaIndividual', function($excel) use ($id) 
       {
        

            $lote = Ceba::find($id);
            $granja = Granja::find($lote->granja_id);
            $excel->sheet($granja->nombre_granja, function($sheet) use ($id, $granja, $lote) 
            {
                //header del Excel

                $sheet->mergeCells('A1:AP1');
                $sheet->row(1,['Reporte de Ceba de la Granja '. $granja->nombre_granja] );
                $sheet->row(2, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Numero de Descartes', 'Numero de Livianos', 'Numero de Muertes', 'Cantidad Final de Cerdos', 'Meta de Cerdos a Entregar', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias Permanencia', 'Edad Final', 'Edad Final Total', 'Conf. Edad Final', 'Porcentaje de Mortalidad', 'Porcentaje de Descartes', 'Porcentaje de Livianos', 'Peso Total Inicial', 'Peso Promedio Inicial', 'Peso Total Vendido', 'Promedio Vendido', 'Consumo Lote', 'Consumo Promedio', 'Consumo Promedio Dias']);
                $row = [];
                $row[0] = $lote->lote;
                $row[1] = $granja->nombre_granja;
                $row[2] = $lote->fecha_ingreso_lote;
                $row[3] = $lote->fecha_salida_lote;
                $row[4] = $lote->año;
                $row[5] = $lote->mes;
                $row[6] = $lote->semana;
                $row[7] = $lote->inic;
                $row[8] = $lote->cerdos_descartados;
                $row[9] = $lote->cerdos_livianos;
                $row[10] = $lote->muertes;
                $row[11] = $lote->cant_final_cerdos;
                $row[12] = $lote->meta_cerdos;
                $row[13] = $lote->edad_inicial;
                $row[14] = $lote->edad_inicial_total;
                $row[15] = $lote->dias;
                $row[16] = $lote->dias_permanencia;
                $row[17] = $lote->edad_final;
                $row[18] = $lote->edad_final_total;
                $row[19] = $lote->conf_edad_final;
                $row[20] = $lote->por_mortalidad;
                $row[21] = $lote->por_descartes;
                $row[22] = $lote->por_livianos;
                $row[23] = $lote->peso_total_ingresado;
                $row[24] = $lote->peso_promedio_ingresado;
                $row[25] = $lote->peso_total_vendido;
                $row[26] = $lote->peso_promedio_vendido;
                $row[27] = $lote->consumo_lote;
                $row[28] = $lote->consumo_promedio_lote;
                $row[29] = $lote->consumo_promedio_lote_dias;
                $sheet->appendRow($row); 
            });
        })->export('csv');
    }
    /**
    *permite descargar un archivo desde la vista list_destete_finalizacion.blade el registro seleccionado
    *
    * @var DesteteFinalizacion
    * @var Granja
    * @param int $id
    * @return filtroDesteteFinalizacionIndividual.csv
    */

    public function excelDesteteFinalizacionIndividual($id)
    {
        Excel::create('filtroDesteteFinalizacionIndividual', function($excel) use ($id) 
       {
        

            $lote = DesteteFinalizacion::find($id);
            $granja = Granja::find($lote->granja_id);
            $excel->sheet($granja->nombre_granja, function($sheet) use ($id, $granja, $lote) 
            {
                //header del Excel

                $sheet->mergeCells('A1:AD1');
                $sheet->row(1,['Reporte de Destete Finalización de la Granja '. $granja->nombre_granja] );
                $sheet->row(2, ['Lote', 'Granja', 'Fecha de Ingreso', 'Fecha de Salida', 'Anno', 'Mes', 'Semana', 'Numero Inicial de Cerdos', 'Numero de Descartes', 'Numero de Livianos', 'Numero de Muertes', 'Numero Final de Cerdos', 'Meta de Cerdos a Entregar', 'Edad Inicial', 'Edad Inicial Total', 'Dias', 'Dias de Permanencia', 'Edad Final', 'Edad Final Total', 'Conf Edad Final', 'Porcentaje de Mortalidad', 'Porcentaje de Descartes', 'Porcentaje de Livianos', 'Peso Total Ingresado', 'Peso Promedio Ingresado', 'Peso Total Vendido', 'Peso Promedio Vendido', 'Consumo Lote', 'Consumo Promedio Lote', 'Consumo Promedio Lote/Dias']);
                $row = [];
                $row[0] = $lote->lote;
                $row[1] = $granja->nombre_granja;
                $row[2] = $lote->fecha_ingreso_lote;
                $row[3] = $lote->fecha_salida_lote;
                $row[4] = $lote->año;
                $row[5] = $lote->mes;
                $row[6] = $lote->semana;
                $row[7] = $lote->inic;
                $row[8] = $lote->cerdos_descartados;
                $row[9] = $lote->cerdos_livianos;
                $row[10] = $lote->muertes;
                $row[11] = $lote->cant_final_cerdos;
                $row[12] = $lote->meta_cerdos;
                $row[13] = $lote->edad_inicial;
                $row[14] = $lote->edad_inicial_total;
                $row[15] = $lote->dias;
                $row[16] = $lote->dias_permanencia;
                $row[17] = $lote->edad_final;
                $row[18] = $lote->edad_final_total;
                $row[19] = $lote->conf_edad_final;
                $row[20] = $lote->por_mortalidad;
                $row[21] = $lote->por_descartes;
                $row[22] = $lote->por_livianos;
                $row[23] = $lote->peso_total_ingresado;
                $row[24] = $lote->peso_promedio_ingresado;
                $row[25] = $lote->peso_total_vendido;
                $row[26] = $lote->peso_promedio_vendido;
                $row[27] = $lote->consumo_lote;
                $row[28] = $lote->consumo_promedio_lote;
                $row[29] = $lote->consumo_promedio_lote_dias;
                $sheet->appendRow($row); 
            });
        })->export('csv');
    }
    /**
    * permite descargar un archivo desde la vista list_reporte_mortalidad_precebo_ceba.blade.php
    * el registro seleccionado.
    *
    * @var ReporteMortalidadPreceboCeba
    * @var Granja
    * @var CausaMuerte
    * @var Alimento
    * @param int $id
    * @return filtroReporteMortalidadIndividual.csv
    */

    public function excelMortalidadIndividual($id)
    {
        Excel::create('filtroReporteMortalidadIndividual', function($excel) use ($id) 
        {

            $lote = ReporteMortalidadPreceboCeba::find($id);
            $granja = Granja::find($lote->granja_id);
            $causa = CausaMuerte::find($lote->causa_id);
            $alimento = Alimento::find($lote->alimento_id);
            $excel->sheet($granja->nombre_granja, function($sheet) use ($id, $granja, $lote, $causa, $alimento) 
            {
                //header del Excel

                $sheet->mergeCells('A1:M1');
                $sheet->row(1,['Reporte de Mortalidad de la Granja '. $granja->nombre_granja] );
                $sheet->row(2, ['Granja', 'Lote', 'Sala', 'Numero de Cerdos', 'Sexo del Cerdo', 'Peso del Cerdo', 'Fecha', 'Dia de Muerte', 'Anno de Muerte', 'Mes de Muerte', 'Semana de Muerte', 'Causa', 'Alimento']);
                $row = [];
                $row[0] = $lote->lote;
                $row[1] = $granja->nombre_granja;
                $row[2] = $lote->sala;
                $row[3] = $lote->numero_cerdos;
                $row[4] = $lote->sexo_cerdo;
                $row[5] = $lote->peso_cerdo;
                $row[6] = $lote->fecha;
                $row[7] = $lote->dia_muerte;
                $row[8] = $lote->año_muerte;
                $row[9] = $lote->mes_muerte;
                $row[10] = $lote->semana_muerte;
                $row[11] = $causa->causa;
                $row[12] = $alimento->nombre_alimento;
                $sheet->appendRow($row);
                
            });
        })->export('csv');
    }
    /**
    * permite descargar un archivo desde la vista list_destetos_semana.blade.php
    * el registro seleccionado 
    *
    * @var DestetosSemana
    * @var Granja
    * @param int $id
    * @return filtroReporteDestetoSemanalIndividual.csv
    */

    public function excelDestetoSemanalIndividual($id)
    {
        Excel::create('filtroReporteDestetoSemanalIndividual', function($excel) use ($id) 
        {
            $lote = DestetosSemana::find($id);
            $granja = Granja::find($lote->granja_cria_id);
            $excel->sheet($granja->nombre_granja, function($sheet) use ($id, $granja, $lote) 
            {
                //header del Excel

                $sheet->mergeCells('A1:AY1');
                $sheet->row(1,['Reporte de Destetos Semanales de la Granja '. $granja->nombre_granja] );
                $sheet->row(2, ['lote', 'Granja donde se crio', 'Anno Destete', 'Semana Destete', ' Numero de Destetos', ' Mortalidad Porcentual en Precebo', 'Traslado Ceba','Cantidad Ceba', 'Mortalidad Porcentual en Ceba', 'Semana Venta', 'Anno Venta', 'Disponibilidad Venta', ' Kilos Venta', 'Semana1 Fase1', 'Consumo Semana1 Fase1', 'Semana2 Fase1', 'Consumo Semana2 Fase1', 'Semana1 Fase2', 'Consumo Semana1 Fase2', 'Semana2 Fase2', 'Consumo Semana2 Fase2', 'Semana1 Fase3', 'Consumo Semana1 Fase3', 'Semana2 Fase3', 'Consumo Semana2 Fase3', 'Semana3 Fase3', 'Consumo Semana3 Fase3', 'Semana1 Iniciacion', 'Consumo Semana1 Iniciacion','Semana2 Iniciacion', 'Consumo Semana2 Iniciacion', 'Semana1 Levante', 'Consumo Semana1 Levante', 'Semana2 Levante', 'Consumo Semana2 Levante', 'Semana3 Levante', 'Consumo Semana3 Levante', 'Semana4 Levante', 'Consumo Semana4 Levante', 'Semana1 Engorde1', 'Consumo Semana1 Engorde1', 'Semana2 Engorde1', 'Consumo Semana2 Engorde1', 'Semana1 Engorde2', 'Consumo Semana1 Engorde2', 'Semana2 Engorde2', 'Consumo Semana2 Engorde2', 'Semana3 Engorde2', 'Consumo Semana3 Engorde2', 'Semana4 Engorde2', 'Consumo Semana4 Engorde2']);
                $row = [];
                $row[0] = $lote->lote;
                $row[1] = $granja->nombre_granja;
                $row[2] = $lote->año_destete;
                $row[3] = $lote->semana_destete;
                $row[4] = $lote->numero_destetos;
                $row[5] = $lote->mortalidad_precebo;
                $row[6] = $lote->traslado_a_ceba;
                $row[7] = $lote->cantidad_a_ceba;
                $row[8] = $lote->mortalidad_ceba;
                $row[9] = $lote->semana_venta;
                $row[10] = $lote->año_venta;
                $row[11] = $lote->disponibilidad_venta;
                $row[12] = $lote->kilos_venta;
                $row[13] = $lote->semana_1_fase_1;
                $row[14] = $lote->consumo_semana_1_fase_1;
                $row[15] = $lote->semana_2_fase_1;
                $row[16] = $lote->consumo_semana_2_fase_1;
                $row[17] = $lote->semana_1_fase_2;
                $row[18] = $lote->consumo_semana_1_fase_2;
                $row[19] = $lote->semana_2_fase_2;
                $row[20] = $lote->consumo_semana_2_fase_2;
                $row[21] = $lote->semana_1_fase_3;
                $row[22] = $lote->consumo_semana_1_fase_3;
                $row[23] = $lote->semana_2_fase_3;
                $row[24] = $lote->consumo_semana_2_fase_3;
                $row[25] = $lote->semana_3_fase_3;
                $row[26] = $lote->consumo_semana_3_fase_3;
                $row[27] = $lote->semana_1_iniciacion;
                $row[28] = $lote->consumo_semana_1_iniciacion;
                $row[29] = $lote->semana_2_iniciacion;
                $row[30] = $lote->consumo_semana_2_iniciacion;
                $row[31] = $lote->semana_1_levante;
                $row[32] = $lote->consumo_semana_1_levante;
                $row[33] = $lote->semana_2_levante;
                $row[34] = $lote->consumo_semana_2_levante;
                $row[35] = $lote->semana_3_levante;
                $row[36] = $lote->consumo_semana_3_levante;
                $row[37] = $lote->semana_4_levante;
                $row[38] = $lote->consumo_semana_4_levante;
                $row[39] = $lote->semana_1_engorde_1;
                $row[40] = $lote->consumo_semana_1_engorde_1;
                $row[41] = $lote->semana_2_engorde_1;
                $row[42] = $lote->consumo_semana_2_engorde_1;
                $row[43] = $lote->semana_1_engorde_2;
                $row[44] = $lote->consumo_semana_1_engorde_2;
                $row[45] = $lote->semana_2_engorde_2;
                $row[46] = $lote->consumo_semana_2_engorde_2;
                $row[47] = $lote->semana_3_engorde_2;
                $row[48] = $lote->consumo_semana_3_engorde_2;
                $row[49] = $lote->semana_4_engorde_2;
                $row[50] = $lote->consumo_semana_4_engorde_2;
                $sheet->appendRow($row);  
            });
        })->export('csv');
    }
}