<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use App\User;
use App\Sede;
use App\Cargo;
use App\Area;
use App\Rol;
use App\Solicitud;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * menu principal intranet.
     *
     * Esta función permite acceder al menu principal
     * de la intranet una vez el usuario se haya logeado
     * @return vista GET intranet.blade.php
    */
    public function bienvenida()
    {
        return view('admin.intranet');
    }

    /**
     * Esta función permite listar en la vista list_users
     * todos los registros existentes.
     *
     * @return /views/admin/list.blade.php with $users.
     */
    public function index()
    {   /**
         * Se realiza una consulta a las tablas areas, cargos, roles y usuarios para traer
         * toda la información relacionada de todos los usuarios en dichas tablas
         * @var DB
         */
        $users = DB::table('users')
                    ->join('areas', 'users.area_id', '=', 'areas.id')
                    ->join('cargos', 'users.cargo_id', '=', 'cargos.id')
                    ->join('roles', 'users.rol_id', '=', 'roles.id')
                    ->select('users.*', 'areas.nombre_area','cargos.nombre_cargo','roles.nombre_rol')
                    ->get();
        return view('admin.user.list')->with('users', $users);
    }
    
    /**
     * Esta función permite llamar el formulario para crear
     * una nuevo usuario.
     * @var Sede
     * @var Area
     * @var Cargo
     * @var Rol
     * @return /views/admin/create.blade.php. compact  $sedes, $areas, $cargos, $roles
     */
    public function create()
    {
        $sedes = Sede::lists('nombre_sede','id');
        $areas = Area::lists('nombre_area', 'id');
        $cargos = Cargo::lists('nombre_cargo', 'id');
        $roles = Rol::lists('nombre_rol', 'id');
        return view('admin.user.create', compact('rutas', 'sedes', 'areas', 'cargos','roles')); 
    }

    /**
     * Esta función permite almacenar en base de datos el nuevo registro
     * ingresado en el formulario create.blade.php.
     * @var User
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /views/admin/create.blade.php | redirect /views/admin/list.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $users = User::all();

            $user = new User();
            $user->nombre_completo = $request->nombre_completo;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->Password = bcrypt($request->password);
            $user->documento = $request->documento;
            $user->telefono = $request->telefono;
            $user->fecha_nacimiento = $request->fecha_nacimiento;

            if ($request->nombre_completo != null &&  $request->name =! null && $request->email != null && $request->password != null && $request->documento != null && $request->telefono != null && $request->fecha_nacimiento != null && $request->sede != null && $request->area != null && $request->cargo != null && $request->rol != null) 
            {
                foreach ($users as $email)
                {
                    if ($email->email == $request->email) 
                    {
                        flash('El correo Electronico <strong>ya existe</strong>!!!')->error()->important();
                        return redirect()->route('admin.users.create');
                    }
                }
                
                if($request->masculino == '1') 
                {
                    $user->sexo = '1';
                }
                elseif($request->femenino == '1')
                {
                    $user->sexo = '2';
                }
                else
                {
                    flash('Faltan campos por llenar!!!')->error()->important();
                    return redirect()->route('admin.users.create'); 
                }
                
                if ($request->input('agente')) 
                {
                    $user->agente = true;
                } 
                else
                {
                    $user->agente = false;
                }
                $user->sede_id = $request->sede;
                $user->area_id = $request->area;
                $user->cargo_id = $request->cargo;
                $user->rol_id = $request->rol;
                $user->save();
                flash('El usuario <strong>' . $user->name . '</strong> ha sido creado exitosamente!!!')->success()->important();
                return redirect()->route('admin.users.index');     
            }
            else
            {
                flash('Existen <strong>Campos Vacios</strong>!!!')->error()->important();
                return redirect()->route('admin.users.create');
            }
        }    
        catch(Exception $e)
        {
            return "Fatal error - " . $e->getMessage();
        }  
    }

    /**
     * Permite retornar los datos y el formulario de edición del usuario seleccionada..
     * @var Sede
     * @var Area
     * @var Cargo
     * @var Rol
     * @var User
     * @param int  $id
     * @return /views/admin/create.blade.php compact $sedes, $areas, $cargos, $roles with $user
     */
    public function show($id)
    {
        $sedes = Sede::lists('nombre_sede','id');
        $areas = Area::lists('nombre_area', 'id');
        $cargos = Cargo::lists('nombre_cargo', 'id');
        $roles = Rol::lists('nombre_rol', 'id');
        $user = User::find($id);
        return view('admin.user.perfil', compact('sedes','areas','cargos', 'roles'))->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     * @var Sede
     * @var Area
     * @var Cargo
     * @var Rol
     * @var User
     * @param  int  $id
     * @return /views/admin/edit.blade.php. compact  $sedes, $areas, $cargos, $roles with $user
     */
    public function edit($id)
    {
        $sedes = Sede::lists('nombre_sede','id');
        $areas = Area::lists('nombre_area', 'id');
        $cargos = Cargo::lists('nombre_cargo', 'id');
        $roles = Rol::lists('nombre_rol', 'id');
        $user = User::find($id); 
        return view('admin.user.edit', compact('sedes','areas','cargos', 'roles'))->with('user', $user);
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
        $users = User::all();
        $user = User::find($id);
        $user->nombre_completo = $request->nombre_completo;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->documento = $request->documento;
        $user->telefono = $request->telefono;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->sede_id = $request->sede;
        $user->area_id = $request->area;
        $user->cargo_id = $request->cargo;
        $user->rol_id = $request->rol;
         
        $user->save();
        flash('El usuario <strong>' . $user->name . '</strong> ha sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.users.index');
    }

    /**
     * Permite Eliminar el area seleccionada en list_areas.blade.php para su posterior eliminación.
     * @var Solicitud
     * @var User
     * @var int
     * @param  int  $id
     * @return redirect true /views/admin/list.blade.php || false /views/admin/list.blade.php
     */
    public function destroy($id)
    {
        $solicitudes = Solicitud::lists('emisor_id', 'id');
        $cont = 0;
        foreach ($solicitudes as $solicitud) 
        {
            if ($solicitud == $id) 
            {
                $cont++;
            }
        }

        $user = User::find($id);
        if ($cont == 0)
        {
           $user->delete();
            flash('El usuario <strong>' . $user->name . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.users.index');
        }
        else
        {
            flash('El Usuario <strong>' . $user->nombre_completo . ' NO</strong> se puede eliminar porque una o varias solicitudes lo tienen en Uso!!!')->error()->important();
            return redirect()->route('admin.users.index');
        }
    }
}
