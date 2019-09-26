<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AsociacionGranja;
use App\Granja;
use App\User;
use App\Http\Requests;
use DB;

class GranjasAsociadasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * esto permite visualizar la vista de los tecnicos o coordinadores que tengan 
     * granjas asociadas 
     *
     * @return view/admin/filros/list_granjas_asociadas.blade.php
     */
    public function index()
    {
        $g_asociadas = DB::table('granjas_asociadas')
                ->join('users', 'granjas_asociadas.user_id', '=', 'users.id')
                ->join('granjas', 'granjas_asociadas.granja_id', '=', 'granjas.id')
                ->select('granjas_asociadas.*', 'users.nombre_completo','granjas.nombre_granja')
                ->get(); 
        return view('admin.filtros.list_granjas_asociadas')->with('g_asociadas', $g_asociadas);
    }

    /**
     * permite acceder a la vista para asociar un tecnico
     * o un coordinador a una granja en especifico
     *
     * @return view/admin/filtros/asociar_granja.blade.php
     */
    public function create()
    {
        $usuarios = User::all();
        $granjas = Granja::all();
        return view('admin.filtros.asociar_granja', compact('usuarios', $usuarios, 'granjas', $granjas)); 
    }

    /**
     * esto permite accederle un permiso a un tecnico y/o asociado 
     * a una granja en especifico
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/filtros/list_granjas_asociadas.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $g_asociada = new AsociacionGranja();
            $usuarios = User::all();
            $granjas = Granja::all();

            foreach ($usuarios as $usuario) 
            {
                if ($usuario->nombre_completo == $request->perfil) 
                {
                    $g_asociada->user_id = $usuario->id;
                    foreach ($granjas as $granja) 
                    {
                        if ($granja->nombre_granja == $request->granja) 
                        {
                            $g_asociada->granja_id = $granja->id;
                        }
                    }
                }
            }
    
            $g_asociada->save();

            flash('Permiso <strong>Concedido</strong> !!!')->success()->important();

            return redirect()->route('admin.asociacionGranjas.index');
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
     * esto permite eliminar el permiso de la granja para
     * para el tecnico y/o asociado.
     *
     * @param  int  $id
     * @return view/admin/filtros/list_granjas_asociadas
     */
    public function destroy($id)
    {
        $asociacion = AsociacionGranja::find($id); 
        $asociacion->delete();

        flash('Permiso Eliminado correctamente!!!')->success()->important();
        return redirect()->route('admin.asociacionGranjas.index');
    }
}
