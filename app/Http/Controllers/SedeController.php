<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sede;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SedeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     *Menus Sedes intranet.
     *
     * Esta funcion se utiliza para acceder
     * al menu de las sedes que posse actualmente cercafe
     *
     * @return view/admin/sede/list_cedes.blade.php
     */
    public function index()
    {
        $sedes = Sede::all();
        return view('admin.sede.list_sedes')->with('sedes', $sedes);  
    }

    /**
     * Vista para Crear una sede.
     *
     * esta funcion sirve para acceder a la vista de crear una nueva sede
     * 
     * @return view/admin/sede/create_sede.blade.php
     */
    public function create()
    {
        return view('admin.sede.create_sede'); 
    }

    /**
     * Crear Sede Intranet.
     *
     * Esta funcion permite crear una nueva sede para la intranet
     * @param  $request
     * @return view/admin/sede/lis_sedes.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $sede = new Sede(); 
            $sede->nombre_sede = $request->nombre_sede;
            $sede->descripcion_sede = $request->descripcion_sede;
            $sede->telefono_sede = $request->telefono_sede;
            
            $sede->save();

            flash('La Sede <strong>' . $sede->nombre_sede . '</strong> a sido creada exitosamente!!!')->success()->important();

            return redirect()->route('admin.sedes.index');
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
     * Ver Sede intranet
     *
     * Esta funcion sirve para ver mas detalladamente
     * La Sede a la que usted haya seleccionado en la vista de sedes
     * @param  int  $id
     * @return view/admin/sede/edit_sede.blade.php
     */
    public function edit($id)
    {
        $sede = Sede::find($id);
        return view('admin.sede.edit_sede')->with('sede', $sede);
    }

    /**
     * Actualizar sede
     *
     * Esta funcion para actualizar los datos de la sede que hayan en la intranet
     * @param  $request
     * @param  int  $id
     * @return view/admin/sedes/list_sedes.blade.php
     */
    public function update(Request $request, $id)
    {
        $sede = Sede::find($id);
        $sede->nombre_sede = $request->nombre_sede;
        $sede->telefono_sede = $request->telefono_sede;
        $sede->descripcion_sede = $request->descripcion_sede;
        
        $sede->save();
        flash('La Sede <strong>' . $sede->nombre_sede . '</strong> a sido editada exitosamente!!!')->success()->important();
        return redirect()->route('admin.sedes.index');
    }

    /**
     * Eliminar Sede
     *
     * Esta función sirve para elminar cualquier tipo de sede
     * pero en caso de que uno o mas usuarios pertenezcan a esta
     * sede no se podrá eliminar dicha sede
     * @param  int  $id
     * @return view/admin/sede/list_sedes.blade.php
     */
    public function destroy($id)
    {
        $u = User::lists('sede_id', 'id');
        $s = 0;
        foreach ($u as $us) 
        {
            if ($us == $id) 
            {
                $s++;
            }   
        }

        $sede = Sede::find($id); 

        if ($s == 0) 
        {
            
            $sede->delete();
            flash('La Sede <strong>' . $sede->nombre_sede . '</strong> ha sido borrada exitosamente!!!')->warning()->important();
            return redirect()->route('admin.sedes.index');
        }
        else 
        {
            
            flash('La Sede <strong>' . $sede->nombre_sede . ' NO</strong> se puede eliminar porque uno o varios usuarios la tienen en Uso!!!')->error()->important();
            return redirect()->route('admin.sedes.index');
        }

    }
}
