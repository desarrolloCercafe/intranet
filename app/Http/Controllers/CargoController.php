<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo; 
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CargoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite acceder a la vista princiapl de los cargos que tiene actualmente la intranet.
     *
     * @return view/admin/cargo/list_cargos.blade.php
     */
    public function index()
    {
        $cargos = Cargo::all();
        return view('admin.cargo.list_cargos')->with('cargos', $cargos);  
    }

    /**
     * Esta función sirve para acceder al formulario 
     * de crear un nuevo cargo
     *
     * @return view/admin/cargo/create_cargo.blade.php
     */
    public function create()
    {
        return view('admin.cargo.create_cargo'); 
    }

    /**
     * permite crear un nuevo en el formulario create_cargo.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/cargos/list_cargos.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $cargo = new Cargo(); 
            $cargo->nombre_cargo = $request->nombre_cargo;
            $cargo->descripcion_cargo = $request->descripcion_cargo;
            $cargo->save();

            flash('El cargo <strong>' . $cargo->nombre_cargo . '</strong> ha sido creado exitosamente!!!')->success()->important();

            return redirect()->route('admin.cargos.index');
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
     * permite obtener los datos del cargo seleccionado en la vista de list_cargos.blade.php
     *
     * @param  int  $id
     * @return view/admin/cargo/edit_cargo.blade.php
     */
    public function edit($id)
    {
        $cargo = Cargo::find($id);
        return view('admin.cargo.edit_cargo')->with('cargo', $cargo);
    }

    /**
     * permite actualizar los datos del cargo que fueron obtenidos 
     * en list_cargos.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return view/admin/cargos/list_cargos.blade.php
     */
    public function update(Request $request, $id)
    {
        $cargo = Cargo::find($id);
        $cargo->nombre_cargo = $request->nombre_cargo;
        $cargo->descripcion_cargo = $request->descripcion_cargo;
        $cargo->save();
        flash('El cargo ' . $cargo->nombre_cargo . ' ha sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.cargos.index');
    }

    /**
     * permite eliminar el cargo seleccionado en list_cargos.blade.php
     * en caso de que uno o mas usuarios tengan asignados ese cargo
     * no se podra eliminar el cargo seleccionado 
     *
     * @param  int  $id
     * @return view/admin/cargo/list_cargos.blade.php
     */
    public function destroy($id)
    {

        $u = User::lists('cargo_id', 'id');
        $s = 0;
        foreach ($u as $us) 
        {
            if ($us == $id) 
            {
                $s++;
            }   
        }

        $cargo = Cargo::find($id); 

        if ($s == 0) 
        {
            $cargo->delete();
            flash('El cargo <strong>' . $cargo->nombre_cargo . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.cargos.index');
        }
        else 
        {
            flash('El cargo <strong>' . $cargo->nombre_cargo . ' NO</strong> se puede eliminar porque uno o varios usuarios lo tienen en Uso!!!')->error()->important();
            return redirect()->route('admin.cargos.index');
        }
    }
}
