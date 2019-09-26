<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    /**
     * permite visualizar la vista rescue_pass.blade.php en caso de haber olvidado 
     * la contraseña
     *
     * @return view('admin.auth.rescue_pass');
     */
    public function index()
    {
         return view('admin.auth.rescue_pass');
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
     * permite enviar un correo electronico a sistemas@cercafe.com.co para establecer 
     * la contraseña en caso de haberla olvidado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect()->route('log.index');
     */
    public function store(Request $request)
    {
        Mail::send('admin.auth.message', $request->all(), function($msj)
        {
            $msj->subject('Restablecer Contraseña');
            $msj->to('sistemas@cercafe.com.co'); 
        });
        flash('Mensaje enviado Correctamente'. ' <strong>Espera correo en tu Bandeja de entrada</strong>')->success()->important();
        return redirect()->route('log.index');
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
