<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicamento;
use App\PedidoMedicamento;
use App\Http\Requests;
use App\Iva;
use App\IvaMedicamento;
use Mail;

class MedicamentosController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista con los registros de la base de datos
     *
     * @var Medicamento
     * @return view/admin/medicamentos/list_medicamentos with $medicamentos
     */
    public function index() 
    {
        $medicamentos = Medicamento::all();
        return view('admin.medicamentos.list_medicamentos')->with('medicamentos', $medicamentos);
    } 

    /**
     * permite acceder al formulario para crear un nuevo registro
     *
     * @return view/admin/medicamentos/create_medicamento.blade.php
     */
    public function create()
    { 
        $valores = Iva::all();
        return view('admin.medicamentos.create_medicamento')->with('valores', $valores); 
    }

    /**
     * permite crear un nuevo registro en el formulario create_medicamento.blade.php
     *
     * @var Medicamento
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/medicamentos/list_medicamento.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $medicamento = new Medicamento(); 
            $medicamento->ref_medicamento = $request->ref_medicamento;
            $medicamento->nombre_medicamento = $request->nombre_medicamento;
            $medicamento->tipo_medicamento = $request->tipo_medicamento;
            $medicamento->precio_medicamento = $request->precio_medicamento;
            $medicamento->proveedor_1 = $request->proveedor_1;
            $medicamento->proveedor_2 = $request->proveedor_2;
            $medicamento->proveedor_3 = $request->proveedor_3;
            $medicamento->proveedor_4 = $request->proveedor_4; 
            $medicamento->save();

            $medicamentos = Medicamento::all();
            $ult_medicamento = $medicamentos->last();

            $new_iva_valor_medicamento = new IvaMedicamento();
            $new_iva_valor_medicamento->medicamento_id = $ult_medicamento->id;
            $new_iva_valor_medicamento->iva_id = $request->iva_id;
            $new_iva_valor_medicamento->save();

            $nombre = $request->nombre_medicamento;
            $iva = $request->iva_id;
            $valores_iva = Iva::find($iva);

            $correos = array("intranetcercafe@cercafe.com.co", "contabilidad@cercafe.com.co", "medicamentos@cercafe.com.co");
            foreach ($correos as $correo)
            {
                Mail::send('admin.messages.new_medicamento',['nombre' => $nombre, 'iva' => $valores_iva], function($msj) use($nombre, $valores_iva, $correo)
                {
                    $msj->subject('"Nuevo Medicamento"' . " " .'Nombre:'. $nombre . " " . "Iva: " . $valores_iva->valor_iva);
                    $msj->to($correo);
                });
            }
            flash('El Medicamento <strong>' . $medicamento->nombre_medicamento . '</strong> ha sido creado exitosamente!!!')->success()->important();
            return redirect()->route('admin.medicamentos.index');
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
     * permite ir a la vista de edicion del registro seleccionado en la vista 
     * list_medicamento.blade.php
     *
     * @var Medicamento
     * @param  int  $id
     * @return view/admin/medicamentos/edit_medicamento.blade.php with $medicamento
     */
    public function edit($id)
    {
        $medicamento = Medicamento::find($id);
        return view('admin.medicamentos.edit_medicamento')->with('medicamento', $medicamento);
    }

    /**
     * permite editar el registro en la vista edit_medicamento.blade.php
     *
     * @var Medicamento
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirect/view/admin/medicamentos/list_medicamento.blade.php
     */
    public function update(Request $request, $id)
    {
        $medicamento = Medicamento::find($id);
        $medicamento->ref_medicamento = $request->ref_medicamento;
        $medicamento->nombre_medicamento = $request->nombre_medicamento;
        $medicamento->tipo_medicamento = $request->tipo_medicamento;
        $medicamento->proveedor_1 = $request->proveedor_1;
        $medicamento->proveedor_2 = $request->proveedor_2;
        $medicamento->proveedor_3 = $request->proveedor_3;
        $medicamento->proveedor_4 = $request->proveedor_4;
        $medicamento->save();
        flash('El Medicamento ' . $medicamento->nombre_medicamento . ' ha sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.medicamentos.index');
    }

    /**
     * permite eliminar o deshabilitar el registro seleccionado en la vista list_medicamentos.blade.php
     *
     * @var Medicamento
     * @param  int  $id
     * @return redirect/view/admin/medicamentos/list_medicamentos.blade.php
     */
    public function destroy($id)
    {
        $medicamentos = PedidoMedicamento::lists('medicamento_id', 'id');
        $medicamento = Medicamento::find($id); 
        $cont = 0;
        foreach ($medicamentos as $medic) 
        {
            if ($medic == $id) 
            {
                $cont++;
            }
        }
        if ($cont == 0)
        {
            $medicamento->delete();
            flash('El Medicamento <strong>' . $medicamento->nombre_medicamento . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.medicamentos.index'); 
        }
        else
        {
            $medicamento->disable = 1;
            $medicamento->save();
            flash('Medicamento <strong>' . $medicamento->nombre_medicamento . 'Deshabilitado</strong>  correctamente')->warning()->important();
            return redirect()->route('admin.medicamentos.index');
        }
    }
}
