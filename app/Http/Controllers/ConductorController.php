<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conductor;
use App\Http\Requests;

class ConductorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite ir a la vista con los registros ya existentes en la base de datos
     *
     * @var Conductor
     * @return view/admin/conductores/list_conductores with $conductores
     */
    public function index()
    {
        $conductores = Conductor::all();
        return view('admin.conductores.list_conductores')->with('conductores', $conductores);
    }

    /**
     * permite ir a la vista del formulario para crear un nuevo registro en la base de datos
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.conductores.create_conductor'); 
    }

    /**
     * permite crear un nuevo registro en la base de datos desde el formulario
     * create_conductor.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/list_conducotres.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $conductor = new Conductor(); 
            $conductor->nombre = $request->nombre_conductor;
            $conductor->telefono = $request->telefono_conductor;
            
            $conductor->save();

            flash('El conductor <strong>' . $conductor->nombre . '</strong> a sido creado exitosamente!!!')->success()->important();

            return redirect()->route('admin.conductores.index');
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
     * permite acceder al formulario de edicion al seleccionar
     * un conductor en la vista list_conductores.blade.php
     *
     * @var Conductor
     * @param  int  $id
     * @return view/conductores/edit_conductor with $conductor
     */
    public function edit($id)
    {
        $conductor = Conductor::find($id);
        return view('admin.conductores.edit_conductor')->with('conductor', $conductor);
    }

    /**
     * permite guardar el registro editado en el formulario edit_conductor.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirect/view/admin/conductores/list_conductores.blade.php
     */
    public function update(Request $request, $id)
    {
        $conductor = Conductor::find($id);
        $conductor->nombre = $request->nombre_conductor;
        $conductor->telefono = $request->telefono_conductor;
        
        $conductor->save();
        flash('El Conductor <strong>' . $conductor->nombre . '</strong> a sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.conductores.index');
    }

    /**
     * permite eliminar el registro seleccionado en la vista list_conductores.blade.php
     *
     * @param  int  $id
     * @return redirect/view/admin/conductores/list_conductores.blade.php
     */
    public function destroy($id)
    {
        $conductor = Conductor::find($id); 
        $conductor->delete();
        flash('El Conductor <strong>' . $conductor->nombre . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
        return redirect()->route('admin.conductores.index');
    }
}
