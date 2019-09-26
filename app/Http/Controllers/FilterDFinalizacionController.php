<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\DesteteFinalizacion;
use App\Granja;
use App\AsociacionGranja;
use App\Http\Requests;

class FilterDFinalizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * permite realizar una consulta desde la vista list_destete_finalizacion.blade.php
     * de acuerdo a los parametros que se le envien
     *
     * @var AsociacionGranja
     * @var Granja
     * @var DesteteFinalizacion
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/filtro_destete_finalizacion.blade.php compact 
     * $granja_filtro, $lote_fitro with $destetesF_db
     */
    public function store(Request $request)
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $destetesF = DesteteFinalizacion::all();

        if ($request->granja != null) 
        {
            $granja_filtro = $request->granja;
            $lote_filtro = $request->lote;
            if ($request->lote != null) 
            {
                $fecha_inicial = '+';
                $fecha_final = '+';
                if ($request->fecha_desde_finalizacion != null && $request->fecha_hasta_finalizacion != null) {
                    $fecha_inicial = $request->fecha_desde_finalizacion;
                    $fecha_final = $request->fecha_hasta_finalizacion;
                    $fechas = DesteteFinalizacion::whereBetween('fecha_salida_lote',[$request->fecha_desde_finalizacion, $request->fecha_hasta_finalizacion] )->get();
                    if (Auth::User()->rol_id != 7) {
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                if ($request->lote == $fecha->lote) {
                                    foreach ($granjas as $granja) {
                                        if ($fecha->granja_id == $granja->id) {
                                            $destetesF_db[$fecha->id]["id"] = $fecha->id;
                                            $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                                            $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                            $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                            $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                                            $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                if ($request->lote == $fecha->lote) {
                                    foreach ($granjas as $granja) {
                                        if ($fecha->granja_id == $granja->id) {
                                            $destetesF_db[$fecha->id]["id"] = $fecha->id;
                                            $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                                            $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                            $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                            $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                                            $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    foreach ($destetesF as $desteteF) 
                    {
                        if ($desteteF->granja_id == $request->granja) 
                        {
                            if ($desteteF->lote == $request->lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $desteteF->granja_id) 
                                    {
                                        $destetesF_db[$desteteF->id]["id"] = $desteteF->id;
                                        $destetesF_db[$desteteF->id]["lote"] = $desteteF->lote;
                                        $destetesF_db[$desteteF->id]["granja"] = $granja->nombre_granja;
                                        $destetesF_db[$desteteF->id]["fecha_inicial"] = $desteteF->fecha_ingreso_lote;
                                        $destetesF_db[$desteteF->id]["fecha_final"] = $desteteF->fecha_salida_lote;
                                        $destetesF_db[$desteteF->id]["inic"] = $desteteF->inic;
                                        $destetesF_db[$desteteF->id]["consumo_total"] = $desteteF->consumo_lote;
                                    }
                                }
                            }
                        }   
                    }
                }
                if ( !empty($destetesF_db) && is_array($destetesF_db))
                {
                    
                    return view('admin.filtros.filtro_destete_finalizacion', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('destetesF_db', $destetesF_db);
                }
                else
                {
                    flash('<strong>No existen registros asociados al Rango de Fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.desteteFinalizacion.index');
                }   
            }
            else
            {
                if ($request->fecha_desde_finalizacion != null && $request->fecha_hasta_finalizacion != null) {
                    $fecha_inicial = $request->fecha_desde_finalizacion;
                    $fecha_final = $request->fecha_hasta_finalizacion;
                    $fechas = DesteteFinalizacion::whereBetween('fecha_salida_lote',[$request->fecha_desde_finalizacion, $request->fecha_hasta_finalizacion] )->get();
                    $lote_filtro = '0';
                    if (Auth::User()->rol_id != 7) {
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($fecha->granja_id == $granja->id) {
                                        $destetesF_db[$fecha->id]["id"] = $fecha->id;
                                        $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                                        $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                        $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                        $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                                        $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                    }
                                }
                            }
                        }
                    }else{
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($fecha->granja_id == $granja->id) {
                                        $destetesF_db[$fecha->id]["id"] = $fecha->id;
                                        $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                                        $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                        $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                        $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                                        $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    $fecha_inicial = '+';
                    $fecha_final = '+';
                    $lote_filtro = '0';
                    foreach ($destetesF as $desteteF) 
                    {
                        if ($desteteF->granja_id == $request->granja) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $desteteF->granja_id) 
                                {
                                    $destetesF_db[$desteteF->id]["id"] = $desteteF->id;
                                    $destetesF_db[$desteteF->id]["lote"] = $desteteF->lote;
                                    $destetesF_db[$desteteF->id]["granja"] = $granja->nombre_granja;
                                    $destetesF_db[$desteteF->id]["fecha_inicial"] = $desteteF->fecha_ingreso_lote;
                                    $destetesF_db[$desteteF->id]["fecha_final"] = $desteteF->fecha_salida_lote;
                                    $destetesF_db[$desteteF->id]["inic"] = $desteteF->inic;
                                    $destetesF_db[$desteteF->id]["consumo_total"] = $desteteF->consumo_lote;
                                }
                            } 
                        }   
                    }
                }
                if ( !empty($destetesF_db) && is_array($destetesF_db))
                {
                    
                    return view('admin.filtros.filtro_destete_finalizacion', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('destetesF_db', $destetesF_db);
                }
                else
                {
                    flash('<strong>No existen registros asociados al Rango de Fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.desteteFinalizacion.index');
                } 
            }
            if ( !empty($destetesF_db) && is_array($destetesF_db))
            {
                
                return view('admin.filtros.filtro_destete_finalizacion', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('destetesF_db', $destetesF_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.desteteFinalizacion.index');
            } 
        }
        elseif($request->lote != null)
        {
            $fecha_inicial = '+';
            $fecha_final = '+';
            $granja_filtro = '0';
            $lote_filtro = $request->lote;
            if ($request->fecha_desde_finalizacion != null && $request->fecha_hasta_finalizacion != null) {
                $fecha_inicial = $request->fecha_desde_finalizacion;
                $fecha_final = $request->fecha_hasta_finalizacion;
                $fechas = DesteteFinalizacion::whereBetween('fecha_salida_lote',[$request->fecha_desde_finalizacion, $request->fecha_hasta_finalizacion] )->get();
                if (Auth::User()->rol_id != 7) {
                    foreach ($fechas as $fecha) {
                        if ($request->lote == $fecha->lote) {
                            foreach ($g_as as $g) {
                                if ($g->user_id == Auth::User()->id) {
                                    if ($fecha->granja_id == $g->granja_id) {
                                        foreach ($granjas as $granja) {
                                            if ($fecha->granja_id == $granja->id) {
                                                $destetesF_db[$fecha->id]["id"] = $fecha->id;
                                                $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                                                $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                                $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                                $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                                                $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    foreach ($fechas as $fecha) {
                        if ($request->lote == $fecha->lote) {
                            foreach ($granjas as $granja) {
                                if ($fecha->granja_id == $granja->id) {
                                    $destetesF_db[$fecha->id]["id"] = $fecha->id;
                                    $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                                    $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                    $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                    $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                    $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                                    $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                $fecha_inicial = '+';
                $fecha_final = '+';
                if (Auth::User()->rol_id != 7) {
                    foreach ($destetesF as $desteteF) 
                    {
                        if ($desteteF->lote == $request->lote) 
                        {
                            foreach ($g_as as $g) {
                                if ($g->user_id == Auth::User()->id) {
                                    if ($desteteF->granja_id == $g->granja_id) {
                                        foreach ($granjas as $granja) 
                                        {
                                            if ($granja->id == $desteteF->granja_id) 
                                            {
                                                $destetesF_db[$desteteF->id]["id"] = $desteteF->id;
                                                $destetesF_db[$desteteF->id]["lote"] = $desteteF->lote;
                                                $destetesF_db[$desteteF->id]["granja"] = $granja->nombre_granja;
                                                $destetesF_db[$desteteF->id]["fecha_inicial"] = $desteteF->fecha_ingreso_lote;
                                                $destetesF_db[$desteteF->id]["fecha_final"] = $desteteF->fecha_salida_lote;
                                                $destetesF_db[$desteteF->id]["inic"] = $desteteF->inic;
                                                $destetesF_db[$desteteF->id]["consumo_total"] = $desteteF->consumo_lote;
                                            }
                                        }
                                    }
                                }
                            }
                        }    
                    }
                }else{
                    foreach ($destetesF as $desteteF) 
                    {
                        if ($desteteF->lote == $request->lote) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $desteteF->granja_id) 
                                {
                                    $destetesF_db[$desteteF->id]["id"] = $desteteF->id;
                                    $destetesF_db[$desteteF->id]["lote"] = $desteteF->lote;
                                    $destetesF_db[$desteteF->id]["granja"] = $granja->nombre_granja;
                                    $destetesF_db[$desteteF->id]["fecha_inicial"] = $desteteF->fecha_ingreso_lote;
                                    $destetesF_db[$desteteF->id]["fecha_final"] = $desteteF->fecha_salida_lote;
                                    $destetesF_db[$desteteF->id]["inic"] = $desteteF->inic;
                                    $destetesF_db[$desteteF->id]["consumo_total"] = $desteteF->consumo_lote;
                                }
                            }
                        }    
                    }
                }
            } 
            if ( !empty($destetesF_db) && is_array($destetesF_db))
            {
                
                return view('admin.filtros.filtro_destete_finalizacion', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('destetesF_db', $destetesF_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote Y/o rango de Fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.desteteFinalizacion.index');
            } 
        }elseif ($request->fecha_desde_finalizacion != null && $request->fecha_hasta_finalizacion != null){
            $fecha_inicial = $request->fecha_desde_finalizacion;
            $fecha_final = $request->fecha_hasta_finalizacion;
            $fechas = DesteteFinalizacion::whereBetween('fecha_ingreso_lote',[$request->fecha_desde_finalizacion, $request->fecha_hasta_finalizacion] )->get();
            $granja_filtro = '0';
            $lote_filtro = '0';
            if (Auth::User()->rol_id != 7) {
                foreach ($g_as as $g) {
                    if ($g->user_id == Auth::User()->id) {
                        foreach ($fechas as $fecha) {
                            if ($g->granja_id == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($granja->id == $fecha->granja_id) {
                                        $destetesF_db[$fecha->id]["id"] = $fecha->id;
                                        $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                                        $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                        $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                        $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                                        $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                foreach ($fechas as $fecha) {
                    foreach ($granjas as $granja) {
                        if ($granja->id == $fecha->granja_id) {
                            $destetesF_db[$fecha->id]["id"] = $fecha->id;
                            $destetesF_db[$fecha->id]["lote"] = $fecha->lote;
                            $destetesF_db[$fecha->id]["granja"] = $granja->nombre_granja;
                            $destetesF_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                            $destetesF_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                            $destetesF_db[$fecha->id]["inic"] = $fecha->inic;
                            $destetesF_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                        }
                    }
                }
            }
            if ( !empty($destetesF_db) && is_array($destetesF_db))
            {
                
                return view('admin.filtros.filtro_destete_finalizacion', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('destetesF_db', $destetesF_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote Y/o rango de Fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.desteteFinalizacion.index');
            } 
        }else{
            flash('<strong>No hay datos de Busqueda!!!</strong>')->error()->important();
            return redirect()->route('admin.desteteFinalizacion.index');
        }
    }

    /**
     * permite visualizar el registro seleccionado desde la vista
     * list_destete_finalizacion.blade.php a la vista
     * tabla_destete_finalizacion.blade.php
     *
     * @var DesteteFinalizacion 
     * @var Granja 
     * @param  int  $id
     * @return view/admin/granjas/tabla_destete_finalizacion compact $granja with $destete_f
     */
    public function show($id)
    {
        $destete_f = DesteteFinalizacion::find($id);
        $granja = Granja::find($destete_f->granja_id);
        return view('admin.granjas.tabla_destete_finalizacion', compact('granja', $granja))->with('destete_f', $destete_f);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
