<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Alimento;
use App\ReporteMortalidadPreceboCeba;
use App\Granja;
use App\AsociacionGranja;
use App\Http\Requests;
use App\CausaMuerte;

class FilterMortalidadPreceboCebaController extends Controller
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
     * permite realizar una consulta que se envia desde la vista 
     * list_reporte_mortalidad_precebo_ceba.blade.php
     * los parametros que se envian de aquella vista 
     *
     * @var AsociacionGranja
     * @var Granja
     * @var ReporteMortalidadPreceboCeba
     * @var CausaMuerte 
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/filtro_mortalidad_precebo_ceba.blade.php 
     * compact $granja_filtro, $lote_filtro, $fecha_inicial, $fecha_final with $reportes_db
     */
    public function store(Request $request)
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $reportes = ReporteMortalidadPreceboCeba::all();
        $causas = CausaMuerte::all();

        if ($request->granja != null) 
        {
            $granja_filtro = $request->granja; 
            $lote_filtro = $request->lote;
            if ($request->lote != null)
            {
                $fecha_inicial = '+';
                $fecha_final = '+';
                if ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) {
                    $fecha_inicial = $request->fecha_desde_precebo;
                    $fecha_final = $request->fecha_hasta_precebo;
                    $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
                    if (Auth::User()->rol_id != 7) {
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id){
                                if ($request->lote == $fecha->lote) {
                                    foreach ($granjas as $granja) {
                                        if ($fecha->granja_id == $granja->id) {
                                            foreach ($causas as $causa) {
                                                if ($fecha->causa_id == $causa->id) {
                                                    $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                                    $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                    $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                    $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                    $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                                    $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id){
                                if ($request->lote == $fecha->lote) {
                                    foreach ($granjas as $granja) {
                                        if ($fecha->granja_id == $granja->id) {
                                            foreach ($causas as $causa) {
                                                if ($fecha->causa_id == $causa->id) {
                                                    $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                                    $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                    $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                    $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                    $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                                    $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                }
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
                    foreach ($reportes as $reporte) 
                    {
                        if ($reporte->granja_id == $request->granja) 
                        {
                            if ($reporte->lote == $request->lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $reporte->granja_id) 
                                    {
                                        foreach ($causas as $causa) 
                                        {
                                            if ($reporte->causa_id == $causa->id) 
                                            {
                                                $reportes_db[$reporte->id]["id_mortalidad"] = $reporte->id;
                                                $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                                $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                                $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                                $reportes_db[$reporte->id]["sexo"] = $reporte->sexo_cerdo;
                                                $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                            }
                                        }
                                    }
                                }
                            }
                        }   
                    }
                } 
                if ( !empty($reportes_db) && is_array($reportes_db))
                {
                    
                    return view('admin.filtros.filtro_mortalidad_precebo_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('reportes_db', $reportes_db);
                }
                else
                {
                    flash('<strong>No existen registros asociados al rango de Fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.reporteMortalidad.index');
                }   
            }
            else
            {
                if ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) {
                    $fecha_inicial = $request->fecha_desde_precebo;
                    $fecha_final = $request->fecha_hasta_precebo;
                    $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
                    $lote_filtro = '*';
                    if (Auth::User()->rol_id !=7) {
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($fecha->granja_id == $granja->id) {
                                        foreach ($causas as $causa) {
                                           if ($fecha->causa_id == $causa->id) {
                                                $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                                $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                                $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($fecha->granja_id == $granja->id) {
                                        foreach ($causas as $causa) {
                                           if ($fecha->causa_id == $causa->id) {
                                                $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                                $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                                $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ( !empty($reportes_db) && is_array($reportes_db))
                    {
                        
                        return view('admin.filtros.filtro_mortalidad_precebo_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('reportes_db', $reportes_db);
                    }
                    else
                    {
                        flash('<strong>No existen registros asociados al rango de Fecha solicitado!!!</strong>')->error()->important();
                        return redirect()->route('admin.reporteMortalidad.index');
                    }
                }
                else
                {
                    $fecha_inicial = '+';
                    $fecha_final = '+';
                    $lote_filtro = '*';
                    foreach ($reportes as $reporte)  
                    {
                        if ($reporte->granja_id == $request->granja) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $reporte->granja_id) 
                                {
                                    foreach ($causas as $causa) 
                                    {
                                        if ($reporte->causa_id == $causa->id) 
                                        {
                                            $reportes_db[$reporte->id]["id_mortalidad"] = $reporte->id;
                                            $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                            $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                            $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                            $reportes_db[$reporte->id]["sexo"] = $reporte->sexo_cerdo;
                                            $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                        }
                                    }
                                }
                            } 
                        }   
                    } 
                }
            } 

            if ( !empty($reportes_db) && is_array($reportes_db))
            {
                
                return view('admin.filtros.filtro_mortalidad_precebo_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('reportes_db', $reportes_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.reporteMortalidad.index');
            } 
        }
        elseif($request->lote != null)
        {
            $granja_filtro = '0';
            $lote_filtro = $request->lote;
            $fecha_inicial = '+';
            $fecha_final = '+';
            if ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) {
                $fecha_inicial = $request->fecha_desde_precebo;
                $fecha_final = $request->fecha_hasta_precebo;
                $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
                if (Auth::User()->rol_id != 7) {
                    foreach ($fechas as $fecha) {
                        if ($request->lote == $fecha->lote) {
                            foreach ($g_as as $g) {
                                if ($g->user_id == Auth::User()->id) {
                                    if ($fecha->granja_id == $g->granja_id) {
                                        foreach ($granjas as $granja) {
                                            if ($fecha->granja_id == $granja->id) {
                                                foreach ($causas as $causa) {
                                                    if ($fecha->causa_id == $causa->id) {
                                                        $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                                        $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                        $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                        $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                        $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                                        $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else{
                    foreach ($fechas as $fecha) {
                        if ($request->lote == $fecha->lote) {
                            foreach ($granjas as $granja) {
                                if ($fecha->granja_id == $granja->id) {
                                    foreach ($causas as $causa) {
                                        if ($fecha->causa_id == $causa->id) {
                                            $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                            $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                            $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                            $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                            $reportes_db[$fecha->id]["causa"] = $causa->causa;
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
                if (Auth::User()->rol_id != 7) {
                    foreach ($reportes as $reporte) 
                    {
                        if ($reporte->lote == $request->lote) 
                        {
                            foreach ($g_as as $g) {
                                if ($g->user_id == Auth::User()->id) {
                                    if ($reporte->granja_id == $g->granja_id) {
                                        foreach ($granjas as $granja) 
                                        {
                                            if ($granja->id == $reporte->granja_id) 
                                            {
                                                foreach ($causas as $causa) 
                                                {
                                                    if ($reporte->causa_id == $causa->id) 
                                                    {
                                                        $reportes_db[$reporte->id]["id_mortalidad"] = $reporte->id;
                                                        $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                                        $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                                        $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                                        $reportes_db[$reporte->id]["sexo"] = $reporte->sexo_cerdo;
                                                        $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                                    }
                                                }
                                            }
                                        } 
                                    }
                                }
                            }
                        }   
                    }
                }else{
                    foreach ($reportes as $reporte) 
                    {
                        if ($reporte->lote == $request->lote) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $reporte->granja_id) 
                                {
                                    foreach ($causas as $causa) 
                                    {
                                        if ($reporte->causa_id == $causa->id) 
                                        {
                                            $reportes_db[$reporte->id]["id_mortalidad"] = $reporte->id;
                                            $reportes_db[$reporte->id]["lote"] = $reporte->lote;
                                            $reportes_db[$reporte->id]["granja"] = $granja->nombre_granja;
                                            $reportes_db[$reporte->id]["fecha"] = $reporte->fecha;
                                            $reportes_db[$reporte->id]["sexo"] = $reporte->sexo_cerdo;
                                            $reportes_db[$reporte->id]["causa"] = $causa->causa;
                                        }
                                    }
                                }
                            } 
                        }   
                    }
                }
            } 
            if ( !empty($reportes_db) && is_array($reportes_db))
            {
                
                return view('admin.filtros.filtro_mortalidad_precebo_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('reportes_db', $reportes_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.reporteMortalidad.index');
            }   
        }elseif ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) {
            $granja_filtro = '0';
            $lote_filtro = '*';
            $fecha_inicial = $request->fecha_desde_precebo;
            $fecha_final = $request->fecha_hasta_precebo;
            $fechas = ReporteMortalidadPreceboCeba::whereBetween('fecha',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
            if (Auth::User()->rol_id != 7) {
                foreach ($g_as as $g) {
                    if ($g->user_id == Auth::User()->id) {
                        foreach ($fechas as $fecha) {
                            if ($g->granja_id == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($fecha->granja_id == $granja->id) {
                                        foreach ($causas as $causa) {
                                            if ($fecha->causa_id == $causa->id) {
                                                $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                                $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                                $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                                $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                                $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                foreach ($fechas as $fecha) {
                    foreach ($granjas as $granja) {
                        if ($fecha->granja_id == $granja->id) {
                            foreach ($causas as $causa) {
                                if ($fecha->causa_id == $causa->id) {
                                    $reportes_db[$fecha->id]["id_mortalidad"] = $fecha->id;
                                    $reportes_db[$fecha->id]["lote"] = $fecha->lote;
                                    $reportes_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                    $reportes_db[$fecha->id]["fecha"] = $fecha->fecha;
                                    $reportes_db[$fecha->id]["sexo"] = $fecha->sexo_cerdo;
                                    $reportes_db[$fecha->id]["causa"] = $causa->causa;
                                }
                            }
                        }
                    }
                }
            }
            if ( !empty($reportes_db) && is_array($reportes_db))
            {
                
                return view('admin.filtros.filtro_mortalidad_precebo_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('reportes_db', $reportes_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al Rango de Fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.reporteMortalidad.index');
            } 
        }
        else
        {
            flash('<strong>Ingresa datos de Busqueda!!!</strong>')->error()->important();
            return redirect()->route('admin.reporteMortalidad.index');
        }
    }

    /**
     * Permite mostrar la informacion de un lote que fue seleccionado en
     * list_reporte_mortalidad_precebo_ceba.blade.php
     *
     * @var ReporteMortalidadPreceboCeba
     * @var CausaMuerte
     * @var Alimento
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_mortalidad.blade.php compact $granja, $nombre_muerte, 
     * $alimento with $mortalidad
     */
    public function show($id)
    {
        $mortalidad = ReporteMortalidadPreceboCeba::find($id);
        $nombre_muerte = CausaMuerte::find($mortalidad->causa_id);
        $alimento = Alimento::find($mortalidad->alimento_id);
        $granja = Granja::find($mortalidad->granja_id);
        return view('admin.granjas.tabla_mortalidad', compact('granja', $granja,'nombre_muerte',$nombre_muerte,'alimento',$alimento))->with('mortalidad', $mortalidad);
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
