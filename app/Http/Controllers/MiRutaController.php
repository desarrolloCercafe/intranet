<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Auth;
use App\RutaUsuario;
use App\Ruta;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MiRutaController extends Controller
{
    /**
    * ESTE CONTROLADOR NO ESTA EN USO
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruts = DB::table('rutasUsuario') 
                ->join('users', 'rutasUsuario.usuario_id', '=', 'users.id')
                ->join('rutas', 'rutasUsuario.ruta_id', '=', 'rutas.id')
                ->select('rutasUsuario.*', 'rutas.nombre_ruta','rutas.ruta')
                ->where('usuario_id', '=' , Auth::user()->id)
                ->get();
        return view('admin.mis.list_misrutas')->with('ruts', $ruts);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $rutaSelect = Ruta::find($id);
        return view('admin.mis.ruta_select')->with('rutaSelect', $rutaSelect); 
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
