<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\InsumoServicios;
use App\PedidoInsumoServicio;
use App\Http\Requests; 
use App\Iva;
use App\IvaInsumo;
use Mail;
use App\PedidoMedicamento;

class InsumosServiciosController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    /**
     * permite acceder a la vista donde estan todos los productos de la base de datos
     *
     * @var InsumoServicios
     * @return view/admin/insumos/list_insumos_servicions.blade.php with $insumos_servicios
     */
    public function index()
    { 
        $insumos_servicios = InsumoServicios::all();
        return view('admin.insumos.list_insumos_servicios')->with('insumos_servicios', $insumos_servicios);
    }

    /**
     * permite acceder la vista del formulario para la creacion de un producto
     *
     * @return view/admin/insumos/create_insumos_servicios.blade.php
     */
    public function create()
    {
        $valores = Iva::all();
        return view('admin.insumos.create_insumos_servicios')->with('valores', $valores); 
    }

    /**
     * permite crear un nuevo producto en el formulario create_insumos_servicios.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/insumos/list_insumo_servicios.blade.php
     */ 
    public function store(Request $request)
    {
        try
        {
            $insumo_servicio = new InsumoServicios(); 
            $insumo_servicio->ref_insumo = $request->ref_insumo_servicio;
            $insumo_servicio->nombre_insumo = $request->nombre_insumo_servicio;
            $insumo_servicio->tipo_insumo = $request->tipo_insumo_servicio;
            $insumo_servicio->precio_insumo = $request->precio_insumo;
            $insumo_servicio->proveedor_1 = $request->proveedor_1;
            $insumo_servicio->proveedor_2 = $request->proveedor_2;
            $insumo_servicio->proveedor_3 = $request->proveedor_3;
            $insumo_servicio->save();  
            $insumos = InsumoServicios::all();
            $ult_insumo = $insumos->last();

            $new_iva_valor_insumo = new IvaInsumo();
            $new_iva_valor_insumo->insumo_id = $ult_insumo->id;
            $new_iva_valor_insumo->iva_id = $request->iva_id;
            $new_iva_valor_insumo->save();

            $nombre = $request->nombre_insumo;
            $iva = $request->iva_id;
            $valores_iva = Iva::find($iva);
 
            $correos = array("intranetcercafe@cercafe.com.co", "contabilidad@cercafe.com.co", "compras@cercafe.com.co");
            foreach ($correos as $correo)
            {
                Mail::send('admin.messages.new_insumo',['nombre' => $nombre, 'iva' => $valores_iva], function($msj) use($nombre, $valores_iva, $correo)
                {
                    $msj->subject('"Nuevo Insumo"' . " " .'Nombre:'. $nombre . " " . "Iva: " . $valores_iva->valor_iva);
                    $msj->to($correo);
                });
            }

            flash('El Insumo <strong>' . $insumo_servicio->nombre_insumo_servicio . '</strong> ha sido creado exitosamente!!!')->success()->important();

            return redirect()->route('admin.insumosServicios.index');
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
     * permite ir al formulario para editar el producto que fue seleccionado
     * en la vista list_insumo_servicios.blade.php
     *
     * @var InsumoServicios
     * @param  int  $id
     * @return view/admin/insumos/edit_insumos_servicios.blade.php with $insumo_servicio
     */
    public function edit($id)
    {
        $insumo_servicio = InsumoServicios::find($id);
        return view('admin.insumos.edit_insumos_servicios')->with('insumo_servicio', $insumo_servicio); 
    }

    /**
     * permite editar el producto en la vista edit_insumos_servicios.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirect/view/admin/insumos/list_insumos_servicios.blade.php
     */
    public function update(Request $request, $id)
    {
        $insumo_servicio = InsumoServicios::find($id);
        $insumo_servicio->ref_insumo = $request->ref_insumo_servicio;
        $insumo_servicio->nombre_insumo = $request->nombre_insumo_servicio;
        $insumo_servicio->tipo_insumo = $request->tipo_insumo_servicio;
        $insumo_servicio->proveedor_1 = $request->proveedor_1;
        $insumo_servicio->proveedor_2 = $request->proveedor_2;
        $insumo_servicio->proveedor_3 = $request->proveedor_3;
        $insumo_servicio->save();
        flash('El Insumo ' . $insumo_servicio->nombre_insumo . ' ha sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.insumosServicios.index');
    }

    /**
     * permite eliminar el producto seleccionado en la vista list_insumos_servicios.blade.php
     *
     * @var InsumoServicios 
     * @param  int  $id
     * @return redirect/view/admin/insumos/list_insumos_servicios.blade.php
     */
    public function destroy($id)
    {

        // return response()->json(["msg" => $id], 200);

        $insumos = PedidoMedicamento::lists('medicamento_id', 'id');
        $insumo_servicio = InsumoServicios::find($id);
        $cont = 0;
        foreach ($insumos as $ins) 
        {
            if ($ins == $id) 
            { 
                $cont++;
            }
        }
        if ($cont == 0)
        { 
            $insumo_servicio->delete();
            flash('El Insumo <strong>' . $insumo_servicio->nombre_insumo . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
            return redirect()->route('admin.insumosServicios.index');
        }
        else
        {
            $insumo_servicio->disable = 1;
            $insumo_servicio->save();
            flash('Insumo <strong>' . $insumo_servicio->nombre_insumo . 'Deshabilitado</strong>  correctamente')->warning()->important();
            return redirect()->route('admin.insumosServicios.index');
        }
    } 
}
