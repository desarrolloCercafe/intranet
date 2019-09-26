<?php

namespace App\Http\Controllers;
use Mail;
use DB;
use Carbon\Carbon;
use App\SolicitudComercio;
use App\Estado;
use App\RespuestaComercio;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class RespuestaComercioController extends Controller
{
    /** 
    * permite responder una solicitud desde la vista ver_solicitud.blade.php
    * una vez que la solicitud se haya respondido se enviara mediante correo electronico
    * a la persona que haya enviado la solicitud
    *
    * @var RespuestaComercio
    * @var SolicitudComercio
    * @param Illuminate\Http\Request $request
    * @return redirect()->route('admin.solicitudComercio.index');
    */

    public function store(Request $request)
    {
        $respuesta = new RespuestaComercio;
        $respuesta->solicitud_id = $request->solicitud_id;
        $respuesta->fecha_redaccion = $request->fecha_redaccion;
        $respuesta->descripcion = $request->descripcion_respuesta;
        $respuesta->emisario_id = $request->emisario;
        $respuesta->remember_token = $request->_token;
        $respuesta->save();

        $solicitud = SolicitudComercio::find($request->solicitud_id);
        $solicitud->moderador = $request->moderador;
        $solicitud->estado_id = 2;
        $solicitud->save();

        $emails = explode(',', $request->agente);
        foreach ($emails as $email) {
            Mail::send('admin.mesadeayudacomercial.respuesta_comercio', $request->all(), function($msj) use ($email)
            {
              $msj->from($email);
              $msj->to(Input::get("correo"))->subject('Respuesta...Mesa de Ayuda');
    	    });
        }
        
        flash('<strong>Respuesta para </strong>'. $request->correo.' Enviada Satisfactoriamente')->success()->important();
        return redirect()->route('admin.solicitudComercio.index');
    }

    /**
    * permite validar una solicitud desde la vista ver_solicitud.blade.php una vez recibida
    * la solicitud se enviara mediante correo electronico a la persona que haya realizado la solicitud
    * avisando que su solicitud fue recibida y sera resuelta en dias futuros 
    *
    * @var SolicitudComercio
    * @param Illuminate\Http\Request $request
    * @return redirect()->route('admin.solicitudComercio.index');
    */

    public function recibido(Request $request)
    {
        $emails = explode(',', $request->agente);

        foreach ($emails as $email) {
            Mail::send('admin.mesadeayudacomercial.correo_recibido', $request->all(), function($msj) use ($email)
            {
              $msj->from($email);
              $msj->to(Input::get('correo'))->subject('Su Correo Fue recibido');
            });    
        }

        $recibido = SolicitudComercio::find($request->solicitud_id);
        $recibido->estado_id = 4;
        $recibido->save();

        flash('<strong>Solicitud Recibida</strong>')->info()->important();
        return redirect()->route('admin.solicitudComercio.index'); 
    }
}
