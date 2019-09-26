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
use App\InsumoServicios; 
use App\ConsecutivoMedicamento; 
use Carbon\Carbon;
use App\PedidoInsumoServicio;
use App\PedidoMedicamento;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PedidoInsumosController extends Controller
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
     * permite visualizar la vista pedido_insumos_servicios.blade.php con los datos
     * requeridos para la creacion de un nuevo pedido
     *
     * @var AsociacionGranja
     * @var Granja
     * @var InsumoServicios
     * @return view('admin.pedidos.pedido_insumos_servicios', compact('granjas', 'g_as'))->with('productos', $productos); 
     */
    public function create()
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $productos = InsumoServicios::all(); 
        return view('admin.pedidos.pedido_insumos_servicios', compact('granjas', 'g_as'))->with('productos', $productos); 
    }

    /**
     * permite crear un nuevo pedido desde la vista pedido_insumos_servicios.blade.php
     * una vez registrado el pedido, se enviara por medio de correo electronico el registro del 
     * pedido ingresado para mantener un seguimiento del pedido en caso de errores
     *
     * @var Granja
     * @var InsumoServicios
     * @var ConsecutivoMedicamento
     * @param  \Illuminate\Http\Request  $request
     * @return redirect()->route('admin.pedidoInsumosServicios.create')
     */ 
    public function store(Request $request)
    { 
        $granjas = Granja::all();  
        $insumos_servicios = InsumoServicios::all();
        $consecutivos = ConsecutivoMedicamento::all();
        $ult_consecutivo = $consecutivos->last();
        $cont = 1; 
        $date = Carbon::now(); 
        $date->format('d-m-Y');
        $pedidos = json_decode($request->data, true); 

        foreach ($pedidos as $pedido)
        {
            if ($pedido["insumo"] != null) 
            {
                $nuevo_pedido = new PedidoInsumoServicio();
                if ($ult_consecutivo != null) 
                {
                    if ($ult_consecutivo->consecutivo != '1')
                    { 
                        $nuevo_pedido->consecutivo_pedido = $ult_consecutivo->consecutivo + 1;   
                    }
                }
                else
                {
                    $nuevo_pedido->consecutivo_pedido = 1;
                }
                $nuevo_pedido->fecha_pedido_insumo = $date;

                foreach ($granjas as $granja)
                {
                    if ($granja->id == $pedido["granja"])
                    {
                        $nuevo_pedido->granja_id = $granja->id;
                        $granja_s = $granja->nombre_granja; 
                    }
                }
 
               foreach ($insumos_servicios as $insumo_servicio) 
               {
                    if ($pedido["insumo"] == $insumo_servicio->nombre_insumo) 
                    {
                        $nuevo_pedido->estado_id = 1;
                        $nuevo_pedido->insumo_servicio_id = $insumo_servicio->id;
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
            if ($r["insumo"] == '') 
            {
                $cont++;
            } 
        }
        if($cont != 1)
        {
            $nuevo_consecutivo = new ConsecutivoMedicamento();
            
            if ($ult_consecutivo != null) 
            {
                if ($ult_consecutivo->consecutivo != '1')
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
            $nuevo_consecutivo->origen = 2; 
            $nuevo_consecutivo->tipo_pedido = $tipo; 
            $nuevo_consecutivo->save();

            $tecnicos = User::all();
            $email = "intranet2.0@cercafe.com.co";

            foreach ($tecnicos as $tecnico)
            {
                if($tecnico->email == Auth::User()->email || $tecnico->email == $email || $tecnico->email == 'medicamentos@cercafe.com.co' || $tecnico->email == 'compras@cercafe.com.co' || $tecnico->email == 'auxiliarcompras@cercafe.com.co')
                {
                    Mail::send('admin.messages.notification_pedido_insumos',['req' => $req, 'dat' => $date, 'cons' => $consec, 'granjas' => $granjas], function($msj) use($consec,$granja_s,$tecnico)
                    {
                        $msj->subject('"Pedido de Insumos"' . " " .$granja_s . '   -   ' . 'Solicitud de Insumos' . ' | ' . 'Consecutivo: ' . 'PME'.$consec);
                        $msj->to($tecnico->email);
                    });
                }
            }

            flash('Pedido <strong>Enviado</strong> exitosamente!!!')->success();
            return redirect()->route('admin.pedidoInsumosServicios.create');
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

    }

    /**
     * permite realizar la validacion del pedido desde la vista
     * consultar_pedido_medicamentos.blade.php
     *
     * @var ConsecutivoMedicamento
     * @param  int  $id
     * @return redirect()->route('admin.pedidoInsumosServicios.index');
     */
    public function edit($id)
    {
        // $consecutivos_medicamento = ConsecutivoMedicamento::all(); 
        // foreach ($consecutivos_medicamento as $consecutivo_medicamento) 
        // {
        //     if($consecutivo_medicamento->consecutivo == $id)
        //     {
        //         $consecutivo_medicamento->estado_id = 2;
        //         $consecutivo_medicamento->save(); 
        //     }
        // }
 
        // $pedidos_insumos_servicios = PedidoInsumoServicio::all();
        // foreach ($pedidos_insumos_servicios as $pedido_insumo_servicio) 
        // {
        //     if($pedido_insumo_servicio->consecutivo_pedido == $id)
        //     {
        //         $pedido_insumo_servicio->estado_id = 2;
        //         $pedido_insumo_servicio->save(); 
        //     }
        // }

        // flash('Pedido Validado exitosamente!!!')->success()->important();
        // return redirect()->route('admin.pedidoInsumosServicios.index');
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
