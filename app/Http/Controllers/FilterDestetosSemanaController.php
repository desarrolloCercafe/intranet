<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\DestetosSemana;
use App\Granja;
use App\AsociacionGranja;
use App\Http\Requests;

class FilterDestetosSemanaController extends Controller
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
     * permite realizar una consulta a la base de datos para poder adquirir
     * la informacion de acuerdo a los párametros enviados desde la vista
     * list_destetos_semana.blade.php
     *
     * @var AsociacionGranja 
     * @var Granja
     * @var DestetosSemana 
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/filtro_destetos_semana.blade.php compact $granja_filtro
     * $lote_filtro with $destetosS_db
     */
    public function store(Request $request)
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $destetosS = DestetosSemana::all();

        if ($request->granja != null) 
        {
            $granja_filtro = $request->granja;
            $lote_filtro = $request->lote;
            if ($request->lote != null)
            {
                if (Auth::User()->rol_id != 7)  
                {
                    foreach ($g_as as $g) 
                    {
                        if ($g->user_id == Auth::User()->id)
                        {
                            foreach ($destetosS as $destetoS) 
                            {
                                if ($destetoS->granja_cria_id == $request->granja) 
                                {
                                    if ($destetoS->lote == $request->lote) 
                                    {
                                        foreach ($granjas as $granja) 
                                        {
                                            if ($granja->id == $destetoS->granja_cria_id) 
                                            {
                                                $destetosS_db[$destetoS->id]["id"] = $destetoS->id;
                                                $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                                $destetosS_db[$destetoS->id]["granja"] = $granja->nombre_granja;
                                                $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                                $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                                $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                                $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                                $destetosS_db[$destetoS->id]["destetos"] = $destetoS->numero_destetos;
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
                    foreach ($destetosS as $destetoS) 
                    {
                        if ($destetoS->granja_cria_id == $request->granja) 
                        {
                            if ($destetoS->lote == $request->lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $destetoS->granja_cria_id) 
                                    {
                                        $destetosS_db[$destetoS->id]["id"] = $destetoS->id;
                                        $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                        $destetosS_db[$destetoS->id]["granja"] = $granja->nombre_granja;
                                        $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                        $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                        $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                        $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                        $destetosS_db[$destetoS->id]["destetos"] = $destetoS->numero_destetos;
                                    }
                                }
                            }
                        }   
                    }
                }   
            }
            else
            {
                $lote_filtro = '0';
                if (Auth::User()->rol_id != 7)  
                {
                    foreach ($g_as as $g) 
                    {
                        if ($g->user_id == Auth::User()->id)
                        {
                            foreach ($destetosS as $destetoS) 
                            {
                                if ($destetoS->granja_cria_id == $request->granja) 
                                {
                                    foreach ($granjas as $granja) 
                                    {
                                        if ($granja->id == $destetoS->granja_cria_id) 
                                        {
                                            $destetosS_db[$destetoS->id]["id"] = $destetoS->id;
                                            $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                            $destetosS_db[$destetoS->id]["granja"] = $granja->nombre_granja;
                                            $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                            $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                            $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                            $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                            $destetosS_db[$destetoS->id]["destetos"] = $destetoS->numero_destetos;
                                        }
                                    } 
                                }   
                            }
                        } 
                    }
                }
                else
                {
                    foreach ($destetosS as $destetoS) 
                    {
                        if ($destetoS->granja_cria_id == $request->granja) 
                        {
                            foreach ($granjas as $granja) 
                            {
                                if ($granja->id == $destetoS->granja_cria_id) 
                                {
                                    $destetosS_db[$destetoS->id]["id"] = $destetoS->id;
                                    $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                    $destetosS_db[$destetoS->id]["granja"] = $granja->nombre_granja;
                                    $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                    $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                    $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                    $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                    $destetosS_db[$destetoS->id]["destetos"] = $destetoS->numero_destetos;
                                }
                            }  
                        }   
                    }
                }
            }
            if ( !empty($destetosS_db) && is_array($destetosS_db))
            {
                
                return view('admin.filtros.filtro_destetos_semana', compact('granja_filtro', 'lote_filtro'))->with('destetosS_db', $destetosS_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.destetosSemana.index');
            } 
        }
        elseif($request->lote != null)
        {
            $granja_filtro = '0';
            $lote_filtro = $request->lote;
            if (Auth::User()->rol_id != 7) 
            {
                foreach ($g_as as $g) 
                {
                    if ($g->user_id == Auth::User()->id)
                    {
                        foreach ($destetosS as $destetoS) 
                        {
                            if ($destetoS->lote == $request->lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $destetoS->granja_cria_id) 
                                    {
                                        $destetosS_db[$destetoS->id]["id"] = $destetoS->id;
                                        $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                        $destetosS_db[$destetoS->id]["granja"] = $granja->nombre_granja;
                                        $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                        $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                        $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                        $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                        $destetosS_db[$destetoS->id]["destetos"] = $destetoS->numero_destetos;
                                    }
                                }
                            }    
                        }
                    } 
                }
            }
            else
            {
                foreach ($g_as as $g) 
                {
                    if ($g->user_id == Auth::User()->id)
                    {
                        foreach ($destetosS as $destetoS) 
                        {
                            if ($destetoS->lote == $request->lote) 
                            {
                                foreach ($granjas as $granja) 
                                {
                                    if ($granja->id == $destetoS->granja_cria_id) 
                                    {
                                        $destetosS_db[$destetoS->id]["id"] = $destetoS->id;
                                        $destetosS_db[$destetoS->id]["lote"] = $destetoS->lote;
                                        $destetosS_db[$destetoS->id]["granja"] = $granja->nombre_granja;
                                        $destetosS_db[$destetoS->id]["semana_destete"] = $destetoS->semana_destete;
                                        $destetosS_db[$destetoS->id]["año_destete"] = $destetoS->año_destete;
                                        $destetosS_db[$destetoS->id]["semana_venta"] = $destetoS->semana_venta;
                                        $destetosS_db[$destetoS->id]["año_venta"] = $destetoS->año_venta;
                                        $destetosS_db[$destetoS->id]["destetos"] = $destetoS->numero_destetos;
                                    }
                                }
                            }    
                        }
                    } 
                }
            }
             if ( !empty($destetosS_db) && is_array($destetosS_db))
            {
                
                return view('admin.filtros.filtro_destetos_semana', compact('granja_filtro', 'lote_filtro'))->with('destetosS_db', $destetosS_db);
            }
            else
            {
                flash('<strong>No existen registros asociados al lote solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.destetosSemana.index');
            } 
        }
        else
        {
            flash('<strong>Ingresa datos de Busqueda!!!</strong>')->error()->important();
            return redirect()->route('admin.destetosSemana.index');
        }
    }

    /**
     * permite acceder a la vista tabla_detete_semana.blade.php 
     * el registro seleccionado desde la vista list_destetos_semana
     *
     * @var DestetosSemana
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_destete_semana.blade.php compact $granja with $desteto_s
     */
    public function show($id)
    {
        $desteto_s = DestetosSemana::find($id);
        $granja = Granja::find($desteto_s->granja_cria_id);
        return view('admin.granjas.tabla_destete_semana', compact('granja', $granja))->with('desteto_s', $desteto_s);
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
