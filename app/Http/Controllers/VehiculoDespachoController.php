<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehiculoDespacho;
use App\Http\Requests;

class VehiculoDespachoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Esta función permite listar en la vista list_vehiculos_despacho.blade.php
     * todos los registros existentes.
     * @var VehiculoDespacho
     * @return /views/admin/list_vehiculos_despacho.blade.php with $vehiculos
     */
    public function index()
    {
        $vehiculos = VehiculoDespacho::all();
        return view('admin.vehiculos.list_vehiculos_despacho')->with('vehiculos', $vehiculos);
    }

   /**
     * Esta función permite llamar el formulario create_vehiculo_despacho.blade.php para crear
     * un nuevo vehiculo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return /views/admin/create_vehiculo_despacho.blade.php.
     */
    public function create()
    {
        return view('admin.vehiculos.create_vehiculo_despacho'); 
    }

    /**
     * Esta función permite almacenar en base de datos el nuevo registro
     * ingresado en el formulario create_vehiculo_despacho.blade.php.
     * 
     * @var VehiculoDespacho
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /views/admin/create_vehiculo_despacho.blade.php. | redirect Fatal Error
     */
    public function store(Request $request)
    {
        try
        {
            $vehiculo = new VehiculoDespacho; 
            $vehiculo->placa = $request->placa_vehiculo;
            $vehiculo->capacidad = $request->capacidad_vehiculo;
            
            $vehiculo->save();

            flash('El vehiculo <strong>' . $vehiculo->placa . '</strong> a sido creado exitosamente!!!')->success()->important();

            return redirect()->route('admin.vehiculos.index');
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
     * Permite retornar los datos y el formulario de edición de el vehiculo seleccionado.
     *
     * @param  int  $id
     * @return /views/admin/edit_vehiculo_despacho.blade.php with $vehiculo
     */
    public function edit($id)
    {
        /**
         * Se realiza una consulta a base de datos para retornar todos los elementos
         * iguales al parametro $id
         
         * @var VehiculoDespacho
         */
        $vehiculo = VehiculoDespacho::find($id);
        return view('admin.vehiculos.edit_vehiculo_despacho')->with('vehiculo', $vehiculo);
    }

    /**
    * Permite Almacenar los cambios realizados al registro seleccionado
     * en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirect /views/admin/list_vehiculos_despacho.blade.php 
     */
    public function update(Request $request, $id)
    {
        $vehiculo = VehiculoDespacho::find($id);
        $vehiculo->placa = $request->placa_vehiculo;
        $vehiculo->capacidad = $request->capacidad_vehiculo;
        
        $vehiculo->save();
        flash('El Vehiculo <strong>' . $vehiculo->placa . '</strong> a sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.vehiculos.index');
    }

    /**
     * Permite Eliminar el vehiculo seleccionado en list_vehiculos_despacho.blade.php para su posterior eliminación.
     *
     * @param  int  $id
     * @return redirect true /views/admin/list_vehiculos_despacho.blade.php | false /views/admin/list_vehiculos_despacho.blade.php
     */
    public function destroy($id)
    {
        $vehiculo = VehiculoDespacho::find($id); 
        $vehiculo->delete();
        flash('El Vehiculo <strong>' . $vehiculo->placa . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
        return redirect()->route('admin.vehiculos.index');
    }
}