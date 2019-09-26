<?php

namespace App\Http\Controllers; 

use App\PigWinBackUp;
use App\Granja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

class PigWinBackUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista list_copias_pig_win.blade.php con todos los backups
     * que se estan realizando 
     *
     * @var PigWinBackUp
     * @return view('admin.copiaspigwin.list_copias_pig_win')->with('copias', $copias)
     */
    public function index()
    {
       $copias = DB::table('pigwin_backup')
                    ->join('granjas', 'pigwin_backup.granja_id', '=', 'granjas.id')
                    ->select('pigwin_backup.*', 'granjas.nombre_granja')
                    ->get();
        return view('admin.copiaspigwin.list_copias_pig_win')->with('copias', $copias);
    }

    /**
     * permite visualizar el formulario subir_copia_pig_win.blade.php 
     *
     * @var Granja
     * @return view('admin.copiaspigwin.subir_copia_pig_win', compact('granjas', $granjas, 'date', $date))
     */
    public function create()
    {
        $date = Carbon::now();
        $date->format('d-m-Y');
        $granjas = Granja::lists('nombre_granja', 'id');
        return view('admin.copiaspigwin.subir_copia_pig_win', compact('granjas', $granjas, 'date', $date));
    }

    /**
     * permite registrar el backup con los respectivos datos ingresados desde la vista
     * subir_copia_pig_win.blade.php.
     *
     * @var PigWinBackUp
     * @param  \Illuminate\Http\Request  $request
     * @return redirect()->route('admin.copiaPigWin.index')
     */
    public function store(Request $request)
    {
        
        $copy = new PigWinBackUp();
        $copy->fecha_archivo = $request->fecha_actual;
        $copy->granja_id = $request->granja;
        $copy->nombre_copia = $request->nombre_archivo;
        $copy->nombre_usuario = $request->nombre_usuario;
        $copy->path = $request->path;
        $copy->save();
        flash('El archivo se ha guardado exitosamente!!!')->success();
        return redirect()->route('admin.copiaPigWin.index');
    }

    /**
    * permite descargar el archivo seleccionado en la vista list_copias_pig_win.blade.php
    *
    * @param varchar $file
    * @return response()->download($pathtoFile)
    */

    public function downloadBack($file)
    {
        $pathtoFile = public_path().'/backupPigWin/'.$file;
        flash('Archivo descargado!!!')->success();
        return response()->download($pathtoFile);
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
     * permite eliminar el archivo seleccionado en la vista list_copias_pig_win.blade.php
     *
     * @var PigWinBackUp
     * @param  varchar $file
     * @return \Illuminate\Http\Response
     */
    public function destroy($file)
    {
        $f = PigWinBackUp::find($file);

        if ($f->path) 
        {
            $f->delete();
            Storage::delete($f->path);
            flash('El archivo se ha eliminado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.copiaPigWin.index');

        }
        else
        {
            return redirect()->route('admin.copiaPigWin.index');
        }
    }
}
