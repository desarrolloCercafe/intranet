<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RolController extends Controller 
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * esto permite acceder a la vista de los roles que posee actualmente la intranet
     *
     * @return view/admin/rol/list_roles.blade.php
     */
    public function index()
    {
        $roles = Rol::all();
        return view('admin.rol.list_roles')->with('roles', $roles);
    }

    /**
     * permite acceder a la vista de creacion de roles
     *
     * @return view/admin/rol/create_rol.blade.php
     */
    public function create()
    {
        return view('admin.rol.create_rol'); 
    }

    /**
     * esto permite crear un nuevo rol en la vista de create_col.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/roles/list_roles.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $rol = new Rol(); 
            $rol->nombre_rol = $request->nombre_rol;
            
            $rol->save();

            flash('El Rol <strong>' . $rol->nombre_rol . '</strong> a sido creado exitosamente!!!')->success()->important();

            return redirect()->route('admin.roles.index');
        }
        catch(Exception $e)
        {
            return "Fatal error - " . $e->getMessage();
        }
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
     * esto permite acceder a la vista para editar el rol
     * que fue seleccionado en la vista de roles
     *
     * @param  int  $id
     * @return view/admin/rol/edit_rol.blade.php
     */
    public function edit($id)
    {
        $rol = Rol::find($id);
        return view('admin.rol.edit_rol')->with('rol', $rol);
    }

    /**
     * esto permite editar el rol en la vista edit_roles.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return view/admin/roles/list_roles.blade.php
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);
        $rol->nombre_rol = $request->nombre_rol;
        
        $rol->save();
        flash('El Rol <strong>' . $rol->nombre_rol . '</strong> a sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.roles.index');
    }

    /**
     * esto permite eliminar el rol que fue seleccionado en list_roles.blade.php
     * en caso de que uno o mas usuarios tengan el rol asignado, no se podra eliminar el rol
     *
     * @param  int  $id
     * @return view/admin/roles/list_roles.blade.php
     */
    public function destroy($id)
    {
        $u = User::lists('rol_id', 'id');
        $s = 0;
        foreach ($u as $us) 
        {
            if ($us == $id) 
            {
                $s++;
            }   
        }

        $rol = Rol::find($id); 

        if ($s == 0) 
        {
            
            $rol->delete();
            flash('El Rol <strong>' . $rol->nombre_rol . '</strong> a sido borrado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.roles.index');
        }
        else 
        {
            flash('El Rol <strong>' . $rol->nombre_rol . ' NO</strong> se puede eliminar porque uno o varios usuarios lo tienen en Uso!!!')->error()->important();
            return redirect()->route('admin.roles.index');
        }
    }
}
