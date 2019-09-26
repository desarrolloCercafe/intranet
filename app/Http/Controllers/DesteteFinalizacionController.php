<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesteteFinalizacion;
use App\AsociacionGranja;
use DB;
use App\User;
use App\Granja;
use App\Http\Requests;
use Mail; 
use Session;
use Carbon\Carbon;
use Auth;

class DesteteFinalizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * esta funcion permite listar en la vista lis_destete_finalizacion.blade.php
     * todos los registros existentes
     *
     * @var AsociacionGranja
     * @var Granja
     * @var DB
     * @return view/admin/granjas/list_destete_finalizacion.blade.php
     */
    public function index()
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $destetes = DB::table('formulario_destete_finalizacion')
            ->join('granjas', 'formulario_destete_finalizacion.granja_id', '=', 'granjas.id')
            ->select('formulario_destete_finalizacion.*', 'granjas.nombre_granja')
            ->get();
        return view('admin.granjas.list_destete_finalizacion', compact('g_as', $g_as, 'granjas', $granjas))->with('destetes', $destetes);
    }

    /**
     * permite llamar al formulario para crear un nuevo registro
     *
     * @var AsociacionGranja
     * @var Granja
     * @return view/admin/granjas/form_destete_finalizacion.blade.php compact $granjas,$g_as
     */
    public function create()
    {
        $bool = [null, false];
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        return view('admin.granjas.form_destete_finalizacion', compact('granjas', 'g_as', 'bool'));
    }

    /**
     * permite crear un nuevo registro en el formulario form_destete_finalizacion.blade.php
     * tambien envia una notificacion al email intranet@cercafe.com.co con la informacion del lote 
     * ingresado por el usuario
     *
     * @var DesteteFinalizacion
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/granjas/form_destete_finalizacion.blade.php | redirect/view/admin/granjas/list_form_destete_finalizacion.blade.php
     */
    public function store(Request $request)
    {
        $destetes_registradas = DesteteFinalizacion::lists('lote','id');

        $lote_destete = New DesteteFinalizacion();
        $lote_destete->lote =  $request->lote;
        $lote_id = $request->lote;
        
        if ($request->granja == null) 
        {
            $bool = [0,false];
            return $bool;
        }
        else
        {
            $lote_destete->granja_id = $request->granja;
        }
        $lote_destete->fecha_ingreso_lote = $request->fecha_ingreso_granja;
        $lote_destete->fecha_salida_lote = $request->fecha_salida_granja;
        $lote_destete->año = $request->año;
        $lote_destete->mes = $request->mes;
        $lote_destete->semana = $request->semana;
        $lote_destete->inic = $request->cant_cerdos_lote;
        $lote_destete->cerdos_descartados = $request->cant_cerdos_descartados;
        $lote_destete->cerdos_livianos = $request->cant_cerdos_livianos;
        $lote_destete->muertes = $request->cant_cerdos_muertos;
        $lote_destete->cant_final_cerdos = $request->cant_cerdos_finales;
        $lote_destete->meta_cerdos = $request->meta_cerdos_entregar;
        $lote_destete->edad_inicial = $request->edad_inicial;
        $lote_destete->edad_inicial_total = $request->edad_inicial_total;
        $lote_destete->dias = $request->dias_granja;
        $lote_destete->dias_permanencia = $request->dias_permanencia_total;
        $lote_destete->edad_final = $request->edad_final;
        $lote_destete->edad_final_total = $request->edad_final_total;
        $lote_destete->conf_edad_final = $request->conf_edad_final;
        $lote_destete->por_mortalidad = $request->mortalidad;
        $lote_destete->por_descartes = $request->descartados;
        $lote_destete->por_livianos = $request->livianos;
        $lote_destete->peso_total_ingresado = $request->peso_cerdos_ingresados;
        $lote_destete->peso_promedio_ingresado = $request->peso_promedio_cerdos_ingresados;
        $lote_destete->peso_total_vendido = $request->peso_cerdos_vendidos;
        $lote_destete->peso_promedio_vendido = $request->peso_promedio_cerdos_vendidos;
        $lote_destete->consumo_lote = $request->consumo_lote;
        $lote_destete->consumo_promedio_lote = $request->consumo_promedio;
        $lote_destete->consumo_promedio_lote_dias = $request->consumo_promedio_dias;
        $lote_destete->cons_promedio_ini = $request->cons_promedio_ini;
        $lote_destete->cons_promedio_dia_ini = $request->cons_promedio_dia_ini;
        $lote_destete->ato_promedio = $request->ato_promedio;
        $lote_destete->ato_promedio_dia = $request->ato_promedio_dia;
        $lote_destete->conversion = $request->conv;
        $lote_destete->save();

        $granjas = Granja::all();
        $tecnicos = User::all();  

        
        foreach($granjas as $granja)
        {
            if($granja->id == $request->granja)
            {
                $granja_s = $granja->nombre_granja; 
            }
        }

        $email = 'intranet2.0@cercafe.com.co';
         if ($request->granja == 1 || $request->granja == 27 || $request->granja == 17 || $request->granja == 12 || $request->granja == 38 || $request->granja == 36 || $request->granja == 48) {
                  
                    Mail::send('admin.messages.notification_finalizacion',$request->all(), function($msj) use($lote_id, $granja_s) 
                { 
                    $emails = [Auth::User()->email, 'hblandonm@cercafe.com.co'];
                    $msj->to($emails)->subject('Granja: ' . $granja_s . '   -   ' . '"DESTETE FINALIZACIÓN"'. '|'. 'Lote: ' . $lote_id);
                });
            }  else {
              foreach ($tecnicos as $tecnico) 
        {
            if($tecnico->email == Auth::User()->email)
            {
                Mail::send('admin.messages.notification_finalizacion',$request->all(), function($msj) use($lote_id,$granja_s,$tecnico)
                { 
                    $msj->subject('Granja: ' . $granja_s . '   -   ' . '"DESTETE FINALIZACIÓN"' . '|'. 'Lote: ' . $lote_id);
                    $msj->to($tecnico->email);
                });
            }
        }
        }


      
        $bool = [1,true];
        return $bool;      
    }

    /**
     * permite obtener inforamcion extra del lote seleccionado en la vista 
     * list_destete_finalizacion.blade.php
     *
     * @var DesteteFinalizacion
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_destete_finalizacion.blade.php compact $granjas with $destete_f
     */
    public function show($id)
    {
        $destete_f = DesteteFinalizacion::find($id);
        $granja = Granja::find($destete_f->granja_id);
        return view('admin.granjas.tabla_destete_finalizacion', compact('granja', $granja))->with('destete_f', $destete_f);
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
     * permite eliminar un lote que fue seleccionado en la vista list_destete_finalizacion.blade.php
     *
     * @var DesteteFinalizacion
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/list_destete_finalizacion.blade.php
     */
    public function destroy($id)
    {
        $lote_finalizacion = DesteteFinalizacion::find($id);
        $granjas = Granja::all();
 
        flash('El Lote <strong>' . $lote_finalizacion->lote . '</strong> ha sido borrado exitosamente!!!')->warning()->important();     
        $lote_finalizacion->delete(); 
        return redirect()->route('admin.desteteFinalizacion.index');
    }
}
