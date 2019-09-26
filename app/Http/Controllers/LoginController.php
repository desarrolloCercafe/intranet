<?php

namespace App\Http\Controllers;
use Validator;
use Auth;
use Mail;
use Hash;
use Session;
use Redirect;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    
    /**
     * permite visualizar la vista login.blade.php para poder registrarse 
     *
     * @return view('admin.auth.login')
     */

    public function index()
    {
        return view('admin.auth.login');
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
     * permite acceder a la intranet al logearse en la vista login.blade.php
     * con su usuario y contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirect::to('admin/intranet') || Redirect::to('/log')
     */
    public function store(LoginRequest $request)
    {
        if (Auth::attempt(['name'=>$request['name'], 'password'=>$request['password']])) 
        {
            $this->middleware('auth');
            return Redirect::to('admin/intranet');
        }
        flash('Datos incorrectos!!!')->error()->important();
        return Redirect::to('/log');
    }

    /**
     * permitre visualizar la vista form_restore.blade.php para poder actualizar la 
     * contraseña de cualquier usuario
     *
     * @param  int  $id
     * @return view('admin.auth.form_restore')->with('user', $user)
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.auth.form_restore')->with('user', $user);
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
     * permite actualizar la contraseña del usuario que se selecciono 
     * desde la vista form_restore.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirect()->route('admin.users.index');  || redirect('/public/admin/pass/show')->with('message', 'Credenciales incorrectas');
     */
    public function update(Request $request, $id) 
    {
        if ($request->new_password == $request->repeat_password)
        {
            $correo = $request->email_usuario; 
            $user = new User;
            $user->where('email', '=', $request->email_usuario)
                 ->update(['password' => bcrypt($request->new_password)]); 

            flash('Password cambiado Exitosamente!!!')->success()->important();
            Mail::send('admin.auth.message_post', $request->all(), function($msj) use($correo)
            {
                $msj->subject('Contraseña Reestablecida');
                $msj->to($correo);
            });
            return redirect()->route('admin.users.index');
        }
        else
        {
            return redirect('/public/admin/pass/show')->with('message', 'Credenciales incorrectas');
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
