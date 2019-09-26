<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Session;
use App\Granja;
use App\AsociacionGranja;
use App\Ceba;
use Carbon\Carbon;
use DB;
use Auth;
use App\User;
use App\Http\Requests;


class CebaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar los datos de la base de datos en la vista lis_cebas.blade.php
     *
     * @var $AsociacionGranja
     * @var $Granja
     * @var $DB
     * @return view/admin/granjas/list_cebas.blade.php with g_as,granjas.cebas
     */
    public function index()
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $cebas = DB::table('formulario_ceba')
                ->join('granjas', 'formulario_ceba.granja_id', '=', 'granjas.id')
                ->select('formulario_ceba.*', 'granjas.nombre_granja')
                ->where('formulario_ceba.año', '>', '2015')
                ->get();
        return view('admin.granjas.list_cebas', compact('g_as', $g_as, 'granjas', $granjas))->with('cebas', $cebas);
    }

    /**
     * permite acceder a la vista formulario_ceba.blade.php
     * para ingresar inforamcion de la granja
     *
     * @var AsociacionGranja
     * @var Granja
     * @return view/admin/granjas/form_ceba.blade.php compact $g_as, $granjas
     */
    public function create()
    {
        $bool = [null, false];
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        return view('admin.granjas.form_ceba', compact('granjas', 'g_as', 'bool'));
    }

    /**
     * permite crear la informacion de la granja en el formulario
     * form_ceba.blade.php, tambien envia un correo al correo electronico intranetcercafe@com.co
     * informando del usuario que haya accedido la inforamcion
     *
     * @var Ceba
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/granjas/form_ceba.blade.php | redirect/view/admin/granjas/list_cebas.blade.php
     */
    public function store(Request $request)
    {
        $date = Carbon::now();
        $date->format('Y-m-d');
        $caracter = '-';
        $var = explode($caracter, $date);

        $registro = DB::select(
            'SELECT * FROM formulario_ceba WHERE año = ? AND mes = ? AND lote = ? AND granja_id = ?',
             [$var[0], (int) $var[1], $request->lote, $request->granja]
        );

        $flag = true;

        if(Count($registro)){
            echo "Ya existe uno igual";
            $flag = false;
        }

       /* $registros = DB::table('formulario_ceba')
            ->where('año', '=', $var[0])
            ->where('mes', '=', (int) $var[1])
            ->get();
        $flag = true;
        foreach ($registros as $registro)
        {
            if ($registro->lote == $request->lote)
            {
                echo "Ya existe uno Igual";
                $flag = false;
            }
        }*/
        if($flag)
        {
            $lote_ceba = New Ceba();
            $lote_ceba->lote = $request->lote;
            $lote_id = $request->lote;
            if ($request->granja == null)
            {
                $bool = [0, false];
                return $bool;
            }
            else
            {
                $lote_ceba->granja_id = $request->granja;
            }
            $lote_ceba->fecha_ingreso_lote = $request->fecha_ingreso_granja;
            $lote_ceba->fecha_salida_lote = $request->fecha_salida_granja;
            $lote_ceba->año = $request->año;
            $lote_ceba->mes = $request->mes;
            $lote_ceba->semana = $request->semana;
            $lote_ceba->inic = $request->cant_cerdos_lote;
            $lote_ceba->cerdos_descartados = $request->cant_cerdos_descartados;
            $lote_ceba->cerdos_livianos = $request->cant_cerdos_livianos;
            $lote_ceba->muertes = $request->cant_cerdos_muertos;
            $lote_ceba->cant_final_cerdos = $request->cant_cerdos_finales;
            $lote_ceba->edad_inicial = $request->edad_inicial;
            $lote_ceba->edad_inicial_total = $request->edad_inicial_total;
            $lote_ceba->dias = $request->dias_granja;
            $lote_ceba->dias_permanencia = $request->dias_permanencia_total;
            $lote_ceba->edad_final = $request->edad_final;
            $lote_ceba->edad_final_total = $request->edad_final_total;
            $lote_ceba->conf_edad_final = $request->conf_edad_final;
            $lote_ceba->por_mortalidad = $request->mortalidad;
            $lote_ceba->por_descartes = $request->descartados;
            $lote_ceba->por_livianos = $request->livianos;
            $lote_ceba->peso_total_ingresado = $request->peso_cerdos_ingresados;
            $lote_ceba->peso_promedio_ingresado = $request->peso_promedio_cerdos_ingresados;
            $lote_ceba->peso_total_vendido = $request->peso_cerdos_vendidos;
            $lote_ceba->peso_promedio_vendido = $request->peso_promedio_cerdos_vendidos;
            $lote_ceba->consumo_lote = $request->consumo_lote;
            $lote_ceba->consumo_promedio_lote = $request->consumo_promedio;
            $lote_ceba->consumo_promedio_lote_dias = $request->consumo_promedio_dias;
            $lote_ceba->cons_promedio_ini = $request->cons_promedio_ini;
            $lote_ceba->cons_promedio_dia_ini = $request->cons_promedio_dia_ini;
            $lote_ceba->cons_ajustado_ini = $request->cons_ajustado_ini;
            $lote_ceba->ato_promedio_ini = $request->ato_promedio_ini;
            $lote_ceba->ato_promedio_dia_ini = $request->ato_promedio_dia_ini;
            $lote_ceba->conversion_ini = $request->conversion_ini;
            $lote_ceba->conversion_ajust_ini = $request->conversion_ajust_ini;
            $lote_ceba->cons_ajustado_fin = $request->cons_ajustado_fin;
            $lote_ceba->ato_promedio_fin = $request->ato_promedio_fin;
            $lote_ceba->ato_promedio_dia_fin = $request->ato_promedio_dia_fin;
            $lote_ceba->conversion_fin = $request->conversion_fin;
            $lote_ceba->conversion_ajust_fin = $request->conversion_ajust_fin;
            $prom_edad_RUL = $request->edad_final_total / 7;
            $semana_nacimiento_RUL = $prom_edad_RUL - $request->semana;
            $lote_ceba->RUL_ceba = "0". $semana_nacimiento_RUL . "-" . "0".substr($request->año,2,2). "-" . "0" . $request->granja_cria . "-" . "0". $request->granja_precebo. "-" . "0". $request->granja;
            $lote_ceba->save();

            $granjas = Granja::all();
            $tecnicos = User::all();

            foreach($granjas as $granja)
            {
                if($granja->id == $request->granja)
                {
                    $granja_s = $granja->nombre_granja;
                }
            }

            $headers = "MIME-Version: 1.0" . "Content-type:text/html;charset=UTF-8";
            $email = 'intranet2.0@cercafe.com.co';
             if ($request->granja == 1 || $request->granja == 27 || $request->granja == 17 || $request->granja == 12 || $request->granja == 38 || $request->granja == 36 || $request->granja == 48 || $request->granja_precebo == 1 || $request->granja_precebo == 27 || $request->granja_precebo == 17 || $request->granja_precebo == 12 || $request->granja_precebo == 38 || $request->granja_precebo == 36 || $request->granja_precebo == 48) {

                    Mail::send('admin.messages.notification_ceba',$request->all(), function($msj) use($lote_id, $granja_s)
                {
                    $emails = [Auth::User()->email, 'hblandonm@cercafe.com.co'];
                    $msj->to($emails)->subject('Granja: ' . $granja_s . '   -   ' . '"CEBA"'. '|'. 'Lote: ' . $lote_id);
                });
            } else {


                   foreach ($tecnicos as $tecnico)
                    {
                if($tecnico->email == Auth::User()->email)
                    {
                    Mail::send('admin.messages.notification_ceba',$request->all(), function($msj) use($lote_id,$granja_s,$tecnico, $headers)
                    {
                        $msj->subject('Granja: ' . $granja_s . '   -   ' . '"CEBA"'. '|'. "Lote: " . $lote_id);
                        $msj->to($tecnico->email, $headers);
                    });
                }
                    }
            }
            $bool = [1, true];
            return $bool;
        }
        else
        {
            $bool = [0, false];
            return $bool;
        }
    }

    /**
     * permite ver la informacion mas detallada de ese lote que fue seleccionado
     * en la vista list_cebas.blade.php
     *
     * @var Ceba
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_ceba.blade.php compact $granja with $ceba_c
     */
    public function show($id)
    {
        $ceba_c = Ceba::find($id);
        $granja = Granja::find($ceba_c->granja_id);
        return view('admin.granjas.tabla_ceba', compact('granja', $granja))->with('ceba_c', $ceba_c);
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
     * elimina el lote que haya sido selecionado
     * en la vista list_cebas.blade.php
     *
     * @var Ceba
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/list_cebas.blade.php
     */
    public function destroy($id)
    {
        $lote_ceba = Ceba::find($id);
        $granjas = Granja::all();

        flash('El Lote <strong>' . $lote_ceba->lote . '</strong> ha sido borrado exitosamente!!!')->warning()->important();
        $lote_ceba->delete();
        return redirect()->route('admin.cebas.index');
    }
}
