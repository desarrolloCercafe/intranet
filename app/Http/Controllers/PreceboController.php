<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Granja;
use DB;
use App\AsociacionGranja;
use App\Precebo;
use App\Http\Requests; 
use Mail; 
use Session;
use App\User;
use Carbon\Carbon;
use Auth;
use App\PesoEsperado;

class PreceboController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite acceder a la tabla donde contiene todos los datos de precebo
     *
     * @return view/admin/granjas/list_precebos.blade.php
     */
    public function index()
    {
        
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $precebos = DB::table('formulario_precebo')
                ->join('granjas', 'formulario_precebo.granja_id', '=', 'granjas.id')
                ->select('formulario_precebo.*', 'granjas.nombre_granja')
                ->where('formulario_precebo.año_destete', '>', '2015')
                ->get();
        return view('admin.granjas.list_precebos', compact('g_as', $g_as, 'granjas', $granjas))->with('precebos', $precebos);
    }

    /**
     * permite acceder al formulario de precebo para poder ingresar.
     * la informacion de la granja 
     *
     * @return view/admin/granjas/form_precebo.blade.php
     */
    public function create() 
    {



        $bool = [null, false];
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();

        // dd(json_encode($granjas));

        return view('admin.granjas.form_precebo', compact('granjas', 'g_as', 'bool'));
    }

    /**
     * permite acceder informacion de la granja en el formuario de precebo
     * tambien envia un correo a intranet@cercafe.com.co avisando que fue ingresado
     * un nuevo lote de la granja que fue accedida dicha informacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view/admin/granjas/list_precebos.blade
     */
    public function store(Request $request) 
    {

        $precebo = New Precebo();
        $precebo->lote = $request->lote;
        $lote_id = $request->lote;
        if ($request->granja == null)  
        {
            $bool = [0, false];
            return $bool;
        }
        else
        {
            $precebo->granja_id = $request->granja;
        }
        $precebo->fecha_destete = $request->f_destete;
        $precebo->fecha_traslado = $request->f_traslado;
        $precebo->semana_destete = $request->semana_destete;
        $precebo->semana_traslado = $request->semana_traslado;
        $precebo->año_destete = $request->año_destete;
        $precebo->año_traslado = $request->año_traslado;        
        $precebo->mes_traslado = $request->mes_traslado;
        $precebo->numero_inicial = $request->no_inicial;  
        $precebo->edad_destete = $request->edad_destete;
        $precebo->edad_inicial_total = $request->edad_inicial_total;   
        $precebo->dias_jaulon = $request->dias_jaulon;   
        $precebo->dias_totales_permanencia = $request->dias_totales;  
        $precebo->edad_final =  $request->edad_final;  
        $precebo->edad_final_ajustada = '70';   
        $precebo->peso_esperado = '31';              
        $precebo->numero_muertes = $request->numero_muertes;                             
        $precebo->numero_descartes = $request->numero_descartes;                   
        $precebo->numero_livianos = $request->numero_livianos;                            
        $precebo->numero_final = $request->numero_final;        
        $precebo->porciento_mortalidad =  $request->por_mortalidad;     
        $precebo->porciento_descartes = $request->por_descartes;                
        $precebo->porciento_livianos = $request->por_livianos;               
        $precebo->peso_ini =  $request->peso_ini;               
        $precebo->peso_promedio_ini = $request->peso_promedio_ini;                 
        $precebo->peso_ponderado_ini =  $request->peso_ponderado_ini;               
        $precebo->peso_fin =  $request->peso_fin;               
        $precebo->peso_promedio_fin =  $request->peso_promedio_fin;               
        $precebo->peso_ponderado_fin = $request->peso_ponderado_fin;                
        $precebo->ind_peso_final = $request->ind_peso_final;                
        $precebo->cons_total =  $request->cons_total;               
        $precebo->cons_promedio =  $request->cons_promedio;               
        $precebo->cons_ponderado =  $request->cons_ponderado;               
        $precebo->cons_promedio_dia = $request->cons_promedio_dia;
        $precebo->cons_promedio_ini =  $request->cons_promedio_ini;               
        $precebo->cons_ponderado_ini =  $request->cons_ponderado_ini;               
        $precebo->cons_promedio_dia_ini = $request->cons_promedio_dia_ini; 
        $precebo->cons_ajustado_ini = $request->cons_ajustado_ini;
        $precebo->ato_promedio_ini = $request->ato_promedio_ini; 
        $precebo->ato_promedio_dia_ini = $request->ato_promedio_dia_ini; 
        $precebo->conversion_ini = $request->conversion_ini; 
        $precebo->conversion_ajust_ini = $request->conversion_ajust_ini; 
        $precebo->cons_ajustado_fin = $request->cons_ajustado_fin; 
        $precebo->ato_promedio_fin = $request->ato_promedio_fin; 
        $precebo->ato_promedio_dia_fin = $request->ato_promedio_dia_fin;
        $precebo->conversion_fin = $request->conversion_fin; 
        $precebo->conversion_ajust_fin = $request->conversion_ajust_fin;

        $precebo->RUL_precebo = "0". $request->semana_destete . "-" . substr($request->año_destete,2,2). "-" . "0" . $request->granja_cria . "-" . "0". $request->granja;

        $dias = explode(".", $precebo->dias_jaulon);
        $peso_real =  (int)$precebo->peso_fin;
        $pesos = DB::table('pesos_esperados')
            ->where('edad', '=', (int)$request->edad_final)
            ->get();

            // return response()->json($pesos);

        if ($pesos == null) 
        {
            $precebo->eficiencia = 0;
        }
        else
        {

            $eficiencia = ($request->peso_promedio_fin / $pesos[0]->peso_esperado) * 100;
            $precebo->eficiencia = $eficiencia;
        }
        
        $precebo->save();
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
                  
                    Mail::send('admin.messages.notification_precebo',$request->all(), function($msj) use($lote_id, $granja_s) 
                { 
                    $emails = [Auth::User()->email, 'hblandonm@cercafe.com.co'];
                    $msj->to($emails)->subject('Granja: ' . $granja_s . '   -   ' . '"PRECEBO"'. '|'. 'Lote: ' . $lote_id);
                });
            }   else {
                       foreach ($tecnicos as $tecnico) 
                    {

                         if ($tecnico->email == Auth::User()->email) {
                                Mail::send('admin.messages.notification_precebo',$request->all(), function($msj) use($lote_id, $granja_s,$tecnico)
                            { 
                                $msj->subject('Granja: ' . $granja_s . '   -   ' . '"PRECEBO"'. '|'. 'Lote: ' . $lote_id);
                                $msj->to($tecnico->email);
                            });
                        }
                    }

                }
        $bool = [1, true];
        return $bool;
    }

    /**
     * permite obtener informacion extra del lote que se selecciono en la vista
     * de la tabla de precebo
     *
     * @param  int  $id
     * @return view/admin/granjas/tabla_precebo.blade.php
     */
    public function show($id)
    {
        $precebo_c = Precebo::find($id);
        $granja = Granja::find($precebo_c->granja_id);
        return view('admin.granjas.tabla_precebo', compact('granja', $granja))->with('precebo_c', $precebo_c);
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
     * permite eliminar el lote que se selecciono en la tabla de precebo
     *
     * @param  int  $id
     * @return view/admin/granjas/list_precebos
     */
    public function destroy($id)
    {
        $lote_precebo = Precebo::find($id);
        $granjas = Granja::all();
        $lote_precebo->delete(); 
 
        flash('El Lote <strong>' . $lote_precebo->lote . '</strong> ha sido borrado exitosamente!!!')->warning()->important();     
        return redirect()->route('admin.precebos.index');
    }
}
