<?php

namespace App\Http\Controllers;
use App\Area;
use App\Macro;
use App\LinkForm;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\IframeArea;

class EnketoCollectorController extends Controller
{
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
        $areas = Area::all();
        return view('admin.enketo_forms.areas_form', compact('areas', $areas));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.enketo_forms.agradecimientos_form');
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
    public function show($id_area)
    {
        $macros = Macro::all();
        $area_select = $id_area;
        foreach ($macros as $macro)
        {
            if ($macro->area_id == $id_area)
            {
                $macros_seleccionados[$macro->id]["id_macro"] = $macro->id;
                $macros_seleccionados[$macro->id]["proceso"] = $macro->proceso;
            }
        }

        if (!empty($macros_seleccionados) && is_array($macros_seleccionados))
        {
            return view('admin.enketo_forms.listar_macros_form', compact('area_select', $area_select))->with('macros_seleccionados', $macros_seleccionados);
        }
        else
        {
            flash('<strong>No se encuentran Macros para esta Área!!!</strong>')->error()->important();
            return redirect()->route('admin.enketoformscategories.index');
        }
    }

    public function verDashboards()
    {
        return view('admin.enketo_forms.ver_dashboards_generales');
    }

    public function verDashboardsArea($area)
    {
        $areas = Area::all();
        $iframes = IframeArea::all();
        $cont = 0;
        foreach ($iframes as $iframe)
        {
            if ($iframe->area_id == $area)
            {
                $iframes_seleccionados[$iframe->id]['area_id'] = $iframe->area_id;
                $iframes_seleccionados[$iframe->id]['descripcion'] = $iframe->descripcion;
                $iframes_seleccionados[$iframe->id]['iframe'] = $iframe->iframe;
                $iframes_seleccionados[$iframe->id]['iframe2'] = $iframe->iframe2;
                $cont ++;
            }
        }
        if ($cont != 0)
        {
            $iframes_seleccionados = json_decode(json_encode($iframes_seleccionados), true);
            return view('admin.enketo_forms.ver_dashboards_area', compact('areas', $areas, 'area', $area))->with('iframes_seleccionados',   $iframes_seleccionados);
        }
        else
        {
            flash('<strong>No se encuentran Dashboards para el area seleccionada!!!</strong>')->error()->important();
            return redirect()->route('admin.enketoformscategories.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_macro)
    {
        $rutas = LinkForm::all();
        $areas = Area::all();
        $macro = Macro::find($id_macro);
        $id_area = $macro->area_id;
        foreach ($rutas as $ruta)
        {
            if ($ruta->macro_id == $id_macro)
            {
                $ruta_micros[$ruta->id]["id_micro"] = $ruta->id;
                $ruta_micros[$ruta->id]["enlace"] = $ruta->enlace;
                $ruta_micros[$ruta->id]["nombre_documento"] = $ruta->nombre_documento;
            }
        }
        if ( !empty( $ruta_micros) && is_array( $ruta_micros))
        {
            return view('formularios_form', compact('macro', $macro))->with('ruta_micros',  $ruta_micros);
        }
        else
        {
            flash('<strong>No se encuentran Modulos para esta Área!!!</strong>')->error()->important();
            return redirect()->route('admin.enketoformscategories.show', compact('id_area', $id_area));
        }
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
