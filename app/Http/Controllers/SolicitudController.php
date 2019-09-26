<?php

namespace App\Http\Controllers;
use DB;
use App\Estado;
use Mail;
use Session;
use App\Solicitud;
use App\Respuesta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
 
class SolicitudController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    /**
     * permite visualizar la vista list_mis_solicitudes.blade.php con todos las solicitudes
     * realizadas 
     *
     * @return view('admin.solicitud.list_mis_solicitudes')->with('solicitudes', $solicitudes)
     */
    public function index()
    {
        $solicitudes = DB::table('solicitudes')
                    ->join('estados', 'solicitudes.estado_id', '=', 'estados.id')
                    ->join('users', 'solicitudes.emisor_id', '=', 'users.id')
                    ->select('solicitudes.*', 'estados.nombre_estado', 'users.nombre_completo')
                    ->get();
        return view('admin.solicitud.list_mis_solicitudes')->with('solicitudes', $solicitudes);
    }

    /**
     * permite visualizar el formulario create_solicitud.blade.php
     *
     * @var User
     * @return view('admin.solicitud.create_solicitud', compact('agentes', $agentes, 'date', $date, 'users', $users))
     */
    public function create()
    {
        $date = Carbon::now();
        $users = User::all();
        $date->format('d-m-Y');
        $agentes = DB::table('users')
                ->select('users.*')
                ->where('agente', '=', '1')
                ->get();

        if ($agentes)  
        {
            return view('admin.solicitud.create_solicitud', compact('agentes', $agentes, 'date', $date, 'users', $users));
        }
        else
        {
            flash('<strong>NO</strong> existen usuarios agentes actualmente!!!')->error()->important();
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * permite crear una nueva solicitud desde la vista create_solicitud.blade.php, una vez registrada
     * la solicitud se enviara mediante correo electronico la informacion de la solicitud y el nombre
     * de usuario quien haya realizado la solicitud
     *
     * @var Solicitud
     * @param  \Illuminate\Http\Request  $request
     * @return redirect()->route('admin.solicitudes.create');
     */
    public function store(Request $request)
    { 
        $solicitud = new Solicitud;
        $solicitud->emisor_id = $request->id_emisor;
        $solicitud->agente = $request->agente;
        $solicitud->asunto = $request->asunto;
        $solicitud->descripcion_solicitud = $request->descripcion_solicitud;
        $solicitud->fecha_envio = $request->fecha_creacion;
        $solicitud->estado_id = $request->estado;
        $solicitud->prioridad = $request->prioridad;
        if ($request->path == null) 
        {
            $solicitud->path = null;
        }
        else
        {
            $solicitud->path = $request->path;
        }
        
        $solicitud-> save();  
        $email = $request->agente; 

        Mail::send('admin.messages.request_mesa_ayuda', $request->all(), function($msj) use($email)
        {
            $msj->subject('Solicitud...Mesa de Ayuda');
            $msj->to($email);
        });

        flash('Solicitud a <strong>'. $request->agente .'</strong> Enviada correctamente!!!!')->success()->important();
        return redirect()->route('admin.solicitudes.create');
    }

    /**
    * permite descargar un archivo en caso tal de que la solicitud tenga algun archivo adjunto desde
    * la vista ver_solicitud.blade.php
    *
    * @return response()->download($pathtoFile);
    */

    public function downloadAdjunto($file)
    {
        $pathtoFile = public_path().'/adjuntos/'.$file;
        return response()->download($pathtoFile);
    }

    /**
     * permite visualizar toda la informacion del registro seleccionado desde la vista
     * list_mis_soliitudes.blade.php.
     *
     * @var Solicitud
     * @var User
     * @var Estado
     * @var Respuesta
     * @param  int  $id
     * @return view('admin.solicitud.ver_solicitud', compact('estados', $estados, 'user', $user, 'date', $date, 'emisores', $emisores,'respuestas', $respuestas))->with('solicitud', $solicitud);
     */
    public function show($id)
    {
        $solicitud = Solicitud::find($id);
        $user = User::find($solicitud->emisor_id);
        $estados = Estado::find($solicitud->estado_id);

        $date = Carbon::now();
        $date->format('d-m-Y');
        $emisores =  User::all();

        $respuestas = Respuesta::all();

        return view('admin.solicitud.ver_solicitud', compact('estados', $estados, 'user', $user, 'date', $date, 'emisores', $emisores,'respuestas', $respuestas))->with('solicitud', $solicitud);
    }

    /**
    * permite tramitar una solicitud en la vista ver_solicitud.blade.php
    * 
    * @var Solicitud
    * @param int $id
    * @return redirect()->route('admin.solicitudes.index');
    */

    public function tramitado($id)
    {
        $solicitud = Solicitud::find($id);
        $solicitud->estado_id = '2';
        $solicitud->save();
        flash('<strong>Petición Resuelta!!!</strong>')->success()->important();
        return redirect()->route('admin.solicitudes.index');
    }

    /**
    * permite no tramitar una solicitud desde la vista ver_solicitud.blade.php
    *
    * @var Solicitud
    * @param int $id
    * @return redirect()->route('admin.solicitudes.index');
    */

    public function noTramitado($id)
    {
        $solicitud = Solicitud::find($id);
        $solicitud->estado_id = '3';
        $solicitud->save();
        flash('<strong>Petición No Resuelta!!!</strong>')->error()->important();
        return redirect()->route('admin.solicitudes.index');
    }

    /**
    * ESTA FUNCION NO SE ESTA UTILIZANDO 
    */ 

    public function responder($id)
    {
        $date = Carbon::now();
        $date->format('d-m-Y');
        $sol = Solicitud::find($id);
        $emisores =  User::all();
        return view('admin.solicitud.respuesta', compact('emisores', $emisores, 'date', $date))->with('sol', $sol);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function update(Resquest $request, $id)
    {
        
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

    /**
    * permite visualizar la vista recibidos.blade.php con todas las solicitudes que fueron
    * tramitadas
    *
    * @return view('admin.solicitud.recibidos')->with('solicitudes', $solicitudes);
    */

    public function realizadas()
    {
        $solicitudes = DB::table('solicitudes')
                ->join('estados', 'solicitudes.estado_id', '=', 'estados.id')
                ->join('users', 'solicitudes.emisor_id', '=', 'users.id')
                ->select('solicitudes.*', 'estados.nombre_estado', 'users.nombre_completo')
                ->get();
         return view('admin.solicitud.recibidos')->with('solicitudes', $solicitudes);
    }
}
