<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Mail;
use App\Respuesta; 
use App\Solicitud;
use Session;
use App\User;
use Carbon\Carbon;
use App\Estado;
use App\Http\Requests; 
use App\Http\Controllers\Controller;

class MessageController extends Controller
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
     * permite enviar una respuesta desde la vista ver_solicitud.blade.php y tambien llegara
     * al correo de la persona quien solicito la solicitud
     *
     * @param  \Illuminate\Http\Request  $request
     * @return return redirect()->route('admin.solicitudes.index');
     */
    public function store(Request $request)
    {
        $email = $request->para_receptor;
        Mail::send('admin.messages.responder_solicitud', $request->all(), function($msj) use($email)
        {
            $msj->subject('Respuesta...Mesa de Ayuda');
            $msj->to($email);
        });

        $respuesta = new Respuesta; 
        $respuesta->solicitud_id = $request->solicitud_id;
        $respuesta->redactor = $request->redactor;
        $respuesta->fecha_redaccion = $request->fecha_redaccion;
        $respuesta->descripcion_respuesta = $request->descripcion_respuesta;
        $respuesta->save();

        flash('Respuesta para <strong>'. $request->para_receptor .'</strong> Enviada correctamente!!!!')->warning()->important();
        return redirect()->route('admin.solicitudes.index');
    }

    /**
     * permite visualizar la informacion de la solicitud en la vista ver_solicitud.blade.php
     *
     * @var Solicitud
     * @var Estado
     * @var User
     * @param  int  $id
     * @return view('admin.solicitud.ver_solicitud_emisor', compact('estados', $estados, 'date', $date, 'emisores', $emisores,'respuestas', $respuestas, 'agentes', $agentes))->with('solicitud', $solicitud);
     */
    public function show($id)
    {
        $agentes = DB::table('users')
                ->select('users.*')
                ->where('agente', '=', '1') 
                ->get();

        $solicitud = Solicitud::find($id);
        $estados = Estado::find($solicitud->estado_id);
        $date = Carbon::now();
        $date->format('d-m-Y'); 
        $emisores =  User::all();

         $respuestas = Respuesta::all();

        return view('admin.solicitud.ver_solicitud_emisor', compact('estados', $estados, 'date', $date, 'emisores', $emisores,'respuestas', $respuestas, 'agentes', $agentes))->with('solicitud', $solicitud);
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
