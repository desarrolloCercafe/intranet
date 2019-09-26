<?php

namespace App\Http\Controllers;
 
use DB;
use Illuminate\Http\Request;
use Mail;
use Session;
use Auth;
use App\User;
use App\Granja;
use App\AsociacionGranja;
use App\Medicamento; 
use App\InsumoServicios; 
use App\ConsecutivoMedicamento; 
use App\PedidoInsumoServicio;
use Carbon\Carbon; 
use App\PedidoMedicamento;
use App\Http\Requests; 
use App\Http\Controllers\Controller;

class PedidoMedicamentosController extends Controller 
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista consultar_pedido_medicamentos.blade.php con todos los pedidos
     * ingresado desde la base de datos
     *
     * @var Granja
     * @var AsociacionGranja
     * @return view('admin.pedidos.consultar_pedido_medicamentos', compact('granjas', $granjas,'g_as',$g_as))->with('pedidos', $pedidos);
     */
    public function index()
    { 
        $g_as = AsociacionGranja::all();
        $granjas = Granja::lists('nombre_granja', 'id');
        $pedidos = DB::table('consecutivos_medicamentos') 
                ->join('granjas', 'consecutivos_medicamentos.granja_id', '=', 'granjas.id')
                ->select('consecutivos_medicamentos.*', 'granjas.nombre_granja')
                ->get();
        return view('admin.pedidos.consultar_pedido_medicamentos', compact('granjas', $granjas,'g_as',$g_as))->with('pedidos', $pedidos); 
    }

    /**
     * permite visualizar la vista pedido_medicamentos.blade.php para la creacion del pedido
     *
     * @var Granja
     * @var Medicamento
     * @var AsociacionGranja
     * @return view('admin.pedidos.pedido_medicamentos', compact('granjas', 'g_as'))->with('productos', $productos); 
     */
    public function create()
    {
        $g_as = AsociacionGranja::all(); 
        $granjas = Granja::all();
        $productos = Medicamento::all();
        return view('admin.pedidos.pedido_medicamentos', compact('granjas', 'g_as'))->with('productos', $productos); 
        // return view('errors/503');
    }

    /**
     * permite registrar un nuevo pedido desde la vista pedido_medicamentos.blade.php
     * una vez creado el nuevo registro se enviara una notificacion mediante correo 
     * electronico con la informacion del pedido ingresado para mantener un seguimiento
     * del pedido
     *
     * @var PedidoMedicamento
     * @var Granja
     * @var Medicamento
     * @var ConsecutivoMedicamento
     * @param  \Illuminate\Http\Request  $request
     * @return redirect()->route('admin.pedidoMedicamentos.create');
     */
    public function store(Request $request)
    {
        $pedidos_antiguos = PedidoMedicamento::all();
        $granjas = Granja::all();
        $medicamentos = Medicamento::all();
        $consecutivos = ConsecutivoMedicamento::all();
        $ult_consecutivo = $consecutivos->last();
        $cont = 1;

        $date = Carbon::now();
        $date->format('d-m-Y');

        $pedidos = json_decode($request->data, true);

        foreach ($pedidos as $pedido)  
        {
            if ($pedido["medicamento"] != null) 
            {
                $nuevo_pedido = new PedidoMedicamento();
                if ($ult_consecutivo != null)
                {
                    if ($ult_consecutivo != '1')
                    {
                        $nuevo_pedido->consecutivo_pedido = $ult_consecutivo->consecutivo + 1;
                    }
                }
                else
                {
                    $nuevo_pedido->consecutivo_pedido = 1;
                }
                $nuevo_pedido->fecha_pedido = $date;

                foreach ($granjas as $granja)
                {
                    if ($granja->id == $pedido["granja"])
                    {
                        $nuevo_pedido->granja_id = $granja->id;
                        $granja_s = $granja->nombre_granja;
                    }
                }
 
                foreach ($medicamentos as $medicamento) 
                {
                    if ($pedido["medicamento"] == $medicamento->nombre_medicamento) 
                    {
                        $nuevo_pedido->estado_id = 1;
                        $nuevo_pedido->medicamento_id = $medicamento->id;
                        $nuevo_pedido->unidades = $pedido["cantidad"];
                        $tipo = $pedido["tipo"];
                    }
                }
                $req = $pedidos;
                $nuevo_pedido->save();
            }
        }

        foreach ($req as $r) 
        {
            if ($r["medicamento"] == '') 
            {
                $cont++;
            } 
        }

        if($cont != 1)
        {
            $nuevo_consecutivo = new ConsecutivoMedicamento();
            if ($ult_consecutivo != null) 
            {
                if ($ult_consecutivo != '1')
                {
                    $nuevo_consecutivo->consecutivo = $ult_consecutivo->consecutivo + 1;
                    $consec = $nuevo_consecutivo->consecutivo;
                }
            }
            else
            {
                $nuevo_consecutivo->consecutivo = 1;
                $consec = $nuevo_consecutivo->consecutivo;
            }

            $nuevo_consecutivo->fecha_creacion = $date;
            $nuevo_consecutivo->granja_id = $nuevo_pedido->granja_id;
            $nuevo_consecutivo->estado_id = 1; 
            $nuevo_consecutivo->origen = 1; 
            $nuevo_consecutivo->tipo_pedido = $tipo; 
            $nuevo_consecutivo->save(); 

            $tecnicos = User::all();
            $email = "intranet2.0@cercafe.com.co";

            foreach ($tecnicos as $tecnico)
            {
                if($tecnico->email == Auth::User()->email || $tecnico->email == $email || $tecnico->email == 'medicamentos@cercafe.com.co' || $tecnico->email == 'compras@cercafe.com.co' || $tecnico->email == 'auxiliarmedicamentos@cercafe.com.co')
                {
                    Mail::send('admin.messages.notification_pedido_medicamento',['req' => $req, 'dat' => $date, 'cons' => $consec, 'granjas' => $granjas], function($msj) use($consec,$granja_s,$tecnico)
                    {
                        $msj->subject('"Pedido de Medicamentos"' . " " .$granja_s . '   -   ' . 'Solicitud de Medicamentos' . ' | ' . 'Consecutivo: ' . 'PME'.$consec);
                        $msj->to($tecnico->email);
                    });
                }
            }

            flash('Pedido <strong>Enviado</strong> exitosamente!!!')->success();
            return redirect()->route('admin.pedidoMedicamentos.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($consecutivo)
    {
        //
    }

    /**
    * permite visualizar mediante un modal desde la vista consultar_pedido_medicamentos.blade.php
    * la informacion del numero del pedido seleccionado desde la vista
    * 
    * @var PedidoMedicamento
    * @var Granja
    * @var InsumoServicios
    * @var Medicamento
    * @param \Illuminate\Http\Request $request
    * @return response()->json(["status"=>"success",'data'=>$productos_db,'consecutivo'=>$cons["consecutivo"]],200);
    */

    public function verMedicamento(request $request)
    {
        $productos = PedidoMedicamento::all();
        $productos_insumos = PedidoInsumoServicio::all();
        $granjas = Granja::all();
        $medicamentos = Medicamento::all();
        $insumos = InsumoServicios::all(); 
        $cont = 1;
        $consecutivo = json_decode($request->data, true);

        foreach ($consecutivo as $cons) 
        {
            if ($cons["consecutivo"] != null) 
            {
                foreach ($productos as $producto) 
                {
                    if ((int)$cons["consecutivo"] == $producto->consecutivo_pedido) 
                    {
                        foreach ($granjas as $granja) 
                        {
                            if ($granja->id == $producto->granja_id) 
                            {
                                foreach ($medicamentos as $medicamento) 
                                {
                                    if ($medicamento->id == $producto->medicamento_id) 
                                    {
                                        $productos_db[$producto->id]["granja"] = $granja->nombre_granja;
                                        $productos_db[$producto->id]["medicamento"] = $medicamento->nombre_medicamento;
                                        $productos_db[$producto->id]["unidades"] = $producto->unidades;
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
                    foreach ($productos_insumos as $producto_insumo) 
                    {
                        if ($producto_insumo->consecutivo_pedido == $cons["consecutivo"]) 
                        {
                            foreach ($granjas as $granja) 
                            {
                               if ($granja->id == $producto_insumo->granja_id) 
                               {
                                   foreach ($insumos as $insumo) 
                                   {
                                        if($insumo->id == $producto_insumo->insumo_servicio_id)
                                        {
                                            $productos_db[$producto_insumo->id]["granja"] = $granja->nombre_granja;
                                            $productos_db[$producto_insumo->id]["medicamento"] = $insumo->nombre_insumo;
                                            $productos_db[$producto_insumo->id]["unidades"] = $producto_insumo->unidades;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ( !empty($productos_db) && is_array($productos_db))
        {
            return response()->json(["status"=>"success",'data'=>$productos_db,'consecutivo'=>$cons["consecutivo"]],200);
        }
        else
        {
            flash('<strong>Ha Ocurrido un Error con este Pedido!!!</strong>')->error()->important();
            return redirect()->route('admin.pedidoMedicamentos.index');
        }
    }

    /** 
     * permite realizar el proceso de validacion de los pedidos desde la vista 
     * consultar_pedido_medicamentos.blade.php
     *
     * @var PedidoMedicamento
     * @var PedidoInsumoServicio
     * @var ConsecutivoMedicamento
     * @param  int  $id
     * @return redirect()->route('admin.pedidoMedicamentos.index');
     */
    public function edit($id)
    {
        $pedidos_medicamento = PedidoMedicamento::all();
        foreach ($pedidos_medicamento as $pedido_medicamento) 
        {
            if($pedido_medicamento->consecutivo_pedido == $id)
            {
                if($pedido_medicamento->estado_id == 1)
                {
                    $pedido_medicamento->estado_id = 4;
                    $pedido_medicamento->save(); 
                }
                else if($pedido_medicamento->estado_id == 4)
                {
                    $pedido_medicamento->estado_id = 2;
                    $pedido_medicamento->save();
                }
            }
        }

        $pedidos_insumos = PedidoInsumoServicio::all();
        foreach ($pedidos_insumos as $pedido_insumo) 
        {
            if($pedido_insumo->consecutivo_pedido == $id)
            {
                if($pedido_insumo->estado_id == 1)
                {
                    $pedido_insumo->estado_id = 4;
                    $pedido_insumo->save(); 
                }
                else if($pedido_insumo->estado_id == 4)
                {
                    $pedido_insumo->estado_id = 2;
                    $pedido_insumo->save(); 
                }
            }
        }

        $consecutivos_medicamento = ConsecutivoMedicamento::all(); 
        foreach ($consecutivos_medicamento as $consecutivo_medicamento) 
        {
            if($consecutivo_medicamento->consecutivo == $id)
            {
                if($consecutivo_medicamento->estado_id == 1)
                {
                    $consecutivo_medicamento->estado_id = 4;
                    $consecutivo_medicamento->save(); 
                }
                else if($consecutivo_medicamento->estado_id == 4)
                {
                    $consecutivo_medicamento->estado_id = 2;
                    $consecutivo_medicamento->save();
                }
            }
        }

        flash('Pedido Validado exitosamente!!!')->success()->important();
        return redirect()->route('admin.pedidoMedicamentos.index');
    }

    /**
    * permite visualizar la vista agregar_producto_medicamentos.blade.php para agregar nuevos productos 
    * al numero del pedido seleccionado en la vista consultar_pedido_medicamentos.blade.php
    *
    * @var ConsecutivoMedicamento
    * @var AsociacionGranja
    * @var Granja
    * @var Medicamento
    * @param int $cons
    * @return view('admin.pedidos.alterar_pedidos_medicamentos.agregar_producto_medicamentos', compact('granjas', 'g_as'))->with('productos', $productos); 
    */
 
    public function agregarProductos($cons)
    { 
        $productos_pedido = PedidoMedicamento::all();
        $medicamentos = Medicamento::all();
        foreach ($productos_pedido as $p)
        { 
            if ($p->consecutivo_pedido == $cons) 
            {
                $productos_db[$p->id]["id_medicamento"] = $p->medicamento_id;
                $productos_db[$p->id]["cantidad"] = $p->unidades;
                $g = $p->granja_id;
                $fecha = $p->fecha_pedido;
            }
        }

        $productos_db = json_decode(json_encode($productos_db), true);

        foreach ($productos_db as $k)
        {
            foreach ($medicamentos as $med)
            {
                if ($med->id == $k["id_medicamento"]) 
                {
                    $pr_db[$med->id]["id"] = $med->id;
                    $pr_db[$med->id]["codigo"] = $med->ref_medicamento;
                    $pr_db[$med->id]["descripcion"] = $med->nombre_medicamento;
                    $pr_db[$med->id]["unidades"] = $k["cantidad"];
                }
            }
        }
        $pr_db = json_decode(json_encode($pr_db), true);

        $consecutivos = ConsecutivoMedicamento::all();
        foreach ($consecutivos as $consecutivo)
        {
            if ($consecutivo->consecutivo == $cons)
            {
                $consecutivo = $cons;
                $g_as = AsociacionGranja::all();
                $granjas = Granja::all();
                $productos = Medicamento::all();
                return view('admin.pedidos.alterar_pedidos_medicamentos.agregar_producto_medicamentos', compact('granjas', 'g_as', 'consecutivo', 'productos', 'g', 'fecha'))->with('pr_db', $pr_db);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $medicamentos = Medicamento::all();
        $pedidos_antiguos = PedidoMedicamento::all();
        $productos_modificados = json_decode($request->data, true);

        foreach ($productos_modificados as $p_modificado)
        {
            if($p_modificado["medicamento"] != null)
            {
                $cons = $p_modificado["consecutivo"];
            }
        } 
        foreach ($pedidos_antiguos as $p_antiguos) 
        {
            if ($p_antiguos->consecutivo_pedido == $cons) 
            {
                $p_antiguos->delete();
            }
        }

        foreach ($productos_modificados as $p_modificado)
        {
            if($p_modificado["medicamento"] != null)
            {
                $p_mod = new PedidoMedicamento();
                $p_mod->consecutivo_pedido = $p_modificado["consecutivo"];
                $p_mod->fecha_pedido = $p_modificado["fecha_pedido"];
                $p_mod->granja_id = $p_modificado["granja"];
                foreach ($medicamentos as $medicamento) 
                {
                    if ($p_modificado["medicamento"] == $medicamento->nombre_medicamento) 
                    {
                        $p_mod->medicamento_id = $medicamento->id;
                    }
                }
                $p_mod->estado_id = 1;
                $p_mod->unidades = $p_modificado["cantidad"];
                $p_mod->save();
            }
        } 

        $tecnicos = User::all();
        $email = "intranet@cercafe.com.co";
        $granjas = Granja::all();
        foreach ($tecnicos as $tecnico)
        {
            if($tecnico->email == Auth::User()->email || $tecnico->email == $email || $tecnico->email == 'medicamentos@cercafe.com.co' || $tecnico->email == 'compras@cercafe.com.co' || $tecnico->email == 'auxiliarmedicamentos@cercafe.com.co')
            {
                Mail::send('admin.messages.notification_modification_medicamento',['cons' => $cons, 'granjas' => $granjas, 'req' => $productos_modificados], function($msj) use($cons,$tecnico)
                {
                    $msj->subject('Modificacion de Medicamentos' . ' | ' . 'Consecutivo: ' . 'PME'.$cons);
                    $msj->to($tecnico->email);
                });
            }
        }

        flash('El pedido <strong>' . 'PME'.$cons . '</strong> ha sido Modificado exitosamente!!!')->warning()->important();
        return redirect()->route('admin.pedidoMedicamentos.index');
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

