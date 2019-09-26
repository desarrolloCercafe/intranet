<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use Auth;
use App\User;
use App\Estado;
use App\Granja;
use App\AsociacionGranja;
use App\ProductoCia;
use App\ConsecutivoCia;
use Carbon\Carbon;
use App\PedidoCia;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class PedidoCiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista consultar_pedido_cia.blade.php con los datos
     * cargados desde la base de datos
     *
     * @var Granja
     * @var ConsecutivoCia
     * @return view('admin.pedidos.consultar_pedido_cia', compact('granjas', $granjas))->with('pedidos', $pedidos_p);
     */
    public function index()
    {
        $granjas = Granja::lists('nombre_granja', 'id');
        $pedidos_p = DB::table('consecutivos_productos_cia')
            ->join('granjas', 'consecutivos_productos_cia.granja_id', '=', 'granjas.id')
            ->select('consecutivos_productos_cia.*', 'granjas.nombre_granja')
            ->get();

        return view('admin.pedidos.consultar_pedido_cia', compact('granjas', $granjas))->with('pedidos', $pedidos_p);
    }

    /**
     * Permite visualizar la vista pedido_cia.blade.php para la creacion de un nuevo pedido.
     *
     * @var AsociacionGranja
     * @var Granja
     * @var ProductoCia
     * @return view('admin.pedidos.pedido_cia', compact('granjas', 'g_as', 'conductores', 'vehiculos'))->with('productos', $productos);
     */
    public function create()
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $productos = ProductoCia::all();
        return view('admin.pedidos.pedido_cia', compact('granjas', 'g_as', 'conductores', 'vehiculos'))->with('productos', $productos);
    }

    /**
     * permite ingresar a la base de datos el registro creado desde la vista
     * pedido_cia.blade.php, una vez creado el registro se enviara al correo electronico
     * con la informacion del registro ingresado para llevar  a cabo un monitoreo
     * de los pedidos realizados
     *
     * @var PedidoCia
     * @var Granja
     * @var ProductoCia
     * @param  \Illuminate\Http\Request  $request
     * @return redirect()->route('admin.pedidoProductosCia.create');
     */
    public function store(Request $request)
    {
        $pedidos_cia_antiguos = PedidoCia::all();
        $granjas = Granja::all();
        $productosCia = ProductoCia::all();
        $ult_pedido = $pedidos_cia_antiguos->last();
        $cont = 1;

        $date = Carbon::now();
        $date->format('d-m-Y');

        $pedidos_c = json_decode($request->data, true);

        foreach ($pedidos_c as $pedido_c)
        {
            if ($pedido_c["producto_cia"] != null)
            {
                $nuevo_pedido_c = new PedidoCia();
                if ($ult_pedido != null)
                {
                    if ($ult_pedido != '1')
                    {
                        $nuevo_pedido_c->consecutivo_pedido = $ult_pedido->consecutivo_pedido + 1;
                    }
                }
                else
                {
                    $nuevo_pedido_c->consecutivo_pedido = 1;
                }
                $nuevo_pedido_c->fecha_pedido = $date;

                foreach ($granjas as $granja)
                {
                    if ($granja->id == $pedido_c["granja"])
                    {
                        $nuevo_pedido_c->granja_id = $granja->id;
                        $granja_s = $granja->nombre_granja;
                    }
                }

               foreach ($productosCia as $producto)
               {
                    if ($pedido_c["producto_cia"] == $producto->nombre_producto_cia)
                    {
                        $nuevo_pedido_c->producto_cia_id = $producto->id;
                        $nuevo_pedido_c->estado_id = 1;
                        $nuevo_pedido_c->dosis = $pedido_c["cantidad"];
                    }
               }
               $req = $pedidos_c;
               $nuevo_pedido_c->fecha_estimada = $pedido_c["fecha_estimada"];
               $nuevo_pedido_c->save();
            }
        }

        $nuevo_consecutivo = new ConsecutivoCia();

        if ($ult_pedido != null)
        {
            if ($ult_pedido != '1')
            {
                $nuevo_consecutivo->consecutivo = $ult_pedido->consecutivo_pedido + 1;
                $consec = $nuevo_consecutivo->consecutivo;
            }
        }
        else
        {
            $nuevo_consecutivo->consecutivo = 1;
            $consec = $nuevo_consecutivo->consecutivo;
        }

        $nuevo_consecutivo->fecha_creacion = $date;
        $nuevo_consecutivo->granja_id = $nuevo_pedido_c->granja_id;
        $nuevo_consecutivo->estado_id = 1;
        $nuevo_consecutivo->fecha_estimada = $nuevo_pedido_c["fecha_estimada"];
        $nuevo_consecutivo->save();

        $tecnicos = User::all();
        $email = "intranet2.0@cercafe.com.co";
        $email2 = "centrodeinseminacion@cercafe.com.co";
        foreach ($tecnicos as $tecnico)
        {
            if($tecnico->email == Auth::User()->email || $tecnico->email == $email || $tecnico->email == $email2)
            {
                Mail::send('admin.messages.notification_pedido_semen',['req' => $req, 'dat' => $date, 'cons' => $consec, 'granjas' => $granjas], function($msj) use($consec,$granja_s,$tecnico)
                {
                    $msj->subject('"Pedido de Semen"' . " " .$granja_s . '   -   ' . 'Solicitud de Semen' . ' | ' . 'Consecutivo: ' . 'PSE'.$consec);
                    $msj->to($tecnico->email);
                });
            }
        }
        flash('Pedido <strong>Enviado</strong> exitosamente!!!')->success();
        return redirect()->route('admin.pedidoProductosCia.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($consecutivo)
    {

    }

    /**
    * permite visualizar mediante un modal la informacion del pedido seleccionado desde la vista
    * consultar_pedido_cia.blade.php
    * @var PedidoCia
    * @var Granja
    * @var ProductoCia
    * @return response()->json(["status"=>"success","data"=>$productos_db,"consecutivo"=>$cons["consecutivo"]],200);
    */

    public function verCia(request $request)
    {
        $productos = PedidoCia::all();
        $granjas = Granja::all();
        $productos_cia = ProductoCia::all();
        $consecutivo = json_decode($request->data, true);

        foreach ($consecutivo as $cons) {
            if ($cons["consecutivo"] != null) {
                foreach ($productos as $producto)
                {
                    if ((int)$cons["consecutivo"] == $producto->consecutivo_pedido)
                    {
                        foreach ($granjas as $granja)
                        {
                           if ($granja->id == $producto->granja_id)
                           {
                               foreach ($productos_cia as $cia)
                               {
                                    if($cia->id == $producto->producto_cia_id)
                                    {
                                        $productos_db[$producto->id]["granja"] = $granja->nombre_granja;
                                        $productos_db[$producto->id]["producto_cia"] = $cia->nombre_producto_cia;
                                        $productos_db[$producto->id]["dosis"] = $producto->dosis;
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
            return response()->json(["status"=>"success","data"=>$productos_db,"consecutivo"=>$cons["consecutivo"]],200);
        }
        else
        {
            flash('<strong>Ha Ocurrido un Error con este Pedido!!!</strong>')->error()->important();
            return redirect()->route('admin.pedidoProductosCia.index');
        }
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
     * permite validar un pedido desde la vista consultar_pedido_cia.blade.php
     *
     * @var PedidoCia
     * @var ConsecutivoCia
     * @var Granja
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $productos = PedidoCia::all();
        $consecutivos = ConsecutivoCia::all();
        $granjas = Granja::all();
        $mod_pedido = json_decode($request->data, true);
        foreach ($mod_pedido as $m)
        {
            foreach ($consecutivos as $consecutivo)
            {
                if ($consecutivo->consecutivo == $m["cons"])
                {
                    $consecutivo->fecha_entrega = $m["fecha"];
                    $consecutivo->estado_id = 2;
                    $consecutivo->save();
                }
            }
        }

        foreach ($productos as $producto)
        {
            if ($producto->consecutivo_pedido == $m["cons"])
            {
                $producto->fecha_entrega = $m["fecha"];

                $producto->estado_id = 2;
                $producto->save();
            }
        }
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
