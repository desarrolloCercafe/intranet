<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Esta función permite listar en la vista list_areas
     * todos los registros existentes.
     *
     * @return vista list_areas.blade.php
     */
    public function index()
    {
       
        $areas = Area::all();
        return view('admin.area.list_areas')->with('areas', $areas); 
    }

    /**
     * Esta función permite llamar el formulario para crear
     * una nueva area.
     *
     * @return vista create_area.blade.php.
     */
    public function create()
    {
        
        return view('admin.area.create_area');
    }

    /**
     * Esta función permite almacenar en base de datos el nuevo registro
     * ingresado en el formulario create_area.blade.php.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return vista list_area.blade.php || fatal_error.
     */
    public function store(Request $request)
    {
        
        try
        {
            $area = new Area(); 
            $area->nombre_area = $request->nombre_area;
            $area->descripcion_area = $request->descripcion_area;
            $area->save();

            flash('El Area <strong>' . $area->nombre_area . '</strong> a sido creada exitosamente!!!')->success()->important();

            return redirect()->route('admin.areas.index');
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
     * Permite retornar los datos y el formulario de edición de la sede seleccionada.
     *
     * @param  int  $id
     * @return vista edit_area.blade.php 
     */
    public function edit($id)
    {
        /**
         * Se realiza una consulta a base de datos para retornar todos los elementos
         * iguales al parametro $id
         * @var Area
         */
        $area = Area::find($id);
        return view('admin.area.edit_area')->with('area', $area);
    }

    /**
     * Permite Almacenar los cambios realizados al registro seleccionado
     * en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return vista list_area.blade.php 
     */
    public function update(Request $request, $id)
    {
        /**
         * Se realiza una consulta a base de datos para retornar todos los elementos
         * iguales al parametro $id
         * @var Area
         */
        $area = Area::find($id);
        $area->nombre_area = $request->nombre_area;
        $area->descripcion_area = $request->descripcion_area;
        $area->save();
        flash('El Area <strong>' . $area->nombre_area . '</strong> a sido editada exitosamente!!!')->success()->important();
        return redirect()->route('admin.areas.index');
    }

    /**
     * Permite Eliminar el area seleccionada en list_areas.blade.php para su posterior eliminación.
     *
     * @param  int  $id
     * @return vista true list_area.blade.php || false vista list_area.blade.php
     */
    public function destroy($id)
    {
        /**
         * Se realiza una consulta a base de datos para listar todos los elementos
         * iguales al parametro area_id.
         * @var User
         */
        $u = User::lists('area_id', 'id');
        $s = 0;
         /**
         * Se recorre la variable $u para identificar si el $id corresponde a algun
         * registro con el area asignada y así evitar incompatibilidad en la base de datos.
         */
        foreach ($u as $us) 
        {
            if ($us == $id) 
            {
                $s++;
            }   
        }

        /**
         * Se realiza una consulta a base de datos para retornar todos los elementos
         * iguales al parametro $id
         * @var Area
         */
        $area = Area::find($id);

         /**
         * Verifica el contador para validar si no existen datos asociados al $id 
         * del area seleccionada y así evitar o proceder a la eliminación.
         */
        if ($s == 0) 
        {

            $area->delete();
            flash('El Area <strong>' . $area->nombre_area . '</strong a sido borrada exitosamente!!!')->warning()->important();
            return redirect()->route('admin.areas.index');
        }
        else 
        {
            flash('El area <strong>' . $area->nombre_area . ' NO</strong> se puede eliminar porque uno o varios usuarios la tienen en Uso!!!')->error()->important();
            return redirect()->route('admin.areas.index');
        }
    }
}
