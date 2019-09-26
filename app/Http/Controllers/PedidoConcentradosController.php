<?php
namespace App\Http\Controllers;

use DB;
use Mail;
use Session;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Granja;
use App\AsociacionGranja;
use App\Concentrado;
use App\VehiculoDespacho;
use App\Conductor;
use App\ConsecutivoConcentrado;
use Carbon\Carbon;
use App\PedidoConcentrado;
use App\EntregaConcentrado;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PedidoConcentradosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista consultar_pedido_concentrados.blade.php con todos los
     * pedidos que estan pendientes a tramitar
     *
     * @var AsociacionGranja
     * @var VehiculoDespacho
     * @var Conductor
     * @var Granja
     * @var ConsecutivoConcentrado
     * @return view('admin.pedidos.consultar_pedido_concentrados', compact('granjas', $granjas, 'conductores', $conductores, 'vehiculos', $vehiculos, 'conduct', $conduct, 'vehicul', $vehicul,'g_as',$g_as))->with('pedidos', $pedidos_c);
     */
    public function index()
    {
        $conduct = Conductor::all();
        $g_as = AsociacionGranja::all();
        $vehicul = VehiculoDespacho::all();
        // $consecutivos = ConsecutivoConcentrado::all();
        $granjas = Granja::lists('nombre_granja', 'id');
        $conductores = Conductor::lists('nombre', 'id');
        $vehiculos = VehiculoDespacho::lists('placa', 'id');
        $pedidos_c = DB::table('consecutivos_concentrados')
                ->join('granjas', 'consecutivos_concentrados.granja_id', '=', 'granjas.id')
                ->select('consecutivos_concentrados.*', 'granjas.nombre_granja')
                ->orderBy('consecutivo', "asc")
                ->get();
        return view('admin.pedidos.consultar_pedido_concentrados', compact('granjas', $granjas, 'conductores', $conductores, 'vehiculos', $vehiculos, 'conduct', $conduct, 'vehicul', $vehicul,'g_as',$g_as))->with('pedidos', $pedidos_c);
         // return view('errors.500');
    }

    /**
     * visualiza el formulario pedido_concentrados.blade.php para crear un nuevo pedido
     *
     * @var Granja
     * @var Concentrado
     * @var AsociacionGranja
     * @var VehiculoDespacho
     * @var Conductor
     * @return view('admin.pedidos.pedido_concentrados', compact('granjas', 'g_as', 'conductores', 'vehiculos'))->with('productos', $productos);
     */
    public function create()
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $productos = Concentrado::all();
        $conductores = Conductor::all();
        $vehiculos = VehiculoDespacho::all();
        // $consecutivos = ConsecutivoConcentrado::all();

        return view('admin.pedidos.pedido_concentrados', compact('granjas', 'g_as', 'conductores', 'vehiculos'))->with('productos', $productos);
        // return view('errors.500');
    }

    /**
     * Permite crear un nuevo pedido desde la vista pedidos_concentrados.blade.php,
     * una vez creado el registro se enviara mediante correo electronico el nombre
     * de la granja con el numero del pedido con sus respectivos productos
     *
     * @var PedidoConcentrado
     * @var Concentrado
     * @var Granja
     * @var ConsecutivoConcentrado
     * @param  \Illuminate\Http\Request  $request
     * @return redirect()->route('admin.pedidoConcentrados.create');
     */
    public function store(Request $request)
    {
        $pedidos_concentrado_antiguos = PedidoConcentrado::all();
        $granjas = Granja::all();
        $concentrados = Concentrado::all();
        $consecutivos = ConsecutivoConcentrado::all();
        $ult_consecutivo = $consecutivos->last();
        $cont = 1;

        $date = Carbon::now();
        $date->format('d-m-Y');

        $pedidos_c = json_decode($request->data, true);

        foreach ($pedidos_c as $pedido_c)
        {
            if ($pedido_c["concentrado"] != null)
            {
                $nuevo_pedido_c = new PedidoConcentrado();
                if ($ult_consecutivo != null)
                {
                    if ($ult_consecutivo != '1')
                    {
                        $nuevo_pedido_c->consecutivo_pedido = $ult_consecutivo->consecutivo + 1;
                    }
                }
                else
                {
                    $nuevo_pedido_c->consecutivo_pedido = 1;
                }
                $nuevo_pedido_c->fecha_creacion = $date;
                $nuevo_pedido_c->fecha_entrega = $pedido_c["fecha_entrega"];
                $nuevo_pedido_c->tipo_documento = 'PCT';
                $nuevo_pedido_c->prefijo = 'WEB';


                foreach ($granjas as $granja)
                {
                    if ($granja->id == $pedido_c["granja"])
                    {
                        $nuevo_pedido_c->granja_id = $granja->id;
                        $granja_s = $granja->nombre_granja;
                    }
                }

               foreach ($concentrados as $concentrado)
               {
                    if ($pedido_c["concentrado"] == $concentrado->nombre_concentrado)
                    {
                        $nuevo_pedido_c->concentrado_id = $concentrado->id;
                        $nuevo_pedido_c->estado_id = 1;
                        $nuevo_pedido_c->no_bultos = $pedido_c["cantidad"];

                        if($pedido_c["unidad_medida"] == "Granel")
                        {
                            $nuevo_pedido_c->no_kilos = (int)$pedido_c["kilos_granel"];
                        }
                        else
                        {
                            $nuevo_pedido_c->no_kilos = (int)$pedido_c["kilos_bulto"] * (int)$pedido_c["cantidad"];
                        }
                    }
                }
                $nuevo_pedido_c->fecha_estimada = $pedido_c["fecha_estimada"];
                $f_estima = $pedido_c["fecha_estimada"];
                $req = $pedidos_c;
                $nuevo_pedido_c->save();
            }
        }
        foreach ($req as $r)
        {
            if ($r["concentrado"] == '')
            {
                $cont++;
            }
        }
        if($cont != 1)
        {
            $nuevo_consecutivo = new ConsecutivoConcentrado();
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
            $nuevo_consecutivo->fecha_entrega = $pedido_c["fecha_entrega"];
            $nuevo_consecutivo->hora_entrega = $pedido_c["fecha_entrega"];
            $nuevo_consecutivo->conductor_asignado = $pedido_c["conductor"];
            $nuevo_consecutivo->vehiculo_asignado = $pedido_c["vehiculo"];
            $nuevo_consecutivo->fecha_estimada = $pedido_c["fecha_estimada"];
            $nuevo_consecutivo->granja_id = $nuevo_pedido_c->granja_id;
            $nuevo_consecutivo->estado_id = 1;
            $nuevo_consecutivo->user_id = Auth::User()->id;
            $nuevo_consecutivo->save();

            $tecnicos = User::all();
            $email = "intranet2.0@cercafe.com.co";
            foreach ($tecnicos as $tecnico)
            {
                if($tecnico->email == Auth::User()->email)
                {
                    Mail::send('admin.messages.notification_pedido_concentrado', ['req' => $req, 'dat' => $f_estima, 'cons' => $consec, 'granjas' => $granjas], function($msj) use($consec,$granja_s,$tecnico)
                    {
                        $emails = [Auth::User()->email, 'intranet@cercafe.com.co', 'auxadminplanta@cercafe.com.co'];
                        $msj->to($emails)->subject('"Pedido de Concentrados"' . " " .$granja_s . '   -   ' . 'Solicitud de Concentrados' . ' | ' . 'Consecutivo: ' . 'PCO'.$consec);
                    });
                }
            }

            $diferenciaFechas = DB::select('SELECT TIMESTAMPDIFF(DAY, c.fecha_creacion, c.fecha_estimada) AS dif_dias, c.estado_id FROM consecutivos_concentrados c WHERE c.consecutivo = ?', [$consec]);

            if($diferenciaFechas[0]->dif_dias < 5){
                Mail::send('admin.messages.notificacion_concentrado_decision',[
                'consecutivo'=>$consec, 'usuario'=>Auth::User()->nombre_completo
                ], function($msj){
                            $msj->subject('"Nuevo Pedido Adicional."');
                            //$correos = ['direccionmejoramiento@cercafe.com.co', 'carrique@cercafe.com.co']
                           $correos = ['intranet2.0@cercafe.com.co', 'controller@cercafe.com.co', 'desarrollotic@cercafe.com.co', 'direccionmejoramiento@cercafe.com.co'];
                            $msj->to($correos);
                        });
            }
                /*$fechaFin = strtotime($pedido_c["fecha_estimada"]);
				$fechaInicio = strtotime($date);
				$resultado =$fechaFin - $fechaInicio;
				$diferencia = round($resultado/86400);*/

          /* if($diferencia < 6){
                Mail::send('admin.messages.notificacion_concentrado_decision',[
                'consecutivo'=>$consec, 'usuario'=>Auth::User()->nombre_completo
                ], function($msj){
                            $msj->subject('"Nuevo Pedido Adicional."');
                            //$correos = ['direccionmejoramiento@cercafe.com.co', 'carrique@cercafe.com.co']
                           $correos = ['intranet2.0@cercafe.com.co', 'controller@cercafe.com.co', 'desarrollotic@cercafe.com.co'];
                            $msj->to($correos);
                        });
            }*/



            flash('Pedido <strong>Enviado</strong> exitosamente!!!')->success();
            return redirect()->route('admin.pedidoConcentrados.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(request $request)
    {
        $concentrados = Concentrado::all();
        $pedidos_antiguos = PedidoConcentrado::all();
        $productos_modificados = json_decode($request->data, true);

        foreach ($productos_modificados as $p_modificado)
        {
            if($p_modificado["concentrado"] != null)
            {
                $cons = $p_modificado["codigo"];
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
            if($p_modificado["concentrado"] != null)
            {
                $p_mod = new PedidoConcentrado();
                $p_mod->consecutivo_pedido = $p_modificado["codigo"];
                $p_mod->fecha_entrega = $p_modificado["fecha_entrega"];
                $p_mod->fecha_estimada = $p_modificado["fecha_estimada"];
                $p_mod->fecha_creacion = $p_modificado["fecha_creacion"];
                $p_mod->granja_id = $p_modificado["granja"];
                $p_mod->tipo_documento = 'PCT';
                $p_mod->prefijo = 'WEB';

                foreach ($concentrados as $concentrado)
                {
                    if ($p_modificado["concentrado"] == $concentrado->nombre_concentrado)
                    {
                        $p_mod->concentrado_id = $concentrado->id;
                    }
                    else
                    {

                    }
                }
                $p_mod->estado_id = 1;
                $p_mod->no_bultos = $p_modificado["cantidad"];

                if($p_modificado["unidad_medida"] == "kilos")
                {
                    $p_mod->no_kilos = (int)$p_modificado["kilos_granel"];
                }
                else
                {
                    $p_mod->no_kilos = (int)$p_modificado["kilos_bulto"] * (int)$p_modificado["cantidad"];
                }
                $p_mod->save();
            }
        }

        $tecnicos = User::all();
        $email = "intranet@cercafe.com.co";
        $granjas = Granja::all();;
        foreach ($tecnicos as $tecnico)
        {
            if($tecnico->email == Auth::User()->email || $tecnico->email == $email || $tecnico->email == 'concentrados@cercafe.com.co' || $tecnico->email == 'auxadminplanta@cercafe.com.co')
            {
                Mail::send('admin.messages.notification_modification_concentrados',['cons' => $cons, 'granjas' => $granjas, 'req' => $productos_modificados], function($msj) use($cons,$tecnico)
                {
                    $msj->subject('Modificacion de Concentrados' . ' | ' . 'Consecutivo: ' . 'PCO'.$cons);
                    $msj->to($tecnico->email);
                });
            }
        }

        flash('El pedido <strong>' . 'PME'.$cons . '</strong> ha sido Modificado exitosamente!!!')->warning()->important();
        return redirect()->route('admin.pedidoMedicamentos.index');
    }

    /**
    * permite visualizar mediante un modal la informacion del pedido seleccionado
    * desde la vista consultar_pedido_concentrados.blade.php
    *
    * @var PedidoConcentrado
    * @var Granja
    * @var Concentrado
    * @param  \Illuminate\Http\Request  $request
    * @return return response()->json(['status'=>'success','data'=>$productos_db,'consecutivo'=>$cons["consecutivo"]],200);
    */

    public function verPedido(request $request)
    {
        $productos = PedidoConcentrado::all();
        $granjas = Granja::all();
        $concentrados = Concentrado::all();
        $consecutivo = json_decode($request->data, true);


       $dataPedido = DB::select('SELECT  g.nombre_granja, ct.nombre_concentrado, pc.no_bultos, pc.no_kilos  FROM consecutivos_concentrados c, pedido_concentrados pc, granjas g, concentrados ct where c.consecutivo = pc.consecutivo_pedido AND g.id = c.granja_id AND ct.id = pc.concentrado_id AND c.consecutivo = ?', [$consecutivo[0]['consecutivo']]);

       $diferenciaFechas = DB::select('SELECT TIMESTAMPDIFF(DAY, c.fecha_creacion, c.fecha_estimada) AS dif_dias, c.estado_id FROM consecutivos_concentrados c WHERE c.consecutivo = ?', [$consecutivo[0]['consecutivo']]);

        return response()->json(['status'=>'success', 'consecutivo'=>$consecutivo[0], 'data'=>$dataPedido, 'diferenciaFechas' =>$diferenciaFechas], 200);
        //Esto es de Cristian: return response()->json([['status'=>'success', 'data'=>$consecutivo[0]]], 200);
        if ( !empty($productos_db) && is_array($productos_db))
        {
            return response()->json(['status'=>'success','data'=>$productos_db,'consecutivo'=>$cons["consecutivo"]],200);
        }
        else
        {
            flash('<strong>Ha Ocurrido un Error con este Pedido!!!</strong>')->error()->important();
            return redirect()->route('admin.pedidoConcentrados.index');
        }
    }

    public function agregarProductosConcentrados($cons)
    {
        $productos_pedido = PedidoConcentrado::all();
        $concentrados = Concentrado::all();
        foreach ($productos_pedido as $p)
        {
            if ($p->consecutivo_pedido == $cons)
            {
                $productos_db[$p->id]["id_concentrado"] = $p->concentrado_id;
                $productos_db[$p->id]["bultos"] = $p->no_bultos;
                $productos_db[$p->id]["kilos"] = $p->no_kilos;
                $g = $p->granja_id;
                $fecha = $p->fecha_creacion;
                $fecha_estimada = $p->fecha_estimada;
            }
        }

        $productos_db = json_decode(json_encode($productos_db), true);

        foreach ($productos_db as $k)
        {
            foreach ($concentrados as $con)
            {
                if ($con->id == $k["id_concentrado"])
                {
                    $pr_db[$con->id]["id"] = $con->id;
                    $pr_db[$con->id]["codigo"] = $con->ref_concentrado;
                    $pr_db[$con->id]["descripcion"] = $con->nombre_concentrado;
                    $pr_db[$con->id]["unidad_medida"] = $con->unidad_medida;
                    $pr_db[$con->id]["bultos"] = $k["bultos"];
                    $pr_db[$con->id]["kilos"] = $k["kilos"];
                }
            }
        }
        $pr_db = json_decode(json_encode($pr_db), true);

        $consecutivos = ConsecutivoConcentrado::all();
        foreach ($consecutivos as $consecutivo)
        {
            if ($consecutivo->consecutivo == $cons)
            {
                $consecutivo = $cons;
                $g_as = AsociacionGranja::all();
                $granjas = Granja::all();
                $productos = Concentrado::all();
                return view('admin.pedidos.alterar_pedidos_medicamentos.agregar_producto_concentrados', compact('granjas', 'g_as', 'consecutivo', 'productos', 'g', 'fecha', 'fecha_estimada'))->with('pr_db', $pr_db);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * permite tramitar un pedido desde la vista consultar_pedido_concentrados.blade.php
     * una vez tramitado el pedido se enviara mediante correo electronico para avisarle al usuario
     * que su pedido fue tramitado con exito
     *
     * @var PedidoConcentrado
     * @var Conductor
     * @var User
     * @var VehiculoDespacho
     * @var ConsecutivoConcentrado
     * @var Granja
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $productos = PedidoConcentrado::all();
        $conductores = Conductor::all();
        $usuarios = User::all();
        $vehiculos = VehiculoDespacho::all();
        $consecutivos = ConsecutivoConcentrado::all();
        $granjas = Granja::all();
        $mod_pedido = json_decode($request->data, true);

        //Validamos que los campos hayan sido enviados
        if($mod_pedido[0]["fecha"] != "por verificar" && $mod_pedido[0]["cond"] != "por verificar" && $mod_pedido[0]["placa"] != "por verificar"){

                //Procedemos a verificar el tipo de pedido
                $fechaFin = strtotime($mod_pedido[0]["fecha_estimada"]);
				$fechaInicio = strtotime($mod_pedido[0]["fecha_creacion"]);
				$resultado =$fechaFin - $fechaInicio;
				$diferencia = round($resultado/86400);

                if($diferencia < 5){
                    $estadoActual = DB::select('SELECT estado_id as estado FROM consecutivos_concentrados where consecutivo = ?', [$mod_pedido[0]["cons"]]);

                    if($estadoActual[0]->estado == 1){
                        $estado = 6;
                    }elseif ($estadoActual[0]->estado == 7) {
                       $estado = 9;
                    }
                }else{
                    $estado = 2;
                }

                $dataConductorVehiculo = DB::select('SELECT vh.placa, cond.nombre FROM vehiculos_despacho vh, conductores cond WHERE vh.id = ? AND cond.id = ?', [$mod_pedido[0]["placa"], $mod_pedido[0]["cond"]]);

                //Actualizamos al pedido con el consecutivo obtenido
                DB::update('UPDATE consecutivos_concentrados SET estado_id = ?, fecha_entrega = ?, conductor_asignado = ?, vehiculo_asignado = ? WHERE consecutivo = ?', [$estado, $mod_pedido[0]["fecha"], $dataConductorVehiculo[0]->nombre, $dataConductorVehiculo[0]->placa, $mod_pedido[0]["cons"]]);

                //Actualizamos los productos asignados al consecutivo del pedido
                DB::update('UPDATE pedido_concentrados SET estado_id = ?, fecha_entrega = ? WHERE consecutivo_pedido = ?', [$estado, $mod_pedido[0]["fecha"], $mod_pedido[0]["cons"]]);

                $adicionales = DB::select('SELECT cond.nombre, vh.placa, c.consecutivo, g.nombre_granja, c.user_id FROM
consecutivos_concentrados c, granjas g, vehiculos_despacho vh, conductores cond WHERE
c.consecutivo = ? AND c.granja_id = g.id AND c.conductor_asignado = cond.id AND vh.id = c.vehiculo_asignado', [$mod_pedido[0]["cons"]]);

                $contador = DB::select('SELECT COUNT(id) as contador FROM entrega_pedidos_concentrado WHERE consecutivo_id = ?', [$mod_pedido[0]["cons"]]);

                 $fecha_seleccionada  = $mod_pedido[0]["fecha"]." "."00:00:00";

                if($contador[0]->contador > 0){
                    DB::update('UPDATE users SET fecha_seleccionada = ?, granja = ?, vehiculo_seleccionado = ?, conductor_seleccionado = ? WHERE consecutivo_id = ?', [$fecha_seleccionada,$adicionales[0]->nombre_granja, $dataConductorVehiculo[0]->placa, $dataConductorVehiculo[0]->nombre, $mod_pedido[0]["cons"]]);
                }else{
                    DB::insert('INSERT INTO entrega_pedidos_concentrado (consecutivo_id, fecha_seleccionada, granja, vehiculo_seleccionado, conductor_seleccionado) values (?, ?, ?, ?, ?)', [$mod_pedido[0]["cons"], $fecha_seleccionada, $adicionales[0]->nombre_granja, $dataConductorVehiculo[0]->placa, $dataConductorVehiculo[0]->nombre]);
                }

                //Obtenemos el correo del usuario
                $usuarioData = DB::select('SELECT u.email FROM users u WHERE u.id = ?', [$adicionales[0]->user_id]);

                $consecutivoPedido = $mod_pedido[0]["cons"];

                //Enviamos el correo al usuario que generó el pedido
               if($estado == 2){
                     Mail::send('admin.messages.notification_pedido_concentrado_modificado',['consecutivo'=>$consecutivoPedido, 'accion'=>'APROBADO'], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Aprobado"');
                            $msj->to($usuarioData->email);
                        });
                }elseif($estado == 6){
                     Mail::send('admin.messages.notification_pedido_concentrado_modificado',['consecutivo'=>$consecutivoPedido, 'accion' =>'TRAMITADO'], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue tramitado y esta a la espera de ser aceptado o rechazado."');
                            $msj->to($usuarioData->email);
                        });
                }elseif($estado == 9){
                        Mail::send('admin.messages.notification_pedido_concentrado_modificado',['consecutivo'=>$consecutivoPedido, 'accion' =>'TRAMITADO'], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue tramitado y aceptado."');
                            $msj->to($usuarioData->email);
                        });
                }
        }
    }

    public function decisionPedido(Request $request){

        $conductores = Conductor::all();
        $vehiculos = VehiculoDespacho::all();
        $granjas = Granja::all();

        header("Content-Type: application/json");
        $filtros = json_decode(stripslashes(file_get_contents("php://input")));
        $filtros = json_decode(stripslashes($request->data));

        $estadoActual = DB::select('SELECT estado_id as estado FROM consecutivos_concentrados where consecutivo = ?', [$filtros->consecutivo]);

        if($estadoActual[0]->estado == 1){

            if($filtros->decision == 1){
                $nuevoEstado = 7;
            }else{
                $nuevoEstado = 8;
            }

            DB::update('UPDATE consecutivos_concentrados SET estado_id = ? WHERE consecutivo = ?', [$nuevoEstado, $filtros->consecutivo]);

            DB::update('UPDATE pedido_concentrados SET estado_id = ? WHERE consecutivo_pedido = ?', [$nuevoEstado, $filtros->consecutivo]);

            $usuarioData = DB::select('SELECT u.email FROM users u, consecutivos_concentrados c WHERE c.user_id = u.id AND c.consecutivo = ?', [$filtros->consecutivo]);

            $mod_pedido = DB::select('SELECT consecutivo, fecha_entrega  FROM consecutivos_concentrados WHERE consecutivo = ?', [$filtros->consecutivo]);

            $consecutivo = $mod_pedido[0]->consecutivo;

            if($nuevoEstado == 7){
                 Mail::send('admin.messages.notification_pedido_concentrado_modificado',[
                 'accion'=>"APROBADO", 'consecutivo'=>$consecutivo
                ], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Aprobado"');
                            $msj->to($usuarioData[0]->email);
                        });
            }else{
                Mail::send('admin.messages.notification_pedido_concentrado_modificado',[
                'accion'=>"RECHAZADO", 'consecutivo'=>$consecutivo
                ], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Rechazado"');
                            $msj->to($usuarioData[0]->email);
                        });
            }
        }elseif ($estadoActual[0]->estado == 7 && $filtros->decision == 2) {
            $nuevoEstado = 8;

            DB::update('UPDATE consecutivos_concentrados SET estado_id = ? WHERE consecutivo = ?', [$nuevoEstado, $filtros->consecutivo]);

            DB::update('UPDATE pedido_concentrados SET estado_id = ? WHERE consecutivo_pedido = ?', [$nuevoEstado, $filtros->consecutivo]);

            $usuarioData = DB::select('SELECT u.email FROM users u, consecutivos_concentrados c WHERE c.user_id = u.id AND c.consecutivo = ?', [$filtros->consecutivo]);

            $mod_pedido = DB::select('SELECT consecutivo, fecha_entrega  FROM consecutivos_concentrados WHERE consecutivo = ?', [$filtros->consecutivo]);

            $consecutivo = $mod_pedido[0]->consecutivo;

                Mail::send('admin.messages.notification_pedido_concentrado_modificado',[
                'accion'=>"RECHAZADO", 'consecutivo'=>$consecutivo
                ], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Rechazado"');
                            $msj->to($usuarioData[0]->email);
                        });
        }elseif($estadoActual[0]->estado == 6){

            if($filtros->decision == 1){
                $nuevoEstado = 9;
            }else{
                $nuevoEstado = 8;
            }

            DB::update('UPDATE consecutivos_concentrados SET estado_id = ? WHERE consecutivo = ?', [$nuevoEstado, $filtros->consecutivo]);

            DB::update('UPDATE pedido_concentrados SET estado_id = ? WHERE consecutivo_pedido = ?', [$nuevoEstado, $filtros->consecutivo]);

            $usuarioData = DB::select('SELECT u.email FROM users u, consecutivos_concentrados c WHERE c.user_id = u.id AND c.consecutivo = ?', [$filtros->consecutivo]);

            $mod_pedido = DB::select('SELECT consecutivo, fecha_entrega  FROM consecutivos_concentrados WHERE consecutivo = ?', [$filtros->consecutivo]);

            $consecutivo = $mod_pedido[0]->consecutivo;

            if($nuevoEstado == 9){
                 Mail::send('admin.messages.notification_pedido_concentrado_modificado',[
                 'accion'=>"APROBADO", 'consecutivo'=>$consecutivo
                ], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Aprobado"');
                            $msj->to($usuarioData[0]->email);
                        });
            }else{
                Mail::send('admin.messages.notification_pedido_concentrado_modificado',[
                'accion'=>"RECHAZADO", 'consecutivo'=>$consecutivo
                ], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Rechazado"');
                            $msj->to($usuarioData[0]->email);
                        });
            }
        }
        /*
        DB::update('UPDATE consecutivos_concentrados SET estado_id = ? WHERE consecutivo = ?', [$filtros->decision, $filtros->consecutivo]);

        DB::update('UPDATE pedido_concentrados SET estado_id = ? WHERE consecutivo_pedido = ?', [$filtros->decision, $filtros->consecutivo]);

        $usuarioData = DB::select('SELECT u.email FROM users u, consecutivos_concentrados c WHERE c.user_id = u.id AND c.consecutivo = ?', [$filtros->consecutivo]);

        $mod_pedido = DB::select('SELECT consecutivo, fecha_entrega  FROM consecutivos_concentrados WHERE consecutivo = ?', [$filtros->consecutivo]);

        $consecutivo = $mod_pedido[0]->consecutivo;

        if($filtros->decision == 7){
            Mail::send('admin.messages.notification_pedido_concentrado_modificado',[
                'accion'=>"APROBADO", 'consecutivo'=>$consecutivo
            ], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Aprobado"');
                            $msj->to($usuarioData[0]->email);
                        });
        }else{
            Mail::send('admin.messages.notification_pedido_concentrado_modificado',[
                'accion'=>"RECHAZADO", 'consecutivo'=>$consecutivo
            ], function($msj) use($usuarioData)
                        {
                            $msj->subject('"Tu pedido de Concentrados fue Rechazado"');
                            $msj->to($usuarioData[0]->email);
                        });
        }*/

    }

    /*public function verificarEstado(Request $request){
        header("Content-Type: application/json");
        $filtros = json_decode(stripslashes(file_get_contents("php://input")));
        $filtros = json_decode(stripslashes($request->data));


    }*/

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

















































































































































