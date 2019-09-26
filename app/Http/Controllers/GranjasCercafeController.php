<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Granja;
use Session;
use App\Http\Requests;

class GranjasCercafeController extends Controller
{
	/**
	* Permite visualizar la vista granjas.blade.php con todas las granjas registradas
	*
	* @var Granja
	* @return view('admin.granjas.granjas',compact('granjas',$granjas))
	*/
	public function index(){
		$granjas = Granja::all();
   		return view('admin.granjas.granjas',compact('granjas',$granjas));
	}

	/**
	* permite acceder a la vista create_granjas.blade.php en la que hay un formulario
	* para crear un nuevo registro
	*
	* @return view('admin.granjas.create_granja')
	*/

	public function create(){
   		return view('admin.granjas.create_granja');
	}

	/**
	* permite crear un registro con los datos que se ingresan desde la vista create_granjas.blade.php
	*
	* @var Granja
	* @param Illuminate\Http\Request $request
	* @return redirect()->route('admin.granja.index')
	*/

	public function store(Request $request) {
		$granjas = Granja::all();
		$granja =new Granja;
		$granja->nombre_granja = $request->nombre_granja;
		$granja->descripcion_granja = $request->descripcion_granja;
		$granja->direccion_granja = $request->direccion_granja;
		$granja->numero_contacto_granja = $request->numero_contacto_granja;
		$granja->porcentaje_precebo = $request->porcentaje_precebo;
		$granja->porcentaje_ceba = $request->porcentaje_ceba;
		$granja->save();

		flash('La Granja <strong>' . $request->nombre_granja . '</strong> ha sido Creada exitosamente!!!')->success()->important();
   		return redirect()->route('admin.granja.index');
	}

	/**
	* permite ver la informacion del registro seleccionado desde la vista granjas.blade.php
	* en la vista editar_granja.blade.php
	* 
	* @var Granja
	* @param int $id
	* @return view('admin.granjas.Editar_Granja')->with('granja',$granja)
	*/

	public function show($id){
		$granja = Granja::find($id);
		return view('admin.granjas.editar_granja')->with('granja',$granja);
	}

	/**
	* permite actualizar un registro con los datos mandados desde la vista editar_granja.blade.php
	*
	* @var Granja
	* @param int $id
	* @param \Illuminate\Http\Request  $request
	* @return redirect()->route('admin.granja.index');
	*/

	public function update(Request $request , $id){ 
		$granjas = Granja::all();
		$granja = Granja::find($id);
		$granja->nombre_granja = $request->nombre_granja;
		$granja->descripcion_granja = $request->descripcion_granja;
		$granja->direccion_granja = $request->direccion_granja;
		$granja->numero_contacto_granja = $request->numero_contacto_granja;
		$granja->porcentaje_precebo = $request->porcentaje_precebo;
		$granja->porcentaje_ceba = $request->porcentaje_ceba;
		$granja->save();
		flash('La granja <strong>'.$request->nombre_granja.'</strong> fue Actualizada.')->success()->important();
		return redirect()->route('admin.granja.index');	
	}

	/**
	* permite eliminar un registro seleccionado desde la vista granjas.blade.php
	* @param int $id 
	* @return redirect()->route('admin.granja.index')
	*/

	public function destroy($id){
	 	$granja = Granja::find($id);
		$granja->delete();
        return redirect()->route('admin.granja.index');
	}
}
