<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Concentrado;
use App\PedidoConcentrado; 
use App\Http\Requests;
use App\Iva;
use App\IvaConcentrado;
use Mail;

class ConcentradosController extends Controller
{ 
    public function __construct() 
    {
        $this->middleware('auth');
    } 
    /**
     * permite visualizar la tabla de conenctrados 
     * con los registro existentes en la base de datos
     *
     * @var Concentrado
     * @return view/admin/concentrados/list_concentrados with $concentrados
     */
    public function index() 
    {
        $concentrados = Concentrado::all();
        return view('admin.concentrados.list_concentrados')->with('concentrados', $concentrados);  
    }

    /**
     * permite ir al formulario para crear un nuevo registro 
     *
     * @return view/admin/concentrados/create_concentrado.blade.php
     */
    public function create()
    {
        $valores = Iva::all();
        return view('admin.concentrados.create_concentrado')->with('valores', $valores); 
    }

    /**
     * permite crear un nuevo registro en el formulario create_concentrado.blade.php
     *
     * @var Concentrado
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/concentrados/list_concentrados.blade.php
     */
    public function store(Request $request)
    {
        try
        { 
            $concentrado = new Concentrado();
            $concentrado->ref_concentrado = $request->ref_concentrado;
            $concentrado->nombre_concentrado = $request->nombre_concentrado;
            $concentrado->tipo_concentrado = $request->tipo_concentrado;
            $concentrado->precio = $request->precio_concentrado;
            $concentrado->kg = $request->kg;
            $concentrado->unidad_medida = $request->medida;
            $concentrado->save();

            $concentrados = Concentrado::all();
            $ult_concentrado = $concentrados->last();

            $new_iva_valor_concentrado = new IvaConcentrado();
            $new_iva_valor_concentrado->concentrado_id = $ult_concentrado->id;
            $new_iva_valor_concentrado->iva_id = $request->iva_id;
            $new_iva_valor_concentrado->save();

            $nombre = $request->nombre_concentrado;
            $iva = $request->iva_id;
            $valores_iva = Iva::find($iva);

            $correos = array("intranetcercafe2.0@cercafe.com.co", "contabilidad@cercafe.com.co", "produccion@cercafe.com.co");
            foreach ($correos as $correo)  
            {
                Mail::send('admin.messages.new_concentrado',['nombre' => $nombre, 'iva' => $valores_iva], function($msj) use($nombre, $valores_iva, $correo)
                {
                    $msj->subject('"Nuevo Concentrado"' . " " . 'Nombre: '. $nombre . " " . "Iva: " . $valores_iva->valor_iva);
                    $msj->to($correo);
                });
            }
            flash('El Concentrado <strong>' . $concentrado->nombre_concentrado . '</strong> ha sido creado exitosamente!!!')->success()->important();
            return redirect()->route('admin.concentrados.index');
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
     * permite acceder al formulario de edicion del registro seleccionado 
     *
     * @var Concentrado
     * @param  int  $id
     * @return view/admin/concentrados/edit_concentrados.blade.php
     */
    public function edit($id)
    {
        $concentrado = Concentrado::find($id);
        return view('admin.concentrados.edit_concentrado')->with('concentrado', $concentrado);
    }

    /**
     * permite editar el registro seleccionado en la vista edit_concentrado.blade.php
     *
     * @var Concentrado
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirect/view/admin/concentrados/list_concentrados.blade.php
     */
    public function update(Request $request, $id)
    {
        $concentrado = Concentrado::find($id);
        $concentrado->ref_concentrado = $request->ref_concentrado;
        $concentrado->nombre_concentrado = $request->nombre_concentrado;
        $concentrado->precio = $request->precio_concentrado;
        $concentrado->tipo_concentrado = $request->tipo_concentrado;
        $concentrado->save();
        flash('El Concentrado ' . $concentrado->nombre_concentrado . ' ha sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.concentrados.index');
    }

    /**
     * elimina o deshabilita el registro que fue seleccionado en la vista list_concentrados.blade.php
     *
     * @param  int  $id
     * @return redirect/view/admin/concentrados/list_concentrados.blade.php
     */
    public function destroy($id)
    {
        $concentrados = PedidoConcentrado::lists('concentrado_id', 'id');
        $concentrado = Concentrado::find($id); 
        $cont = 0;
        foreach ($concentrados as $concen) 
        {
            if ($concen == $id) 
            {
                $cont++;
            }
        }
        if ($cont == 0)
        {
            $concentrado->delete();
            flash('El Concentrado <strong>' . $concentrado->nombre_concentrado . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.concentrados.index');
        }
        else
        {
            $concentrado->disable = 1;
            $concentrado->save();
            flash('Concentrado <strong>' . $concentrado->nombre_concentrado . 'Deshabilitado</strong> correctamente')->warning()->important();
            return redirect()->route('admin.concentrados.index');
        } 
    }
}
