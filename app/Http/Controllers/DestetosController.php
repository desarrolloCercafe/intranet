<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Granja;
use App\User;
use Input;
use DB;
use App\DestetosSemana;
use App\AsociacionGranja;
use App\Http\Requests;
use Mail; 
use Session;
use Carbon\Carbon;

class DestetosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista list_destetots_semana.blade.php
     * con los registros de la base de datos
     *
     * @var AsociacionGranja
     * @var Granja
     * @var DB
     * @return view/admin/granjas/list_destetos_semana.blade.php compact $g_as,$granjas with $destetos_semana
     */
    public function index() 
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $destetos_semana = DB::table('formulario_destetos_semana')
            ->join('granjas', 'formulario_destetos_semana.granja_cria_id', '=', 'granjas.id')
            ->select('formulario_destetos_semana.*', 'granjas.nombre_granja')
            ->get();
        return view('admin.granjas.list_destetos_semana', compact('g_as', $g_as, 'granjas', $granjas))->with('destetos_semana', $destetos_semana);
    } 

    /**
     * permite cargar la vista del formulario para ingresar los datos
     *
     * @var AsociacionGranja
     * @var Granja
     * @return view/admin/granjas/form_destetos_semana.blade.php compact $granjas,$g_as
     */
    public function create()
    {
        $bool = [null, false];
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        return view('admin.granjas.form_destetos_semana', compact('granjas', 'g_as', 'bool'));
    } 

    /**
     *permite registrar la nueva informacion que se esta ingresando en el formulario 
     *form_destetos_semana.blade.php, una vez registrada la informacion, se enviara al correo
     *intranet@cercafe.com.co una notificacion con el registro de la granja ingresada
     *
     * @var DestetosSemana
     * @var Granja
     * @var User
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/granjas/list_destetos_semana.blade.php
     */
    public function store(Request $request)
    {
        $desteto_semana = New DestetosSemana();
        
        if ($request->granja == null) 
        {
            $bool = [0, false];
            return redirect()->route('admin.destetosSemana.create', compact('bool'));
        }
        else
        {
            $desteto_semana->granja_cria_id = $request->granja;
        }
        $desteto_semana->lote = $request->numero_lote;
        $lote_id = $request->numero_lote;
        $desteto_semana->año_destete = $request->año_destete;
        $desteto_semana->semana_destete = $request->semana_destete;

        $granjas = DB::table('granjas')
            ->select('granjas.*')
            ->get();
        
        foreach ($granjas as $granja)
        {
            if($granja->porcentaje_precebo != null)
            {
                if($granja->id == $request->granja) 
                {
                    $desteto_semana->numero_destetos = $request->cant_destetos;
                    $desteto_semana->mortalidad_precebo = $granja->porcentaje_precebo;
                    $desteto_semana->traslado_a_ceba = $request->traslado_ceba;
                    $desteto_semana->cantidad_a_ceba = number_format($desteto_semana->numero_destetos - $desteto_semana->mortalidad_precebo);
                } 
            }

            if($granja->porcentaje_ceba != null)
            {  
                if($granja->id == $request->granja) 
                {
                    $desteto_semana->mortalidad_ceba = $granja->porcentaje_ceba;
                    $desteto_semana->semana_venta = $request->semana_venta;
                    $desteto_semana->año_venta = $request->año_venta;
                    $desteto_semana->disponibilidad_venta = number_format($desteto_semana->cantidad_a_ceba - $desteto_semana->mortalidad_ceba);
                    $desteto_semana->kilos_venta =  number_format($desteto_semana->disponibilidad_venta * 107.8);
                }
            }
        }
        if ($desteto_semana->mortalidad_precebo == null || $desteto_semana->mortalidad_ceba == null) 
        {
            $bool = [0, false];
            flash('La <strong>granja de cria</strong> seleccionada no es Correcta!!!')->error()->important();
            return redirect()->route('admin.destetosSemana.create', compact('bool'));
        }
        $desteto_semana->semana_1_fase_1 = $request->semana_1_fase_1;
        $desteto_semana->consumo_semana_1_fase_1 = $request->consumo_sem1_fase_1;
        $desteto_semana->semana_2_fase_1 = $request->semana_2_fase_1;
        $desteto_semana->consumo_semana_2_fase_1 = $request->consumo_sem2_fase_1;
        $desteto_semana->semana_1_fase_2 = $request->semana_1_fase_2;
        $desteto_semana->consumo_semana_1_fase_2 = $request->consumo_sem1_fase_2;
        $desteto_semana->semana_2_fase_2 = $request->semana_2_fase_2;
        $desteto_semana->consumo_semana_2_fase_2 = $request->consumo_sem2_fase_2;
        $desteto_semana->semana_1_fase_3 = $request->semana_1_fase_3;
        $desteto_semana->consumo_semana_1_fase_3 = $request->consumo_sem1_fase_3;
        $desteto_semana->semana_2_fase_3 = $request->semana_2_fase_3;
        $desteto_semana->consumo_semana_2_fase_3 = $request->consumo_sem2_fase_3;
        $desteto_semana->semana_3_fase_3 = $request->semana_3_fase_3;
        $desteto_semana->consumo_semana_3_fase_3 = $request->consumo_sem3_fase_3;
        $desteto_semana->semana_1_iniciacion = number_format((int)$desteto_semana->semana_3_fase_3 + 1);
        if ( $desteto_semana->semana_1_iniciacion > 52) 
        {
            $desteto_semana->semana_1_iniciacion = 1;
        }
        $desteto_semana->consumo_semana_1_iniciacion = number_format((1250 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_2_iniciacion = number_format((int)$desteto_semana->semana_1_iniciacion + 1);
        if ( $desteto_semana->semana_2_iniciacion > 52) 
        {
            $desteto_semana->semana_2_iniciacion = 1;
        }
        $desteto_semana->consumo_semana_2_iniciacion = number_format((1350 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_1_levante = number_format((int)$desteto_semana->semana_2_iniciacion + 1);
        if ($desteto_semana->semana_1_levante > 52) 
        {
            $desteto_semana->semana_1_levante = 1;
        }
        $desteto_semana->consumo_semana_1_levante = number_format((1450 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_2_levante = number_format((int)$desteto_semana->semana_1_levante + 1);
        if ($desteto_semana->semana_2_levante > 52) 
        {
            $desteto_semana->semana_2_levante = 1;
        }
        $desteto_semana->consumo_semana_2_levante = number_format((1550 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_3_levante = number_format((int)$desteto_semana->semana_2_levante + 1);
        if ($desteto_semana->semana_3_levante > 52) 
        {
            $desteto_semana->semana_3_levante = 1;
        }
        $desteto_semana->consumo_semana_3_levante = number_format((1650 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_4_levante = number_format((int)$desteto_semana->semana_3_levante + 1);
        if ($desteto_semana->semana_4_levante > 52) 
        {
            $desteto_semana->semana_4_levante = 1;
        }
        $desteto_semana->consumo_semana_4_levante = number_format((1750 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_1_engorde_1 = number_format((int)$desteto_semana->semana_4_levante + 1);
        if ($desteto_semana->semana_1_engorde_1 > 52) 
        {
            $desteto_semana->semana_1_engorde_1 = 1;
        }
        $desteto_semana->consumo_semana_1_engorde_1 = number_format((1850 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_2_engorde_1 = number_format((int)$desteto_semana->semana_1_engorde_1 + 1);
        if ($desteto_semana->semana_2_engorde_1 > 52) 
        {
            $desteto_semana->semana_2_engorde_1 = 1;
        }
        $desteto_semana->consumo_semana_2_engorde_1 = number_format((1950 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_1_engorde_2 = number_format((int)$desteto_semana->semana_2_engorde_1 + 1);
        if ($desteto_semana->semana_1_engorde_2 > 52) 
        {
            $desteto_semana->semana_1_engorde_2 = 1;
        }
        $desteto_semana->consumo_semana_1_engorde_2 = number_format((2050 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_2_engorde_2 = number_format((int)$desteto_semana->semana_1_engorde_2 + 1);
        if ($desteto_semana->semana_2_engorde_2 > 52) 
        {
            $desteto_semana->semana_2_engorde_2 = 1;
        }
        $desteto_semana->consumo_semana_2_engorde_2 = number_format((2150 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_3_engorde_2 = number_format((int)$desteto_semana->semana_2_engorde_2 + 1);
        if ($desteto_semana->semana_3_engorde_2 > 52) 
        {
            $desteto_semana->semana_3_engorde_2 = 1;
        }
        $desteto_semana->consumo_semana_3_engorde_2 = number_format((2250 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->semana_4_engorde_2 = number_format((int)$desteto_semana->semana_3_engorde_2 + 1);
        if ($desteto_semana->semana_4_engorde_2 > 52) 
        {
            $desteto_semana->semana_4_engorde_2 = 1;
        }
        $desteto_semana->consumo_semana_4_engorde_2 = number_format((2350 * (int)$desteto_semana->cantidad_a_ceba * 7)/1000);
        $desteto_semana->save(); 

        $granjas = Granja::all();
        $tecnicos = User::all();  

        
        foreach($granjas as $granja)
        {
            if($granja->id == $request->granja)
            {
                $granja_s = $granja->nombre_granja; 
            }
        }
        $email = 'intranet@cercafe.com.co';
         if ($request->granja == 1 || $request->granja == 27 || $request->granja == 17 || $request->granja == 12 || $request->granja == 38 || $request->granja == 36 || $request->granja == 48) {
                    Mail::send('admin.messages.notification_destetes',$request->all(), function($msj) use($lote_id, $granja_s) 
                { 
                    $emails = [Auth::User()->email, 'hblandonm@cercafe.com.co'];
                    $msj->to($emails)->subject('Granja: ' . $granja_s . '   -   ' . '"DESTETOS SEMANA"'. '|'. 'Lote: ' . $lote_id);
                });
            } else {
              foreach ($tecnicos as $tecnico) 
        {
            if($tecnico->email == Auth::User()->email || $tecnico->email == $email)
            {
                Mail::send('admin.messages.notification_destetes',$request->all(), function($msj) use($lote_id,$granja_s,$tecnico)
                {
                    $msj->subject('Granja: ' . $granja_s . '   -   ' . '"DESTETOS SEMANA"' . ' | ' . 'Lote: ' . $lote_id);
                    $msj->to($tecnico->email);
                });
            }
        }
        }
        $bool = [1, true];
        // flash('registrado <strong>Exitosamente...</strong>')->success()->important();
        // return redirect()->route('admin.destetosSemana.create', compact('bool'));
    }

    /**
     * permite visualizar informacion extra del reigstro que se selecciono en la vista list_destetos_semana.blade.php.
     *
     * @var DestetosSemana
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_destete_semana.blade.php compact $granjas,$desteto_s
     */
    public function show($id)
    {
        $desteto_s = DestetosSemana::find($id);
        $granja = Granja::find($desteto_s->granja_cria_id);
        return view('admin.granjas.tabla_destete_semana', compact('granja', $granja))->with('desteto_s', $desteto_s);
        // echo $desteto_s;
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
     * permite eliminar el lote seleccionado desde la vista list_destetos_semana.blade.php
     *
     * @var DestetosSemana
     * @var Granja
     * @param  int  $id
     * @return redirect/view/admin/granjas/list_destetos_semana.blade.php
     */
    public function destroy($id)
    {
        $lote_semana = DestetosSemana::find($id);
        $lote_semana->delete(); 
        $granjas = Granja::all();
 
        flash('El Lote <strong>' . $lote_semana->lote . '</strong> ha sido borrado exitosamente!!!')->warning()->important();     
        return redirect()->route('admin.destetosSemana.index');
    }
}