<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use App\Respuesta; 
use App\Solicitud;
use Session;
use App\User;
use Carbon\Carbon;
use App\Estado;
use App\Http\Requests; 
use App\Http\Controllers\Controller;


class ContestaController extends Controller
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
     * permite responder una peticion a travez de correo electronico en la vista 
     * responder_solicitud.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/list_solicitudes.blade.php
     */
    public function store(Request $request)
    {
        $email = $request->para_agente; 
        Mail::send('admin.messages.responder_solicitud', $request->all(), function($msj) use($email)
        { 
            $msj->subject('Te han Contestado...Mesa de Ayuda');
            $msj->to($email); 
        });

        $respuesta = new Respuesta;
        $respuesta->solicitud_id = $request->solicitud_id;
        $respuesta->redactor = $request->redactor;
        $respuesta->fecha_redaccion = $request->fecha_redaccion;
        $respuesta->descripcion_respuesta = $request->descripcion_respuesta;
        $respuesta->save();

        flash('Has Contestado a <strong>'. $request->para_agente .'</strong> Exitosamente!!!!')->warning()->important();
        return redirect()->route('admin.solicitudes.index');
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
