<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Estado;
use App\Granja;
use App\Concentrado;
use App\PedidoConcentrado;
use App\ConsecutivoConcentrado;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;

class FilterPedidosConcentradosController extends Controller
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
     * permite realizar una consulta desde la vista list_pedidos_concentrados.blade.php hasta la vista
     * filtro_pedidos_concentrados.blade.php donde tendra todos los pedidos de acuerdo a los parametros
     * de busqueda
     *
     * @var Granja
     * @var Estado
     * @var Concentrado
     * @var PedidoConcentrado
     * @var ConsecutivoConcentrado
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/filtro_pedidos_concentrados.blade.php compact $f_ini $f_fin
     * $grj with $pedidos_db
     */
    public function store(Request $request)
    {
        $granjas = Granja::all();
        $estados = Estado::all();
        $concentrados = Concentrado::all();
        $productos = PedidoConcentrado::all();
        $pedidos = ConsecutivoConcentrado::all();

        $f_ini = $request->fecha_de;
        $f_fin = $request->fecha_hasta;
        if ($request->granja != null) 
        {
            $grj = $request->granja;
        }
        else
        {
            $grj = '0';
        }
       
        if ($request->tipo == "pd") 
        {
            if(Auth::User()->rol_id == 7 || Auth::user()->rol_id == 9)
            {
                $peds = ConsecutivoConcentrado::whereBetween('fecha_creacion', [$request->fecha_de, $request->fecha_hasta])->get();
                foreach ($peds as $pe)
                {
                    foreach ($granjas as $g)
                    {
                        if ($pe->granja_id == $g->id)
                        {
                            if ($request->granja == $g->id) 
                            { 
                                $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                                $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                                $pedidos_db[$pe->id]["fecha_creacion"] = $pe->fecha_creacion;
                                $pedidos_db[$pe->id]["fecha_entrega"] = $pe->fecha_entrega;
                                foreach ($estados as $estado) 
                                {
                                    if ($pe->estado_id == $estado->id) 
                                    {
                                        $pedidos_db[$pe->id]["estado"] = $estado->nombre_estado;
                                    }
                                }  
                            }
                            else if ($request->granja == null) 
                            {
                                $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                                $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                                $pedidos_db[$pe->id]["fecha_creacion"] = $pe->fecha_creacion;
                                $pedidos_db[$pe->id]["fecha_entrega"] = $pe->fecha_entrega;
                                foreach ($estados as $estado) 
                                {
                                    if ($pe->estado_id == $estado->id) 
                                    {
                                        $pedidos_db[$pe->id]["estado"] = $estado->nombre_estado;
                                    }
                                }  
                            }
                        }
                    }
                }
                if ( !empty($pedidos_db) && is_array($pedidos_db))
                {
                    return view('admin.filtros.filtro_pedidos_concentrados', compact('f_ini', 'f_fin', 'grj'))->with('pedidos_db', $pedidos_db);
                }
                else
                {
                    flash('<strong>No existen pedidos para el rango de fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.pedidoConcentrados.index');
                } 
            }
            else
            {
                $peds = ConsecutivoConcentrado::whereBetween('fecha_entrega', [$request->fecha_de, $request->fecha_hasta])->get();
                foreach ($peds as $pe) 
                {
                    foreach ($granjas as $g)  
                    {
                        if ($pe->granja_id == $g->id)
                        {
                            if ($request->granja == $g->id) 
                            {
                                if ($pe->fecha_entrega != 'por verificar') 
                                {
                                    $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                                    $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                                    $pedidos_db[$pe->id]["fecha_creacion"] = $pe->fecha_creacion;
                                    $pedidos_db[$pe->id]["fecha_entrega"] = $pe->fecha_entrega;
                                    foreach ($estados as $estado) 
                                    {
                                        if ($pe->estado_id == $estado->id) 
                                        {
                                            $pedidos_db[$pe->id]["estado"] = $estado->nombre_estado;
                                        }
                                    } 
                                } 
                            }
                            else if ($request->granja == null) 
                            {
                                if ($pe->fecha_entrega != 'por verificar') 
                                {
                                    $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                                    $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                                    $pedidos_db[$pe->id]["fecha_creacion"] = $pe->fecha_creacion;
                                    $pedidos_db[$pe->id]["fecha_entrega"] = $pe->fecha_entrega;
                                    foreach ($estados as $estado) 
                                    {
                                        if ($pe->estado_id == $estado->id) 
                                        {
                                            $pedidos_db[$pe->id]["estado"] = $estado->nombre_estado;
                                        }
                                    } 
                                }
                            }
                        }
                    }
                }
                if ( !empty($pedidos_db) && is_array($pedidos_db))
                {
                    return view('admin.filtros.filtro_pedidos_concentrados', compact('f_ini', 'f_fin', 'grj'))->with('pedidos_db', $pedidos_db);
                }
                else
                {
                    flash('<strong>No existen pedidos para el rango de fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.pedidoConcentrados.index');
                } 
            }  
        }
        else if($request->tipo == "pr") 
        {
            if(Auth::User()->rol_id == 7 || Auth::user()->rol_id == 9)
            {
                $prods = PedidoConcentrado::whereBetween('fecha_creacion', [$request->fecha_de, $request->fecha_hasta])->get();
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
                                    if ($request->granja == $g->id)
                                    {
                                        $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                        $productos_db[$pr->id]["ref"] = $concentrado->ref_concentrado;
                                        $productos_db[$pr->id]["producto"] = $concentrado->nombre_concentrado;
                                        $productos_db[$pr->id]["fecha_creacion"] = $pr->fecha_creacion;
                                        $productos_db[$pr->id]["fecha_entrega"] = $pr->fecha_entrega;
                                        $productos_db[$pr->id]["bultos"] = $pr->no_bultos;
                                        $productos_db[$pr->id]["kilos"] = $pr->no_kilos;
                                        $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;  
                                    }
                                    else if ($request->granja == null) 
                                    {
                                        $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                        $productos_db[$pr->id]["ref"] = $concentrado->ref_concentrado;
                                        $productos_db[$pr->id]["producto"] = $concentrado->nombre_concentrado;
                                        $productos_db[$pr->id]["fecha_creacion"] = $pr->fecha_creacion;
                                        $productos_db[$pr->id]["fecha_entrega"] = $pr->fecha_entrega;
                                        $productos_db[$pr->id]["bultos"] = $pr->no_bultos;
                                        $productos_db[$pr->id]["kilos"] = $pr->no_kilos;
                                        $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;                                          
                                    }
                                }
                            }
                        }
                    }
                }
                if ( !empty($productos_db) && is_array($productos_db))
                {
                    
                    return view('admin.filtros.filtro_productos_concentrados', compact('f_ini', 'f_fin','grj'))->with('productos_db', $productos_db);
                }
                else
                {
                    flash('<strong>No existen productos asociados al rango de fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.pedidoConcentrados.index');
                }
            }
            else
            {
                $prods = PedidoConcentrado::whereBetween('fecha_entrega', [$request->fecha_de, $request->fecha_hasta])->get();
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
                                    if ($request->granja == $g->id)
                                    {
                                        if ($pr->fecha_entrega != 'por verificar') 
                                        {
                                            $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                            $productos_db[$pr->id]["ref"] = $concentrado->ref_concentrado;
                                            $productos_db[$pr->id]["producto"] = $concentrado->nombre_concentrado;
                                            $productos_db[$pr->id]["fecha_creacion"] = $pr->fecha_creacion;
                                            $productos_db[$pr->id]["fecha_entrega"] = $pr->fecha_entrega;
                                            $productos_db[$pr->id]["bultos"] = $pr->no_bultos;
                                            $productos_db[$pr->id]["kilos"] = $pr->no_kilos;
                                            $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                        }
                                    }
                                    else if ($request->granja == null) 
                                    {
                                        if ($pr->fecha_entrega != 'por verificar') 
                                        {
                                            $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                            $productos_db[$pr->id]["ref"] = $concentrado->ref_concentrado;
                                            $productos_db[$pr->id]["producto"] = $concentrado->nombre_concentrado;
                                            $productos_db[$pr->id]["fecha_creacion"] = $pr->fecha_creacion;
                                            $productos_db[$pr->id]["fecha_entrega"] = $pr->fecha_entrega;
                                            $productos_db[$pr->id]["bultos"] = $pr->no_bultos;
                                            $productos_db[$pr->id]["kilos"] = $pr->no_kilos;
                                            $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                        }                                       
                                    }
                                }
                            }
                        }
                    }
                }
                if ( !empty($productos_db) && is_array($productos_db))
                {
                    
                    return view('admin.filtros.filtro_productos_concentrados', compact('f_ini', 'f_fin','grj'))->with('productos_db', $productos_db);
                }
                else
                {
                    flash('<strong>No existen productos asociados al rango de fecha solicitado!!!</strong>')->error()->important();
                    return redirect()->route('admin.pedidoConcentrados.index');
                }
            }    
        }
        else
        {
            flash('<strong>No seleccionaste un formato de Busqueda!!!</strong>')->error()->important();
            return redirect()->route('admin.pedidoConcentrados.index');
        }
    }
        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
