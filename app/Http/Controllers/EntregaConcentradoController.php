<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntregaConcentrado;
use App\Conductor;
use App\VehiculoDespacho;
use Carbon\Carbon;
use App\ConsecutivoConcentrado;
use App\Http\Requests;
use App\PedidoConcentrado; 
use App\Granja;
use App\User;

class EntregaConcentradoController extends Controller
{
    /**
     * permite visualizar la lista con todos los pedidos de la base de datos
     *
     * @var VehiculoDespacho
     * @var Conductor
     * @var ConsecutivoConcentrado
     * @return view/admin/pedidos/calendario_pedidos_concentrados.blade.php 
     * compact $vehiculos $conductores $consecutivos
     */
    public function index()
    { 
        $vehiculos = VehiculoDespacho::all(); 
        $conductores = Conductor::all();
        $consecutivos = ConsecutivoConcentrado::all();
       
        return view('admin.pedidos.calendario_pedidos_concentrado', compact('vehiculos', $vehiculos, 'conductores', $conductores, 'consecutivos', $consecutivos));
    } 

    /**
     * permite llevar los datos a la vista Calendario_pedidos_concentrados.blade.php 
     *
     * @var EntregaConcentrado
     * @return view/admin/pedidos/calendario_pedidos_concentrados.blade.php
     */
    public function create()
    {

        $data = EntregaConcentrado::get(['id','granja as title', 'consecutivo_id as name', 'fecha_seleccionada as start','vehiculo_seleccionado', 'conductor_seleccionado','fecha_modificada']); 
        return response()->json($data);
    }
 
    /**
     * permite crear un nuevo pedido en la vista pedidos_concentrados.blade.php
     * una vez creado el pedido se notificara por medio de un mensaje por correo electronico
     *
     * @var ConsecutivoConcentrado
     * @var PedidoConcentrado
     * @var Granja
     * @var User
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/pedidos/pedidos_concentrados.blade.php
     */
    public function store(Request $request)
    { 
        $event = new EntregaConcentrado();
        $consecutivos = ConsecutivoConcentrado::all(); 
        $productos = PedidoConcentrado::all();
        $granjas = Granja::all();
        $event->consecutivo_id = $request->consecutivo;
        $event->fecha_seleccionada = $request->date_start . ' ' . $request->time_start;
        $event->vehiculo_seleccionado = $request->placa;
        $event->conductor_seleccionado = $request->conductor; 
        foreach ($consecutivos as $cons)
        { 
            if ($cons->consecutivo == $request->consecutivo)
            {
                $cons->fecha_entrega =  $request->date_start . ' ' . $request->time_start;
                $cons->conductor_asignado = $request->conductor; 
                $cons->vehiculo_asignado = $request->placa; 

                foreach ($granjas as $g) 
                {
                    if ($cons->granja_id == $g->id) 
                    {
                        $event->granja = $g->nombre_granja; 
                    }
                }
                $cons->save();  
            }
        }
        $event->save();
        foreach ($productos as $producto) 
        {
            if ($producto->consecutivo_pedido == $request->consecutivo) 
            {
                $producto->fecha_entrega =  $request->date_start . ' ' . $request->time_start;
                $producto->save();
            }
            echo $producto->id;
        }  

        $coordinadores = User::all();
        foreach ($coordinadores as $coordinador)
        {
            if($coordinador->email == Auth::User()->email)
            {
                Mail::send('admin.messages.notification_pedido_concentrado',['req' => $req, 'dat' => $date, 'cons' => $consec, 'granjas' => $granjas], function($msj) use($granja_s,$tecnico)
                {
                    $msj->subject('"Pedido de Concentrados"' . " " .$granja_s . '   -   ' . 'Se han Solicitado Concentrados');
                    $msj->to($coordinador->email);
                });
            }
        }
        return redirect()->route('admin.entregaconcentrados.index');  
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
     * permite establece la hora de entrega del pedido en la vista
     * calendario pedidos_concentrados.blade.php
     *
     * @var ConsecutivoConcentrado 
     * @var PedidoConcentrado
     * @var Granja
     * @var VehiculoDespacho
     * @var Conductor
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return view/admin/pedidos/calendario_pedidos_concentrados.blade.php
     */
    
    public function update(Request $request)
    {
        $p = json_decode($request->data, true);
        $consecutivos = ConsecutivoConcentrado::all();
        $productos = PedidoConcentrado::all();
        $granjas = Granja::all();
        $vehiculos = VehiculoDespacho::all(); 
        $conductores = Conductor::all();

        foreach ($p as $s) 
        {
            $event =EntregaConcentrado::find($s["id_p"]); 
            $event->consecutivo_id = $s["consecutivo"];
            $event->fecha_seleccionada = $s["date_start"] . ' ' . $s["time_start"];
            $event->vehiculo_seleccionado = $s["placa"];
            $event->conductor_seleccionado = $s["conductor"];
            $event->fecha_modificada = $s['fecha_modificada']; 

            foreach ($consecutivos as $cons) 
            {
                if ($cons->consecutivo == $s["consecutivo"]) 
                {
                    $cons->fecha_entrega = $s["date_start"];
                    $cons->hora_entrega = $s["time_start"];
                    $cons->conductor_asignado = $s["conductor"]; 
                    $cons->vehiculo_asignado = $s["placa"];
                    $cons->save();

                    foreach ($productos as $producto)
                    {
                        if ($producto->consecutivo_pedido == $cons->consecutivo) 
                        {
                            $producto->fecha_entrega =  $s["date_start"];
                            $producto->save();
                        }
                    }
                }
            }
        }
        $event->save();
        flash('Hora Actualizada')->success()->important();   
        return view('admin.pedidos.calendario_pedidos_concentrado', compact('vehiculos', $vehiculos, 'conductores', $conductores, 'consecutivos', $consecutivos));
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
