<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PedidoMedicamento;
use App\PedidoInsumoServicio;
use App\PedidoConcentrado;
use App\PedidoCia;
use App\ConsecutivoMedicamento;
use App\ConsecutivoConcentrado;
use App\ConsecutivoCia;
use DB;
use App\DesteteFinalizacion;
use Auth;
use PDF;
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
use App\ReporteMortalidadPreceboCeba;
use App\Http\Requests;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Permite descargar un pdf desde la vista tabla_precebo.blade.php con la informacion 
    * que hay en esa vista 
    * 
    * @var Precebo
    * @var Granja
    * @param int $id
    * @return $pdfPedido->download('Precebo '. $precebo->id .'.pdf')
    */

 	public function pdfPreceboIndividual($id)
    {
    	
        $precebo = Precebo::find($id);
        $granja = Granja::find($precebo->granja_id);
        $lote = $precebo->lote;

        $precebo_solicitado[$precebo->id]['lote'] = $precebo->lote;
        $precebo_solicitado[$precebo->id]['nombre_granja'] = $granja->nombre_granja;
        $precebo_solicitado[$precebo->id]['fecha_destete'] = $precebo->fecha_destete;
        $precebo_solicitado[$precebo->id]['fecha_traslado'] = $precebo->fecha_traslado;
        $precebo_solicitado[$precebo->id]['semana_destete'] = $precebo->semana_destete;
        $precebo_solicitado[$precebo->id]['semana_traslado'] = $precebo->semana_traslado;
        $precebo_solicitado[$precebo->id]['año_destete'] = $precebo->año_destete;
        $precebo_solicitado[$precebo->id]['año_traslado'] = $precebo->año_traslado;
        $precebo_solicitado[$precebo->id]['mes_traslado'] = $precebo->mes_traslado;
        $precebo_solicitado[$precebo->id]['numero_inicial'] = $precebo->numero_inicial;
        $precebo_solicitado[$precebo->id]['edad_destete'] = $precebo->edad_destete;
        $precebo_solicitado[$precebo->id]['edad_inicial_total'] = $precebo->edad_inicial_total;
        $precebo_solicitado[$precebo->id]['dias_jaulon'] = $precebo->dias_jaulon;
        $precebo_solicitado[$precebo->id]['dias_totales_permanencia'] = $precebo->dias_totales_permanencia;
        $precebo_solicitado[$precebo->id]['edad_final'] = $precebo->edad_final;
        $precebo_solicitado[$precebo->id]['edad_final_ajustada'] = $precebo->edad_final_ajustada;
        $precebo_solicitado[$precebo->id]['peso_esperado'] = $precebo->peso_esperado;
        $precebo_solicitado[$precebo->id]['numero_muertes'] = $precebo->numero_muertes;
        $precebo_solicitado[$precebo->id]['numero_descartes'] = $precebo->numero_descartes;
        $precebo_solicitado[$precebo->id]['numero_livianos'] = $precebo->numero_livianos;
        $precebo_solicitado[$precebo->id]['numero_final'] = $precebo->numero_final;
        $precebo_solicitado[$precebo->id]['porciento_mortalidad'] = $precebo->porciento_mortalidad;
        $precebo_solicitado[$precebo->id]['porciento_descartes'] = $precebo->porciento_descartes;
        $precebo_solicitado[$precebo->id]['porciento_livianos'] = $precebo->porciento_livianos;
        $precebo_solicitado[$precebo->id]['peso_ini'] = $precebo->peso_ini;
        $precebo_solicitado[$precebo->id]['peso_promedio_ini'] = $precebo->peso_promedio_ini;
        $precebo_solicitado[$precebo->id]['peso_ponderado_ini'] = $precebo->peso_ponderado_ini;
        $precebo_solicitado[$precebo->id]['peso_fin'] = $precebo->peso_fin;
        $precebo_solicitado[$precebo->id]['peso_promedio_fin'] = $precebo->peso_promedio_fin;
        $precebo_solicitado[$precebo->id]['peso_ponderado_fin'] = $precebo->peso_ponderado_fin;
        $precebo_solicitado[$precebo->id]['ind_peso_final'] = $precebo->ind_peso_final;
        $precebo_solicitado[$precebo->id]['cons_total'] = $precebo->cons_total;
        $precebo_solicitado[$precebo->id]['cons_promedio'] = $precebo->cons_promedio;
        $precebo_solicitado[$precebo->id]['cons_ponderado'] = $precebo->cons_ponderado;
        $precebo_solicitado[$precebo->id]['cons_promedio_dia'] = $precebo->cons_promedio_dia;
        $precebo_solicitado[$precebo->id]['cons_promedio_ini'] = $precebo->cons_promedio_ini;
        $precebo_solicitado[$precebo->id]['cons_ponderado_ini'] = $precebo->cons_ponderado_ini;
        $precebo_solicitado[$precebo->id]['cons_promedio_dia_ini'] = $precebo->cons_promedio_dia_ini;
        $precebo_solicitado[$precebo->id]['cons_ajustado_ini'] = $precebo->cons_ajustado_ini;
        $precebo_solicitado[$precebo->id]['ato_promedio_ini'] = $precebo->ato_promedio_ini;
        $precebo_solicitado[$precebo->id]['ato_promedio_dia_ini'] = $precebo->ato_promedio_dia_ini;
        $precebo_solicitado[$precebo->id]['conversion_ini'] = $precebo->conversion_ini;
        $precebo_solicitado[$precebo->id]['cons_ajustado_fin'] = $precebo->cons_ajustado_fin;
        $precebo_solicitado[$precebo->id]['ato_promedio_fin'] = $precebo->ato_promedio_fin;
        $precebo_solicitado[$precebo->id]['ato_promedio_dia_fin'] = $precebo->ato_promedio_dia_fin;
        $precebo_solicitado[$precebo->id]['conversion_fin'] = $precebo->conversion_fin;


        $pdfPedido = PDF::loadView('admin.pdf.format_pdf_precebo', ['precebo_solicitado' => $precebo_solicitado, 'granja' => $granja, 'lote' => $lote]);  
        return $pdfPedido->download('Precebo '. $precebo->id .'.pdf');
    }

    /**
    * permite descargar un archivo PDF desde la vista tabla_ceba.blade.php con la
    * informacion de ese dato seleccionado
    * 
    * @var Ceba
    * @var Granja
    * @param int $id
    * @return $pdfPedido->download('Ceba '. $ceba->id .'.pdf')
    */

    public function pdfCebaIndividual($id)
    {
    	$ceba = Ceba::find($id);
        $granja = Granja::find($ceba->granja_id);
        $lote = $ceba->lote;

        $ceba_solicitada[$ceba->id]['lote'] = $ceba->lote;
        $ceba_solicitada[$ceba->id]['nombre_granja'] = $granja->nombre_granja;
        $ceba_solicitada[$ceba->id]['fecha_ingreso_lote'] = $ceba->fecha_ingreso_lote;
        $ceba_solicitada[$ceba->id]['fecha_salida_lote'] = $ceba->fecha_salida_lote;
        $ceba_solicitada[$ceba->id]['año'] = $ceba->año;
        $ceba_solicitada[$ceba->id]['mes'] = $ceba->mes;
        $ceba_solicitada[$ceba->id]['semana'] = $ceba->semana;
        $ceba_solicitada[$ceba->id]['inic'] = $ceba->inic;
        $ceba_solicitada[$ceba->id]['cerdos_descartados'] = $ceba->cerdos_descartados;
        $ceba_solicitada[$ceba->id]['cerdos_livianos'] = $ceba->cerdos_livianos;
        $ceba_solicitada[$ceba->id]['muertes'] = $ceba->muertes;
        $ceba_solicitada[$ceba->id]['cant_final_cerdos'] = $ceba->cant_final_cerdos;
        $ceba_solicitada[$ceba->id]['meta_cerdos'] = $ceba->meta_cerdos;
        $ceba_solicitada[$ceba->id]['edad_inicial'] = $ceba->edad_inicial;
        $ceba_solicitada[$ceba->id]['edad_inicial_total'] = $ceba->edad_inicial_total;
        $ceba_solicitada[$ceba->id]['dias'] = $ceba->dias;
        $ceba_solicitada[$ceba->id]['dias_permanencia'] = $ceba->dias_permanencia;
        $ceba_solicitada[$ceba->id]['edad_final'] = $ceba->edad_final;
        $ceba_solicitada[$ceba->id]['edad_final_total'] = $ceba->edad_final_total;
        $ceba_solicitada[$ceba->id]['conf_edad_final'] = $ceba->conf_edad_final;
        $ceba_solicitada[$ceba->id]['por_mortalidad'] = $ceba->por_mortalidad;
        $ceba_solicitada[$ceba->id]['por_descartes'] = $ceba->por_descartes;
        $ceba_solicitada[$ceba->id]['por_livianos'] = $ceba->por_livianos;
        $ceba_solicitada[$ceba->id]['peso_total_ingresado'] = $ceba->peso_total_ingresado;
        $ceba_solicitada[$ceba->id]['peso_promedio_ingresado'] = $ceba->peso_promedio_ingresado;
        $ceba_solicitada[$ceba->id]['peso_promedio_vendido'] = $ceba->peso_promedio_vendido;
        $ceba_solicitada[$ceba->id]['peso_total_vendido'] = $ceba->peso_promedio_vendido;
        $ceba_solicitada[$ceba->id]['consumo_lote'] = $ceba->consumo_lote;
        $ceba_solicitada[$ceba->id]['consumo_promedio_lote'] = $ceba->consumo_promedio_lote;
        $ceba_solicitada[$ceba->id]['consumo_promedio_lote_dias'] = $ceba->consumo_promedio_lote_dias;
        $ceba_solicitada[$ceba->id]['cons_promedio_ini'] = $ceba->cons_promedio_ini;
        $ceba_solicitada[$ceba->id]['cons_promedio_dia_ini'] = $ceba->cons_promedio_dia_ini;
        $ceba_solicitada[$ceba->id]['ato_promedio_ini'] = $ceba->ato_promedio_ini;
        $ceba_solicitada[$ceba->id]['ato_promedio_dia_ini'] = $ceba->ato_promedio_dia_ini;
        $ceba_solicitada[$ceba->id]['conversion_ini'] = $ceba->conversion_ini;
        $ceba_solicitada[$ceba->id]['conversion_ajust_ini'] = $ceba->conversion_ajust_ini;
        $ceba_solicitada[$ceba->id]['cons_ajustado_fin'] = $ceba->cons_ajustado_fin;
        $ceba_solicitada[$ceba->id]['ato_promedio_fin'] = $ceba->ato_promedio_fin;
        $ceba_solicitada[$ceba->id]['ato_promedio_dia_fin'] = $ceba->ato_promedio_dia_fin;
        $ceba_solicitada[$ceba->id]['conversion_fin'] = $ceba->conversion_fin;
        $ceba_solicitada[$ceba->id]['conversion_ajust_fin'] = $ceba->conversion_ajust_fin;
        $pdfPedido = PDF::loadView('admin.pdf.format_pdf_ceba', ['ceba_solicitada' => $ceba_solicitada, 'granja' => $granja, 'lote' => $lote]);  
        return $pdfPedido->download('Ceba '. $ceba->id .'.pdf');
    }

    /**
    * permite descargar un archivo pdf desde la vista tabla_destete_finalizacion.blade.php
    * la informacion que hay en esa vista
    *
    * @var DesteteFinalizacion
    * @var Granja
    * @param int $id
    * @return $pdfPedido->download('Destete Finalización '. $desteteF->id .'.pdf');
    */

    public function pdfDesteteFinalizacionIndividual($id)
    {
    	$desteteF = DesteteFinalizacion::find($id);
        $granja = Granja::find($desteteF->granja_id);
        $lote = $desteteF->lote;

        $destete_f_solicitado[$desteteF->id]['lote'] = $desteteF->lote;
        $destete_f_solicitado[$desteteF->id]['nombre_granja'] = $granja->nombre_granja;
        $destete_f_solicitado[$desteteF->id]['fecha_ingreso_lote'] = $desteteF->fecha_ingreso_lote;
        $destete_f_solicitado[$desteteF->id]['fecha_salida_lote'] = $desteteF->fecha_salida_lote;
        $destete_f_solicitado[$desteteF->id]['año'] = $desteteF->año;
        $destete_f_solicitado[$desteteF->id]['mes'] = $desteteF->mes;
        $destete_f_solicitado[$desteteF->id]['semana'] = $desteteF->semana;
        $destete_f_solicitado[$desteteF->id]['inic'] = $desteteF->inic;
        $destete_f_solicitado[$desteteF->id]['cerdos_descartados'] = $desteteF->cerdos_descartados;
        $destete_f_solicitado[$desteteF->id]['cerdos_livianos'] = $desteteF->cerdos_livianos;
        $destete_f_solicitado[$desteteF->id]['muertes'] = $desteteF->muertes;
        $destete_f_solicitado[$desteteF->id]['cant_final_cerdos'] = $desteteF->cant_final_cerdos;
        $destete_f_solicitado[$desteteF->id]['meta_cerdos'] = $desteteF->meta_cerdos;
        $destete_f_solicitado[$desteteF->id]['edad_inicial'] = $desteteF->edad_inicial;
        $destete_f_solicitado[$desteteF->id]['edad_inicial_total'] = $desteteF->edad_inicial_total;
        $destete_f_solicitado[$desteteF->id]['dias'] = $desteteF->dias;
        $destete_f_solicitado[$desteteF->id]['dias_permanencia'] = $desteteF->dias_permanencia;
        $destete_f_solicitado[$desteteF->id]['edad_final'] = $desteteF->edad_final;
        $destete_f_solicitado[$desteteF->id]['edad_final_total'] = $desteteF->edad_final_total;
        $destete_f_solicitado[$desteteF->id]['conf_edad_final'] = $desteteF->conf_edad_final;
        $destete_f_solicitado[$desteteF->id]['por_mortalidad'] = $desteteF->por_mortalidad;
        $destete_f_solicitado[$desteteF->id]['por_descartes'] = $desteteF->por_descartes;
        $destete_f_solicitado[$desteteF->id]['por_livianos'] = $desteteF->por_livianos;
        $destete_f_solicitado[$desteteF->id]['peso_total_ingresado'] = $desteteF->peso_total_ingresado;
        $destete_f_solicitado[$desteteF->id]['peso_promedio_ingresado'] = $desteteF->peso_promedio_ingresado;
        $destete_f_solicitado[$desteteF->id]['peso_promedio_vendido'] = $desteteF->peso_promedio_vendido;
        $destete_f_solicitado[$desteteF->id]['peso_total_vendido'] = $desteteF->peso_promedio_vendido;
        $destete_f_solicitado[$desteteF->id]['consumo_lote'] = $desteteF->consumo_lote;
        $destete_f_solicitado[$desteteF->id]['consumo_promedio_lote'] = $desteteF->consumo_promedio_lote;
        $destete_f_solicitado[$desteteF->id]['consumo_promedio_lote_dias'] = $desteteF->consumo_promedio_lote_dias;
        $destete_f_solicitado[$desteteF->id]['cons_promedio_ini'] = $desteteF->cons_promedio_ini;
        $destete_f_solicitado[$desteteF->id]['cons_promedio_dia_ini'] = $desteteF->cons_promedio_dia_ini;
        $destete_f_solicitado[$desteteF->id]['ato_promedio'] = $desteteF->ato_promedio;
        $destete_f_solicitado[$desteteF->id]['ato_promedio_dia'] = $desteteF->ato_promedio_dia;
        $destete_f_solicitado[$desteteF->id]['conversion'] = $desteteF->conversion;
        $pdfPedido = PDF::loadView('admin.pdf.format_pdf_destete_finalizacion', ['destete_f_solicitado' => $destete_f_solicitado, 'granja' => $granja, 'lote' => $lote]);  
        return $pdfPedido->download('Destete Finalización '. $desteteF->id .'.pdf');
    }

    /**
    * permite descargar un archivo PDF desde la vista tabla_mortalidad.blade.php 
    * la informacion que hay en esa vista 
    *
    * @var ReporteMortalidaPreceboCeba
    * @var Granja
    * @var Alimento
    * @var CausaMuerte
    * @param int $id
    * @return $pdfPedido->download('Mortalidad '. $mortalidad->id .'.pdf')
    */

    public function pdfMortalidadIndividual($id)
    {
    	$mortalidad = ReporteMortalidadPreceboCeba::find($id);
        $granja = Granja::find($mortalidad->granja_id);
        $alimento = Alimento::find($mortalidad->alimento_id);
        $causa = CausaMuerte::find($mortalidad->causa_id);
        $lote = $mortalidad->lote;

        $mortalidad_solicitada[$mortalidad->id]['lote'] = $mortalidad->lote;
        $mortalidad_solicitada[$mortalidad->id]['nombre_granja'] = $granja->nombre_granja;
        $mortalidad_solicitada[$mortalidad->id]['sala'] = $mortalidad->sala;
        $mortalidad_solicitada[$mortalidad->id]['numero_cerdos'] = $mortalidad->numero_cerdos;
        $mortalidad_solicitada[$mortalidad->id]['sexo_cerdo'] = $mortalidad->sexo_cerdo;
        $mortalidad_solicitada[$mortalidad->id]['peso_cerdo'] = $mortalidad->peso_cerdo;
        $mortalidad_solicitada[$mortalidad->id]['fecha'] = $mortalidad->fecha;
        $mortalidad_solicitada[$mortalidad->id]['dia_muerte'] = $mortalidad->dia_muerte;
        $mortalidad_solicitada[$mortalidad->id]['año_muerte'] = $mortalidad->año_muerte;
        $mortalidad_solicitada[$mortalidad->id]['mes_muerte'] = $mortalidad->mes_muerte;
        $mortalidad_solicitada[$mortalidad->id]['semana_muerte'] = $mortalidad->semana_muerte;
        $mortalidad_solicitada[$mortalidad->id]['causa'] = $causa->causa;
        $mortalidad_solicitada[$mortalidad->id]['nombre_alimento'] = $alimento->nombre_alimento;

        $pdfPedido = PDF::loadView('admin.pdf.format_pdf_mortalidad', ['mortalidad_solicitada' => $mortalidad_solicitada, 'granja' => $granja, 'lote' => $lote]);  
        return $pdfPedido->download('Mortalidad '. $mortalidad->id .'.pdf');
    }

    /**
    * permite descargar un archivo PDF desde la vista tabla_destete_semana.blade.php
    * la informacion que hay en esa vista 
    *
    * @var DestetosSemana
    * @var Granja
    * @param int $id
    * @return $pdfPedido->download('Destete Semana '. $desteteS->id .'.pdf');
    */

    public function pdfDestetoSemanaIndividual($id)
    {
    	$desteteS = DestetosSemana::find($id);
        $granja = Granja::find($desteteS->granja_cria_id);
        $lote = $desteteS->lote;

        $desteteS_solicitada[$desteteS->id]['lote'] = $desteteS->lote;
        $desteteS_solicitada[$desteteS->id]['nombre_granja'] = $granja->nombre_granja;
        $desteteS_solicitada[$desteteS->id]['año_destete'] = $desteteS->año_destete;
        $desteteS_solicitada[$desteteS->id]['semana_destete'] = $desteteS->semana_destete;
        $desteteS_solicitada[$desteteS->id]['numero_destetos'] = $desteteS->numero_destetos;
        $desteteS_solicitada[$desteteS->id]['mortalidad_precebo'] = $desteteS->mortalidad_precebo;
        $desteteS_solicitada[$desteteS->id]['traslado_a_ceba'] = $desteteS->traslado_a_ceba;
        $desteteS_solicitada[$desteteS->id]['cantidad_a_ceba'] = $desteteS->cantidad_a_ceba;
        $desteteS_solicitada[$desteteS->id]['mortalidad_ceba'] = $desteteS->mortalidad_ceba;
        $desteteS_solicitada[$desteteS->id]['semana_venta'] = $desteteS->semana_venta;
        $desteteS_solicitada[$desteteS->id]['año_venta'] = $desteteS->año_venta;
        $desteteS_solicitada[$desteteS->id]['disponibilidad_venta'] = $desteteS->disponibilidad_venta;
        $desteteS_solicitada[$desteteS->id]['kilos_venta'] = $desteteS->kilos_venta;
        $desteteS_solicitada[$desteteS->id]['semana_1_fase_1'] = $desteteS->semana_1_fase_1;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_1_fase_1'] = $desteteS->consumo_semana_1_fase_1;
        $desteteS_solicitada[$desteteS->id]['semana_2_fase_1'] = $desteteS->semana_2_fase_1;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_2_fase_1'] = $desteteS->consumo_semana_2_fase_1;
        $desteteS_solicitada[$desteteS->id]['semana_1_fase_2'] = $desteteS->semana_1_fase_2;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_1_fase_2'] = $desteteS->consumo_semana_1_fase_2;
        $desteteS_solicitada[$desteteS->id]['semana_2_fase_2'] = $desteteS->semana_2_fase_2;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_2_fase_2'] = $desteteS->consumo_semana_2_fase_2;
        $desteteS_solicitada[$desteteS->id]['semana_1_fase_3'] = $desteteS->semana_1_fase_3;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_1_fase_3'] = $desteteS->consumo_semana_1_fase_3;
        $desteteS_solicitada[$desteteS->id]['semana_2_fase_3'] = $desteteS->semana_2_fase_3;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_2_fase_3'] = $desteteS->consumo_semana_2_fase_3;
        $desteteS_solicitada[$desteteS->id]['semana_3_fase_3'] = $desteteS->semana_3_fase_3;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_3_fase_3'] = $desteteS->consumo_semana_3_fase_3;
        $desteteS_solicitada[$desteteS->id]['semana_1_iniciacion'] = $desteteS->semana_1_iniciacion;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_1_iniciacion'] = $desteteS->consumo_semana_1_iniciacion;
        $desteteS_solicitada[$desteteS->id]['semana_2_iniciacion'] = $desteteS->semana_2_iniciacion;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_2_iniciacion'] = $desteteS->consumo_semana_2_iniciacion;
        $desteteS_solicitada[$desteteS->id]['semana_1_levante'] = $desteteS->semana_1_levante;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_1_levante'] = $desteteS->consumo_semana_1_levante;
        $desteteS_solicitada[$desteteS->id]['semana_2_levante'] = $desteteS->semana_2_levante;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_2_levante'] = $desteteS->consumo_semana_2_levante;
        $desteteS_solicitada[$desteteS->id]['semana_3_levante'] = $desteteS->semana_3_levante;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_3_levante'] = $desteteS->consumo_semana_3_levante;
        $desteteS_solicitada[$desteteS->id]['semana_4_levante'] = $desteteS->semana_4_levante;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_4_levante'] = $desteteS->consumo_semana_4_levante;
        $desteteS_solicitada[$desteteS->id]['semana_1_engorde_1'] = $desteteS->semana_1_engorde_1;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_1_engorde_1'] = $desteteS->consumo_semana_1_engorde_1;
        $desteteS_solicitada[$desteteS->id]['semana_2_engorde_1'] = $desteteS->semana_2_engorde_1;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_2_engorde_1'] = $desteteS->consumo_semana_2_engorde_1;
        $desteteS_solicitada[$desteteS->id]['semana_1_engorde_2'] = $desteteS->semana_1_engorde_2;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_1_engorde_2'] = $desteteS->consumo_semana_1_engorde_2;
        $desteteS_solicitada[$desteteS->id]['semana_2_engorde_2'] = $desteteS->semana_2_engorde_2;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_2_engorde_2'] = $desteteS->consumo_semana_2_engorde_2;
        $desteteS_solicitada[$desteteS->id]['semana_3_engorde_2'] = $desteteS->semana_3_engorde_2;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_3_engorde_2'] = $desteteS->consumo_semana_3_engorde_2;
        $desteteS_solicitada[$desteteS->id]['semana_4_engorde_2'] = $desteteS->semana_4_engorde_2;
        $desteteS_solicitada[$desteteS->id]['consumo_semana_4_engorde_2'] = $desteteS->consumo_semana_4_engorde_2;

        $pdfPedido = PDF::loadView('admin.pdf.format_pdf_destetos_semana', ['desteteS_solicitada' => $desteteS_solicitada, 'granja' => $granja, 'lote' => $lote]);  
        return $pdfPedido->download('Destete Semana '. $desteteS->id .'.pdf');
    }

    /**
    * permite descargar un archivo desde la vista consultar_pedido_medicamentos.blade.php
    * la informacion de ese dato seleccionado 
    * 
    * @var Granja
    * @var PedidoMedicamento
    * @var PedidoInsumoServicio
    * @var Medicamento
    * @var InsumoServicio
    * @param int $cons
    * @return $pdfPedido->download('PME'.$cons.'.pdf');
    */

    public function pdfMedicamentos($cons)
    { 
        $granjas = Granja::all();
        $productos_solicitados = PedidoMedicamento::all();
        $productos_insumos = PedidoInsumoServicio::all();
        $medicamentos = Medicamento::all();
        $insumos = InsumoServicios::all();
        $cont = 0;

        foreach ($productos_solicitados as $producto)
        {
            if($producto->consecutivo_pedido == $cons)
            {
                $fecha_p = $producto->fecha_pedido;
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
                    }
                }
                $cont = 1; 
            }
        }

        foreach ($productos_insumos as $producto_insumo)
        {
            if($producto_insumo->consecutivo_pedido == $cons)
            {
                $fecha_p = $producto_insumo->fecha_pedido;
                foreach ($granjas as $granja) 
                {
                    if ($producto_insumo->granja_id == $granja->id) 
                    {
                        $granja_pedido = $granja->nombre_granja;
                    }
                }
                foreach ($insumos as $insumo) 
                {
                    if($producto_insumo->insumo_servicio_id == $insumo->id) 
                    {
                        $insumos_solicitados[$insumo->id]['codigo'] = $insumo->ref_insumo;
                        $insumos_solicitados[$insumo->id]['nombre'] = $insumo->nombre_insumo;
                        $insumos_solicitados[$insumo->id]['cantidad'] = $producto_insumo->unidades;
                    }
                } 
                $cont = 2;
            }   
        }
        
        if($cont == 1)
        {
            $pdfPedido = PDF::loadView('admin.pdf.format_pdf_pedido_medicamentos', ['medicamentos_solicitados' => $medicamentos_solicitados, 'granja_pedido' => $granja_pedido, 'cons' => $cons, 'fecha_p' => $fecha_p]);  
            return $pdfPedido->download('PME'.$cons.'.pdf');  
        }
        elseif($cont == 2)
        {
            $pdfPedido = PDF::loadView('admin.pdf.format_pdf_pedido_insumos', ['insumos_solicitados' => $insumos_solicitados, 'granja_pedido' => $granja_pedido, 'cons' => $cons, 'fecha_p' => $fecha_p]);  
            return $pdfPedido->download('PME'.$cons.'.pdf'); 
        }
    }    
    
    /**
    * permite crear un archivo PDF desde la vista consultar_pedido_concentrados.blade.php
    * la informacion del dato seleccionado 
    *
    * @var Granja
    * @var PedidoConcentrado
    * @var Concentrado
    * @param int $cons
    * @return $pdfPedido->download('PCO'.$cons.'.pdf')
    */

    public function pdfConcentrados($cons)
    {
        $granjas = Granja::all();
        $productos_solicitados = PedidoConcentrado::all();
        $concentrados = Concentrado::all();

        foreach ($productos_solicitados as $producto)
        {
            if($producto->consecutivo_pedido == $cons)
            {
                $fecha_e = $producto->fecha_entrega;
                $fecha_p = $producto->fecha_creacion;
                foreach ($granjas as $granja) 
                {
                    if ($producto->granja_id == $granja->id) 
                    {
                        $granja_pedido = $granja->nombre_granja;
                    }
                }
                foreach ($concentrados as $concentrado) 
                {
                    $hora_e = $producto->hora_entrega;
                    if($producto->concentrado_id == $concentrado->id) 
                    {
                        $concentrados_solicitados[$concentrado->id]['codigo'] = $concentrado->ref_concentrado;
                        $concentrados_solicitados[$concentrado->id]['nombre'] = $concentrado->nombre_concentrado;
                        $concentrados_solicitados[$concentrado->id]['bultos'] = $producto->no_bultos;
                        $concentrados_solicitados[$concentrado->id]['kilos'] = $producto->no_kilos;
                    }
                }
            }
        } 
        
        $pdfPedido = PDF::loadView('admin.pdf.format_pedido_concentrados', ['concentrados_solicitados' => $concentrados_solicitados, 'granja_pedido' => $granja_pedido, 'cons' => $cons, 'fecha_p' => $fecha_p, 'fecha_e' => $fecha_e]);  
        return $pdfPedido->download('PCO'.$cons.'.pdf');    
    }

    /**
    * permite descargar un archivo PDF desde la vista consultar_pedidos_cia.blade.php
    * la informacion del dato seleccionado 
    *
    * @var Granja 
    * @var PedidoCia
    * @var ProductoCia
    * @param int $cons
    * @return $pdfPedido->download('PSE'.$cons.'.pdf');
    */

    public function pdfCia($cons)
    { 
        $granjas = Granja::all();
        $productos_solicitados = PedidoCia::all();
        $productos_cia = ProductoCia::all();

        foreach ($productos_solicitados as $producto)
        {
            if($producto->consecutivo_pedido == $cons)
            {
                $fecha_e = $producto->fecha_entrega;
                $fecha_p = $producto->fecha_pedido; 
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
                    }
                }
            }
        } 
        
        $pdfPedido = PDF::loadView('admin.pdf.format_pdf_pedido_cia', ['productos_cia_solicitados' => $productos_cia_solicitados, 'granja_pedido' => $granja_pedido, 'cons' => $cons, 'fecha_p' => $fecha_p]);  
        return $pdfPedido->download('PSE'.$cons.'.pdf');    
    } 
}
