<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Bitacora;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BitacoraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Esta función permite listar en la vista mi_bitacora
     * todos los archivos existentes en base de datos.
     *
     * @return vista mi_bitacora.blade.php 
     */
    public function index()
    {
        $archivos = Bitacora::all();
        return view('admin.bitacora.mi_bitacora', compact('archivos'));
    }

    /**
     * Esta función permite llamar el formulario para subir
     * un nuevo archivo.
     *
     * @return vista subir_bitacora.blade.php.
     */
    public function create()
    {
        $bitacoras = Bitacora::all();
        return view('admin.bitacora.subir_bitacora')->with('bitacoras', $bitacoras);  
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
        Bitacora::create($request->all()); 
        flash('El archivo se ha guardado exitosamente!!!')->success()->important();
        return redirect()->route('admin.bitacora.index'); 
    }

    /**
    * permite descargar los archivos desde la vista
    * @var varchar $file
    * @return path cualquier tipo de archivo
    */

    public function downloadFile($file)
    {
        $pathtoFile = public_path().'/bitacora/'.$file;
        flash('Archivo descargado!!!')->success()->important();
        return response()->download($pathtoFile);
    }

    /**
     * Show the form for editing the specified resource. |
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
     * Permite Eliminar el archivo seleccionado en mi_bitacora.blade.php.
     *
     * @param  int  $file
     * @return redirect true /views/admin/mi_bitacora.blade.php || false /views/admin/mi_bitacora.blade.php
     */
    public function destroy($file)
    {

        $f = Bitacora::find($file);

        if ($f->path) 
        {
            $f->delete();
            Storage::delete($f->path);
             flash('El archivo se ha eliminado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.bitacora.index');

        }
        else
        {
            return redirect()->route('admin.bitacora.index');
        }
    }
}
