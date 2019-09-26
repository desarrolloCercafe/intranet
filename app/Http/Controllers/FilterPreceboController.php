<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Precebo;
use App\Granja;
use App\AsociacionGranja;
use App\Http\Requests;

class FilterPreceboController extends Controller
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
     * permite realizar una consulta desde la vista list_precebos.blade.php hasta la vista
     * filtro_precebos.blade.php donde tendra todos los pedidos de acuerdo a los parametros
     * de busqueda
     *
     * @var AsociacionGranja
     * @var Granja
     * @var Precebo
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/filtro_precebo.blade.php 
     * compact $granja_filtro, $lote_filtro, $fecha_inicial $fecha_final with $precebos_db
     */
    public function store(Request $request)
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $precebos = Precebo::all();
        
        if ($request->granja != null) 
        {
            $granja_filtro = $request->granja;
            $lote_filtro = $request->lote;
            if ($request->lote != null)
            {
                $fecha_inicial = '+';
                $fecha_final = '+';
                if ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) 
                {
                    $fecha_inicial = $request->fecha_desde_precebo;
                    $fecha_final = $request->fecha_hasta_precebo; 
                    $fechas = Precebo::whereBetween('fecha_traslado',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
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
                                            $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                                            $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                            $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                            $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                            $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                            $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;   
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
                                            $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                                            $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                            $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                            $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                            $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                            $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                            $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;   
                                        }
                                    }
                                } 
                            } 
                        }    
                    }
                }
                else
                {
                    foreach ($precebos as $precebo) 
                    {
                        if ($precebo->granja_id == $request->granja) 
                        {
                            if ($precebo->lote == $request->lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $precebo->granja_id) 
                                    {
                                        $precebos_db[$precebo->id]["id_precebo"] = $precebo->id;
                                        $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                        $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                        $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                        $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                        $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                        $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                    }
                                }
                            }
                        }   
                    }
                }
                if (!empty($precebos_db) && is_array($precebos_db)) {
                    return view('admin.filtros.filtro_precebo', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('precebos_db', $precebos_db);
                }else{
                    flash('<strong>No existen registros asociados al Rango de Fecha Seleccionado!!!</strong>')->error()->important();
                    return redirect()->route('admin.precebos.index'); 
                }   
            }
            else
            { 
                if ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) {
                    $fecha_inicial = $request->fecha_desde_precebo;
                    $fecha_final = $request->fecha_hasta_precebo;
                    $fechas = Precebo::whereBetween('fecha_traslado',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
                    $lote_filtro = '*';
                    if (Auth::User()->rol_id != 7) 
                    {    
                        foreach ($fechas as $fecha) 
                        {
                            if($request->granja == $fecha->granja_id) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                                        $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                        $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                        $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                        $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                        $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;   
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
                                foreach ($granjas as $granja) 
                                {
                                    if ($fecha->granja_id == $granja->id) 
                                    {
                                        $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                                        $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                        $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                        $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                        $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                        $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;   
                                    }
                                } 
                            } 
                        }
                    }
                }else
                {
                    $fecha_inicial = '+';
                    $fecha_final = '+';
                    $lote_filtro = '*';
                    foreach ($precebos as $precebo) 
                    {
                        if ($precebo->granja_id == $request->granja) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $precebo->granja_id) 
                                {
                                    $precebos_db[$precebo->id]["id_precebo"] = $precebo->id;
                                    $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                    $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                    $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                    $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                    $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                    $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                }
                            }
                        }   
                    }
                }if (!empty($precebos_db) && is_array($precebos_db)) {
                    return view('admin.filtros.filtro_precebo', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('precebos_db', $precebos_db);
                }else{
                    flash('<strong>No existen registros asociados al Rango de Fecha Seleccionado!!!</strong>')->error()->important();
                    return redirect()->route('admin.precebos.index'); 
                }
            }
            if ( !empty($precebos_db) && is_array($precebos_db))
            {
                
                return view('admin.filtros.filtro_precebo', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('precebos_db', $precebos_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al Lote Seleccionado!!!</strong>')->error()->important();
                return redirect()->route('admin.precebos.index');
            } 
        }
        elseif($request->lote != null)
        {
            $fecha_inicial = '+';
            $fecha_final = '+';
            $lote_filtro = $request->lote;
            $granja_filtro = '0';
            if ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) {
                $fecha_inicial = $request->fecha_desde_precebo;
                $fecha_final = $request->fecha_hasta_precebo;
                $fechas = Precebo::whereBetween('fecha_traslado',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
                if (Auth::User()->rol_id != 7) 
                {
                    foreach ($fechas as $fecha) 
                    {
                        if ($request->lote == $fecha->lote) 
                        {
                            foreach($g_as as $g)
                            {
                                if($g->user_id == Auth::User()->id)
                                {
                                    if($fecha->granja_id == $g->granja_id)
                                    {
                                        foreach ($granjas as $granja) 
                                        {
                                            if ($fecha->granja_id == $granja->id) 
                                            {
                                                $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                                                $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                                $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                                $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                                $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                                $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                                $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final; 
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
                                    $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                                    $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                    $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                    $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                    $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                    $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                    $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final; 
                                }
                            }
                        }
                    }
                }
            }else{
                $fecha_inicial = '+';
                $fecha_final = '+';
                if (Auth::User()->rol_id != 7) {
                    foreach ($precebos as $precebo) 
                    {
                        if ($precebo->lote == $request->lote) 
                        {
                            foreach ($g_as as $g) {
                                if ($g->user_id == Auth::User()->id) {
                                    if ($precebo->granja_id == $g->granja_id) {
                                        foreach ($granjas as $granja) 
                                        {
                                            if ($granja->id == $precebo->granja_id) 
                                            {
                                                $precebos_db[$precebo->id]["id_precebo"] = $precebo->id;
                                                $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                                $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                                $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                                $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                                $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                                $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                            }
                                        }
                                    }
                                }
                            }
                        }   
                    }
                }else{
                    foreach ($precebos as $precebo) 
                    {
                        if ($precebo->lote == $request->lote) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $precebo->granja_id) 
                                {
                                    $precebos_db[$precebo->id]["id_precebo"] = $precebo->id;
                                    $precebos_db[$precebo->id]["lote"] = $precebo->lote;
                                    $precebos_db[$precebo->id]["granja"] = $granja->nombre_granja;
                                    $precebos_db[$precebo->id]["fecha_destete"] = $precebo->fecha_destete;
                                    $precebos_db[$precebo->id]["fecha_traslado"] = $precebo->fecha_traslado;
                                    $precebos_db[$precebo->id]["numero_inicial"] = $precebo->numero_inicial;
                                    $precebos_db[$precebo->id]["numero_final"] = $precebo->numero_final;
                                }
                            }
                        }   
                    }
                }
            }
            if ( !empty($precebos_db) && is_array($precebos_db))
            {
                return view('admin.filtros.filtro_precebo', compact('granja_filtro', 'lote_filtro','fecha_inicial','fecha_final'))->with('precebos_db', $precebos_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote o Fecha solicitados!!!</strong>')->error()->important();
                return redirect()->route('admin.precebos.index');
            } 
        }
        elseif ($request->fecha_desde_precebo != null && $request->fecha_hasta_precebo != null) {
            $granja_filtro = '0';
            $lote_filtro = '*';
            $fecha_inicial = $request->fecha_desde_precebo;
            $fecha_final = $request->fecha_hasta_precebo;

            $fechas = Precebo::whereBetween('fecha_traslado',[$request->fecha_desde_precebo, $request->fecha_hasta_precebo] )->get();
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
                                        $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                                        $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                                        $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                                        $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                                        $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                                        $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;  
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
                            
                            $precebos_db[$fecha->id]["id_precebo"] = $fecha->id;
                            $precebos_db[$fecha->id]["lote"] = $fecha->lote;
                            $precebos_db[$fecha->id]["granja"] = $granja->nombre_granja;
                            $precebos_db[$fecha->id]["fecha_destete"] = $fecha->fecha_destete;
                            $precebos_db[$fecha->id]["fecha_traslado"] = $fecha->fecha_traslado;
                            $precebos_db[$fecha->id]["numero_inicial"] = $fecha->numero_inicial;
                            $precebos_db[$fecha->id]["numero_final"] = $fecha->numero_final;  
                        }
                    }
                }
            }
            if ( !empty($precebos_db) && is_array($precebos_db))
            {
                return view('admin.filtros.filtro_precebo', compact('granja_filtro','lote_filtro','fecha_inicial', 'fecha_final'))->with('precebos_db', $precebos_db);
            }
            else
            {
                flash('<strong>No se encontraron registros asociados a las fechas seleccionadas.!!!</strong>')->error()->important();
                return redirect()->route('admin.precebos.index');
            } 
        }
        else
        {
            flash('<strong>Selecciona una granja correcta!!!</strong>')->error()->important();
            return redirect()->route('admin.precebos.index');
        }
    }

    /**
     * permite visualizar en la vista tabla_precebo.blade.php informacion extra del registro
     * seleccionado en la vista list_precebos.blade.php
     *
     * @var Precebo
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_precebo.blade.php compact $granja with $precebo_c
     */
    public function show($id)
    {
        $precebo_c = Precebo::find($id);
        $granja = Granja::find($precebo_c->granja_id);
        return view('admin.granjas.tabla_precebo', compact('granja', $granja))->with('precebo_c', $precebo_c);
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
