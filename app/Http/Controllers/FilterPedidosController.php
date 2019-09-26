<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Estado;
use App\Granja;
use App\Medicamento;
use App\InsumoServicios;
use App\PedidoInsumoServicio;
use App\PedidoMedicamento;
use App\ConsecutivoMedicamento;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FilterPedidosController extends Controller
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
     * permite realizar una consulta desde la vista list_pedidos_medicamentos.blade.php hasta la vista
     * filtro_pedidos_medicamentos.blade.php donde tendra todos los pedidos de acuerdo a los parametros
     * de busqueda
     *
     * @var Granja 
     * @var Estado
     * @var Medicamento
     * @var InsumoServicios
     * @var PedidoMedicamento
     * @var ConsecutivoMedicamento
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/filtro_productos_medicamentos.blade.php compact $f_ini
     * $f_fin $grj $productos_insumos_db with $productos_db
     */
    public function store(Request $request)
    {
        $granjas = Granja::all();
        $estados = Estado::all();
        $medicamentos = Medicamento::all();
        $insumos_servicios = InsumoServicios::all();
        $productos = PedidoMedicamento::all();
        $pedidos = ConsecutivoMedicamento::all();

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
            $peds = ConsecutivoMedicamento::whereBetween('fecha_creacion', [$request->fecha_de, $request->fecha_hasta])->get();

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
                            $pedidos_db[$pe->id]["fecha"] = $pe->fecha_creacion;
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
                return view('admin.filtros.filtro_pedidos_medicamentos', compact('f_ini', 'f_fin', 'grj'))->with('pedidos_db', $pedidos_db);
            }
            else
            {
                flash('<strong>No existen pedidos para el rango de fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.pedidoMedicamentos.index');
            } 
        }
        else if($request->tipo == "pr") 
        {
            $prods = PedidoMedicamento::whereBetween('fecha_pedido', [$request->fecha_de, $request->fecha_hasta])->get();
            $prods_insumos = PedidoInsumoServicio::whereBetween('fecha_pedido_insumo', [$request->fecha_de, $request->fecha_hasta])->get();
            if ($prods != null)
            {
                foreach ($prods as $pr) 
                {
                    if($pr->estado_id == 2 || $pr->estado_id == 4)
                    {
                        foreach ($granjas as $g)
                        {
                            if ($pr->granja_id == $g->id)
                            {
                                foreach ($medicamentos as $medicamento)
                                {
                                    if ($pr->medicamento_id == $medicamento->id)
                                    {
                                        if ($request->granja == $g->id)
                                        {
                                            $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                            $productos_db[$pr->id]["ref"] = $medicamento->ref_medicamento;
                                            $productos_db[$pr->id]["producto"] = $medicamento->nombre_medicamento;
                                            $productos_db[$pr->id]["fecha"] = $pr->fecha_pedido;
                                            $productos_db[$pr->id]["cantidad"] = $pr->unidades;
                                            $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                        }
                                        else if ($request->granja == null)
                                        {
                                            $productos_db[$pr->id]["granja"] = $g->nombre_granja;
                                            $productos_db[$pr->id]["ref"] = $medicamento->ref_medicamento;
                                            $productos_db[$pr->id]["producto"] = $medicamento->nombre_medicamento;
                                            $productos_db[$pr->id]["fecha"] = $pr->fecha_pedido;
                                            $productos_db[$pr->id]["cantidad"] = $pr->unidades;
                                            $productos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($prods_insumos != null)
            {
                foreach ($prods_insumos as $pr)
                {
                    if($pr->estado_id == 2 || $pr->estado_id == 4)
                    {
                        foreach ($granjas as $g) 
                        {
                            if ($pr->granja_id == $g->id)
                            {
                                foreach ($insumos_servicios as  $insumo_servicio)
                                {
                                    if ($pr->insumo_servicio_id == $insumo_servicio->id) 
                                    {
                                        if ($request->granja == $g->id)
                                        {
                                            $productos_insumos_db[$pr->id]["granja"] = $g->nombre_granja;
                                            $productos_insumos_db[$pr->id]["ref"] = $insumo_servicio->ref_insumo;
                                            $productos_insumos_db[$pr->id]["producto"] = $insumo_servicio->nombre_insumo;
                                            $productos_insumos_db[$pr->id]["fecha"] = $pr->fecha_pedido_insumo;
                                            $productos_insumos_db[$pr->id]["cantidad"] = $pr->unidades;
                                            $productos_insumos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                        }
                                        else if ($request->granja == null)
                                        {
                                            $productos_insumos_db[$pr->id]["granja"] = $g->nombre_granja;
                                            $productos_insumos_db[$pr->id]["ref"] = $insumo_servicio->ref_insumo;
                                            $productos_insumos_db[$pr->id]["producto"] = $insumo_servicio->nombre_insumo;
                                            $productos_insumos_db[$pr->id]["fecha"] = $pr->fecha_pedido_insumo;
                                            $productos_insumos_db[$pr->id]["cantidad"] = $pr->unidades;
                                            $productos_insumos_db[$pr->id]["consecutivo"] = $pr->consecutivo_pedido;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ( !empty($productos_db) && is_array($productos_db) && !empty($productos_insumos_db) && is_array($productos_insumos_db))
            {  
                return view('admin.filtros.filtro_productos_medicamentos', compact('f_ini', 'f_fin','grj', 'productos_insumos_db', $productos_insumos_db))->with('productos_db', $productos_db);
            }
            else if(!empty($productos_db) && is_array($productos_db))
            {
                $productos_insumos_db = null;
                return view('admin.filtros.filtro_productos_medicamentos', compact('f_ini', 'f_fin','grj', 'productos_insumos_db', $productos_insumos_db))->with('productos_db', $productos_db);
            }
            else if(!empty($productos_insumos_db) && is_array($productos_insumos_db))
            {
                $productos_db = null;
                return view('admin.filtros.filtro_productos_medicamentos', compact('f_ini', 'f_fin','grj', 'productos_insumos_db', $productos_insumos_db))->with('productos_db', $productos_db);
            }
            else
            {
                flash('<strong>No existen productos asociados al rango de fecha solicitado!!!</strong>')->error()->important();
                return redirect()->route('admin.pedidoMedicamentos.index');
            }
        }
        else
        {
            flash('<strong>No seleccionaste un formato de Busqueda!!!</strong>')->error()->important();
            return redirect()->route('admin.pedidoMedicamentos.index');
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
