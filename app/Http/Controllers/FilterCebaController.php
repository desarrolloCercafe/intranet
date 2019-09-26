<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth; 
use App\Ceba;
use App\Granja;
use App\AsociacionGranja;
use App\Http\Requests;

class FilterCebaController extends Controller
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
     * permite hacer una consulta a la base de datos para poder filtrar los datos que se ingresan desde la vista 
     * list_cebas.blade.php
     *
     * @var AsociacionGranja 
     * @var Granja
     * @var Ceba
     * @param  \Illuminate\Http\Request  $request
     * @return view/admnin/filtro/filtro_ceba.blade.php compact $granja_filtro, $lote_filtro, $fecha_inicial, $fecha_final
     */
    public function store(Request $request)
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $cebas = Ceba::all();

        if ($request->granja != null) 
        {
            $granja_filtro = $request->granja;
            $lote_filtro = $request->lote;
            if ($request->lote != null)
            { 
                $fecha_inicial = '+';
                $fecha_final = '+';
                if ($request->fecha_desde_ceba != null && $request->fecha_hasta_ceba != null) {
                    $fecha_inicial = $request->fecha_desde_ceba;
                    $fecha_final = $request->fecha_hasta_ceba;
                    $fechas = Ceba::whereBetween('fecha_salida_lote',[$request->fecha_desde_ceba, $request->fecha_hasta_ceba] )->get();
                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if($request->granja == $fecha->granja_id) 
                            {
                                if($request->lote == $fecha->lote)
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                                            $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                            $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                            $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                            $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                            $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;   
                                        }
                                    }
                                } 
                            } 
                        }    
                    }
                    else
                    {
                        foreach ($fechas as $fecha) 
                        {
                            if($request->granja == $fecha->granja_id) 
                            {

                                if($request->lote == $fecha->lote){
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($fecha->granja_id == $granja->id) 
                                        {
                                            $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                                            $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                            $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                            $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                            $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                            $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;  
                                        }
                                    }
                                } 
                            } 
                        }    
                    }
                }
                else
                {
                    foreach ($cebas as $ceba) 
                    {
                        if ($ceba->granja_id == $request->granja) 
                        {
                            if ($ceba->lote == $request->lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $ceba->granja_id) 
                                    {
                                        $cebas_db[$ceba->id]["id_ceba"] = $ceba->id; 
                                        $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                        $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                        $cebas_db[$ceba->id]["fecha_inicial"] = $ceba->fecha_ingreso_lote;
                                        $cebas_db[$ceba->id]["fecha_final"] = $ceba->fecha_salida_lote;
                                        $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                        $cebas_db[$ceba->id]["consumo_total"] = $ceba->consumo_lote;
                                    }
                                }
                            }
                        }   
                    }
                }
                if ( !empty($cebas_db) && is_array($cebas_db))
                {
                    
                    return view('admin.filtros.filtro_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial', 'fecha_final'))->with('cebas_db', $cebas_db);
                }
                else
                {
                    flash('<strong>No existen registros asociados al Rango de fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.cebas.index');
                }  
            }
            else
            {
                if ($request->fecha_desde_ceba != null && $request->fecha_hasta_ceba != null) {
                    $lote_filtro = '0';   
                    $fecha_inicial = $request->fecha_desde_ceba;
                    $fecha_final = $request->fecha_hasta_ceba;
                    $fechas = Ceba::whereBetween('fecha_salida_lote',[$request->fecha_desde_ceba, $request->fecha_hasta_ceba] )->get();
                    if (Auth::User()->rol_id != 7) 
                    {
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($fecha->granja_id == $granja->id) {
                                        $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                                        $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                        $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                        $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                        $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                        $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                    }
                                }
                            }
                        }
                    }else{
                        foreach ($fechas as $fecha) {
                            if ($request->granja == $fecha->granja_id) {
                                foreach ($granjas as $granja) {
                                    if ($fecha->granja_id == $granja->id) {
                                        $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                                        $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                        $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                        $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                        $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                        $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $fecha_inicial = '+';
                    $fecha_final = '+';
                    $lote_filtro = '0';
                    foreach ($cebas as $ceba) 
                    {
                        if ($ceba->granja_id == $request->granja) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $ceba->granja_id) 
                                {
                                    $cebas_db[$ceba->id]["id_ceba"] = $ceba->id; 
                                    $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                    $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                    $cebas_db[$ceba->id]["fecha_inicial"] = $ceba->fecha_ingreso_lote;
                                    $cebas_db[$ceba->id]["fecha_final"] = $ceba->fecha_salida_lote;
                                    $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                    $cebas_db[$ceba->id]["consumo_total"] = $ceba->consumo_lote;
                                }
                            } 
                        }   
                    } 
                }
                if ( !empty($cebas_db) && is_array($cebas_db))
                {
                    return view('admin.filtros.filtro_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial', 'fecha_final'))->with('cebas_db', $cebas_db);
                }
                else
                {
                    flash('<strong>No existen registros asociados al Rango de Fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.cebas.index');
                }
            }
            if ( !empty($cebas_db) && is_array($cebas_db))
            {
                
                return view('admin.filtros.filtro_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial', 'fecha_final'))->with('cebas_db', $cebas_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.cebas.index');
            } 
        }
        elseif($request->lote != null)
        {
            $granja_filtro = '0';
            $lote_filtro = $request->lote;
            $fecha_inicial = '+';
            $fecha_final = '+';
            if ($request->fecha_desde_ceba != null && $request->fecha_hasta_ceba != null) {
                $fecha_inicial = $request->fecha_desde_ceba;
                $fecha_final = $request->fecha_hasta_ceba;
                $fechas = Ceba::whereBetween('fecha_salida_lote',[$request->fecha_desde_ceba, $request->fecha_hasta_ceba] )->get();
                if (Auth::User()->rol_id != 7) {
                    foreach ($fechas as $fecha) {
                        if ($request->lote == $fecha->lote) {
                            foreach ($g_as as $g) {
                                if ($g->user_id == Auth::User()->id) {
                                    if ($fecha->granja_id == $g->granja_id) {
                                        foreach ($granjas as $granja) {
                                            if ($fecha->granja_id == $granja->id) {
                                                $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                                                $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                                $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                                $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                                $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                                $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
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
                                    $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                                    $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                    $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                    $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                    $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                    $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                    $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                if (Auth::User()->rol_id != 7) {
                    foreach ($cebas as $ceba) 
                    {
                        if ($ceba->lote == $request->lote) 
                        {
                            foreach ($g_as as $g) {
                                if ($g->user_id == Auth::User()->id) {
                                    if ($ceba->granja_id == $g->granja_id) {
                                        foreach ($granjas as $granja) 
                                        {
                                            if ($granja->id == $ceba->granja_id) 
                                            {   
                                                $cebas_db[$ceba->id]["id_ceba"] = $ceba->id; 
                                                $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                                $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                                $cebas_db[$ceba->id]["fecha_inicial"] = $ceba->fecha_ingreso_lote;
                                                $cebas_db[$ceba->id]["fecha_final"] = $ceba->fecha_salida_lote;
                                                $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                                $cebas_db[$ceba->id]["consumo_total"] = $ceba->consumo_lote;
                                            }
                                        }
                                    }
                                }
                            }
                        } 
                    }
                }else{
                    foreach ($cebas as $ceba) 
                    {
                        if ($ceba->lote == $request->lote) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $ceba->granja_id) 
                                {   
                                    $cebas_db[$ceba->id]["id_ceba"] = $ceba->id; 
                                    $cebas_db[$ceba->id]["lote"] = $ceba->lote;
                                    $cebas_db[$ceba->id]["granja"] = $granja->nombre_granja;
                                    $cebas_db[$ceba->id]["fecha_inicial"] = $ceba->fecha_ingreso_lote;
                                    $cebas_db[$ceba->id]["fecha_final"] = $ceba->fecha_salida_lote;
                                    $cebas_db[$ceba->id]["inic"] = $ceba->inic;
                                    $cebas_db[$ceba->id]["consumo_total"] = $ceba->consumo_lote;
                                }
                            }          
                        } 
                    }
                }
            }
            if ( !empty($cebas_db) && is_array($cebas_db))
            {
                return view('admin.filtros.filtro_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial', 'fecha_final'))->with('cebas_db', $cebas_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote o Rango de Fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.cebas.index');
            } 
        }elseif ($request->fecha_desde_ceba != null && $request->fecha_hasta_ceba != null) {
            $lote_filtro = '0';
            $granja_filtro = '0';
            $fecha_inicial = $request->fecha_desde_ceba;
            $fecha_final = $request->fecha_hasta_ceba;
            $fechas = Ceba::whereBetween('fecha_salida_lote',[$request->fecha_desde_ceba, $request->fecha_hasta_ceba] )->get();
            if (Auth::User()->rol_id != 7) {
                foreach ($g_as as $g) {
                    if ($g->user_id == Auth::User()->id) {
                        foreach ($fechas as $fecha) 
                        {
                            if($g->granja_id == $fecha->granja_id){
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $fecha->granja_id) 
                                    {
                                        $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                                        $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                                        $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                                        $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                                        $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                                        $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;  
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                foreach ($fechas as $fecha) 
                {
                    foreach ($granjas as $granja) 
                    {
                        if ($granja->id == $fecha->granja_id) 
                        {
                            $cebas_db[$fecha->id]["id_ceba"] = $fecha->id; 
                            $cebas_db[$fecha->id]["lote"] = $fecha->lote;
                            $cebas_db[$fecha->id]["granja"] = $granja->nombre_granja;
                            $cebas_db[$fecha->id]["fecha_inicial"] = $fecha->fecha_ingreso_lote;
                            $cebas_db[$fecha->id]["fecha_final"] = $fecha->fecha_salida_lote;
                            $cebas_db[$fecha->id]["inic"] = $fecha->inic;
                            $cebas_db[$fecha->id]["consumo_total"] = $fecha->consumo_lote;  
                        }
                    }
                }
            }
            if ( !empty($cebas_db) && is_array($cebas_db))
            {
                return view('admin.filtros.filtro_ceba', compact('granja_filtro', 'lote_filtro','fecha_inicial', 'fecha_final'))->with('cebas_db', $cebas_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al Rango de Fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.cebas.index');
            }
        }
        else
        {
            flash('<strong>No hay datos Insertados!!!</strong>')->error()->important();
            return redirect()->route('admin.cebas.index');
        }
    }


    /**
     * permite acceder a la vista tabla_ceba.blade.php el registro que fue seleccionado
     * en la vista list_cebas.blade.php
     *
     * @var Ceba
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_ceba.blade.php compact $granja with $ceba
     */
    public function show($id)
    {
        $ceba_c = Ceba::find($id);
        $granja = Granja::find($ceba_c->granja_id);
        return view('admin.granjas.tabla_ceba', compact('granja', $granja))->with('ceba_c', $ceba_c);
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