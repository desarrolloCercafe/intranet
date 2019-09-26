<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Granja;
use App\Ceba;
use App\Http\Requests;

class GranjasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * esto permite acceder a la vista de consultar la informacion de las granjas
     * de acuerdo al modulo que desee consultar la informacion
     *
     * @return view/granjas/consultar_info_granjas.blade.php
     */
    public function index()
    {
        return view('admin.granjas.consultar_info_granja');
    }

    /**
     * permite acceder a la vista de ingresar informacion de la granja
     * de acuerdo al modulo que aparece en pantalla
     *
     * @return view/granjas/ingresar_info_granjas.blade.php
     */
    public function create()
    {
        return view('admin.granjas.ingresar_info_granja');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
