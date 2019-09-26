<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Granja;
use App\ProductoCia;
use App\PedidoCia;
use App\ConsecutivoCia;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FilterPedidosCiaController extends Controller
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
     * permite realizar una consulta desde la vista list_pedidos_cia.blade.php hasta la vista
     * filtro_pedidos_cia.blade.php donde tendra todos los pedidos de acuerdo a los parametros
     * de busqueda
     *
     * @var Granja
     * @var ProductoCia
     * @var PedidoCia
     * @var ConsecutivoCia
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/filtro_pedidos_cia.blade.php compact $f_ini, $f_fin
     * $grj with $pedidos_db
     */
    public function store(Request $request)
    {
        $granjas = Granja::all();
        $productos_cia = ProductoCia::all();
        $pedidos_cia = PedidoCia::all();
        $consecutivo = ConsecutivoCia::all();

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
            $peds = ConsecutivoCia::whereBetween('fecha_creacion', [$request->fecha_de, $request->fecha_hasta])->get();

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
                            $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion; 
                        }
                        else if ($request->granja == null) 
                        {
                            $pedidos_db[$pe->id]["consecutivo"] = $pe->consecutivo;
                            $pedidos_db[$pe->id]["granja"] = $g->nombre_granja;
                            $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion; 
                        }
                    }
                }
            }
            if ( !empty($pedidos_db) && is_array($pedidos_db))
            {
                return view('admin.filtros.filtro_pedidos_cia', compact('f_ini', 'f_fin', 'grj'))->with('pedidos_db', $pedidos_db);
            }
            else
            {
                flash('<strong>No existen pedidos para el rango de fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.pedidoProductosCia.index');
            } 
        }
        else if($request->tipo == "pr") 
        {
            $prods = PedidoCia::whereBetween('fecha_pedido', [$request->fecha_de, $request->fecha_hasta])->get();
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
                                if ($request->granja == $g->id)
                                {
                                    $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                    $productos_db[$pr->id]["ref"] = $producto_cia->ref_producto_cia;
                                    $productos_db[$pr->id]["producto"] = $producto_cia->nombre_producto_cia;
                                    $productos_db[$pr->id]["fecha"] = $pr->fecha_pedido;
                                    $productos_db[$pr->id]["dosis"] = $pr->dosis;
                                    $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                }
                                else if ($request->granja == null) 
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
            if ( !empty($productos_db) && is_array($productos_db))
            {
                
                return view('admin.filtros.filtro_productos_cia', compact('f_ini', 'f_fin','grj'))->with('productos_db', $productos_db);
            }
            else
            {
                flash('<strong>No existen productos asociados al rango de fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.pedidoProductosCia.index');
            } 
        }
        else
        {
            flash('<strong>No seleccionaste un formato de Busqueda!!!</strong>')->error()->important();
            return redirect()->route('admin.pedidoProductosCia.index');
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
