<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoCia;
use App\Http\Requests;

class ProductoCiaController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista list_productos_cia.blade.php con los productos ya existentes 
     *
     * @var ProductoCia
     * @return view/admin/cia/list_productos_cia.blade.php with $productos_cia
     */
    public function index() 
    {
        $productos_cia = ProductoCia::all();
        return view('admin.cia.list_productos_cia')->with('productos_cia', $productos_cia);  
    }

    /**
     * permite acceder al formulario create_producto_cia.blade.php
     * para la respectiva creacion del producto
     *
     * @return view/admin/cia/create_producto_cia.blade.php
     */
    public function create()
    {
        return view('admin.cia.create_producto_cia'); 
    }

    /**
     * permite realizar la creacion del producto en el formulario crea_producto_cia.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/cia/list_cia.blade.php
     */
    public function store(Request $request)
    {
        try
        {
            $producto_cia = new ProductoCia(); 
            $producto_cia->ref_producto_cia = $request->ref_producto_cia;
            $producto_cia->nombre_producto_cia = $request->nombre_producto_cia;
            $producto_cia->save();

            flash('El Producto <strong>' . $producto_cia->nombre_producto_cia . '</strong> ha sido creado exitosamente!!!')->success()->important();

            return redirect()->route('admin.productoCia.index');
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
     * permite acceder al formulario edit_cia_blade_php para editar el producto seleccionado.
     *
     * @var ProductoCia
     * @param  int  $id
     * @return view/admin/cia/edit_producto_cia.blade.php with $producto_cia
     */
    public function edit($id)
    {
        $producto_cia = ProductoCia::find($id);
        return view('admin.cia.edit_producto_cia')->with('producto_cia', $producto_cia);
    }

    /**
     * permite actualizar el producto seleccionado en la vista edit_producto_cia.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirect/view/admin/cia/list_cia.blade.php
     */
    public function update(Request $request, $id)
    {
        $producto_cia = ProductoCia::find($id);
        $producto_cia->ref_producto_cia = $request->ref_producto_cia;
        $producto_cia->nombre_producto_cia = $request->nombre_producto_cia;
        $producto_cia->tipo_producto_cia = $request->tipo_producto_cia;
        $producto_cia->save();
        flash('El Producto ' . $producto_cia->nombre_producto_cia . ' ha sido editado exitosamente!!!')->success()->important();
        return redirect()->route('admin.productoCia.index');
    }

    /**
     * permite eliminar el producto seleccionado en list_cia.blade.php.
     *
     * @var ProductoCia
     * @param  int  $id
     * @return redirect/view/admin/cia/list_cia.blade.php
     */
    public function destroy($id)
    {
        $producto_cia = ProductoCia::find($id); 
        $producto_cia->delete();
        flash('El Producto <strong>' . $producto_cia->nombre_medicamento . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
        return redirect()->route('admin.productoCia.index');
    } 
}
