<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\ReporteMortalidadPreceboCeba;
use App\Granja;
use App\Alimento;
use App\CausaMuerte;
use App\Http\Requests; 
use App\AsociacionGranja;
use Mail; 
use App\User;
use Session;
use Carbon\Carbon;
use Auth;

class ReporteMortalidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * permite visualizar la vista de list_reporte_mortalidad_precebo_ceba.blade.php
     * los registros de la basde de datos
     *
     * @var AsociacionGranja
     * @var Granja
     * @var DB
     * @return view/admin/granjas/list_reporte_mortalidad_precebo_ceba.blade.php compact $g_as, $granjas with $reportes.
     */
    public function index()
    {
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $reportes = DB::table('formulario_mortalidad_precebo_ceba')
                    ->join('granjas', 'formulario_mortalidad_precebo_ceba.granja_id', '=', 'granjas.id')
                    ->join('alimentos', 'formulario_mortalidad_precebo_ceba.alimento_id', '=', 'alimentos.id')
                    ->join('causas_muerte', 'formulario_mortalidad_precebo_ceba.causa_id', '=', 'causas_muerte.id')
                    ->select('formulario_mortalidad_precebo_ceba.*', 'granjas.nombre_granja', 'alimentos.nombre_alimento', 'causas_muerte.causa')
                    ->where('formulario_mortalidad_precebo_ceba.año_muerte', '>', '2016')
                    ->get();
        return view('admin.granjas.list_reporte_mortalidad_precebo_ceba', compact('g_as', $g_as, 'granjas', $granjas))->with('reportes', $reportes);
    }

    /**
     * permite acceder a la vista del formulario para crear un nuevo reporte
     *
     * @var AsociacionGranja
     * @var Granja
     * @var Alimento
     * @var CausaMuerte
     * @return view/admin/granjas/form_reporte_mortalidad_precebo_ceba compact $g_as, $granjas,$alimentos,$causas
     */
    public function create()
    {
        $bool = [null, false];
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $alimentos = Alimento::lists('nombre_alimento', 'id');
        $causas = CausaMuerte::lists('causa', 'id');
        return view('admin.granjas.form_reporte_mortalidad_precebo_ceba', compact('granjas','alimentos','causas', 'g_as', 'bool'));
    }

    /**
     * permite registrar la informacion que fue ingresada en el formulario
     * reporte_mortalidad_precebo_ceba.blade.php tambien envia un correo al correo electronico intranet@cercafe.com.co
     * con la informacion que fue registrada
     *
     * @var ReporteMortalidadPreceboCeba
     * @var Granja
     * @var User
     * @param  \Illuminate\Http\Request  $request
     * @return redirect/view/admin/granjas/list_reporte_mortalidad_precebo_ceba.blade.php
     */
    public function store(Request $request)
    {
        $reporte_muerte = New ReporteMortalidadPreceboCeba();
        
        if ($request->granja == null) 
        {
            $bool = [0, false];
            return $bool;
        }
        else
        {
            $reporte_muerte->granja_id = $request->granja;
        }
        $reporte_muerte->lote =  $request->lote;
        $lote_id = $request->lote;
        $reporte_muerte->sala =  $request->sala;
        $reporte_muerte->numero_cerdos =  $request->numero_cerdos;
        $reporte_muerte->sexo_cerdo =  $request->sexo_cerdo;
        $reporte_muerte->peso_cerdo =  $request->peso_cerdo;
        $reporte_muerte->fecha = $request->fecha_muerte;
        $reporte_muerte->dia_muerte =  $request->dia_muerte;
        $reporte_muerte->año_muerte =  $request->año_muerte;
        $reporte_muerte->mes_muerte =  $request->mes_muerte;
        $reporte_muerte->semana_muerte =  $request->semana_muerte;
        $reporte_muerte->edad_cerdo =  $request->edad_cerdo;
        $reporte_muerte->causa_id =  $request->causa;
        $reporte_muerte->alimento_id =  $request->alimento;
        $reporte_muerte->save();
 
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
                  
                    Mail::send('admin.messages.notification_mortalidad',$request->all(), function($msj) use($lote_id, $granja_s) 
                { 
                    $emails = [Auth::User()->email, 'hblandonm@cercafe.com.co'];
                    $msj->to($emails)->subject('Granja: ' . $granja_s . '   -   ' . '"PRECEBO"'. '|'. 'Lote: ' . $lote_id);
                });
            } else {
              foreach ($tecnicos as $tecnico) 
             {
            if($tecnico->email == Auth::User()->email || $tecnico->email == $email)
            {
                Mail::send('admin.messages.notification_mortalidad',$request->all(), function($msj) use($lote_id,$granja_s,$tecnico)
                {
                    $msj->subject('Granja: ' . $granja_s . '   -   ' . '"MORTALIDAD"' . ' | ' . 'Lote: ' . $lote_id);
                    $msj->to($tecnico->email);
                });
            }
             }
        }


      
        $bool = [1, true];
        return $bool;
    }

    /**
     * visualiza informacion extra del lote seleccionado en la vista list_reporte_mortalidad_precebo_ceba.blade.php
     *
     * @var ReporteMortalidadPreceboCeba
     * @var CausaMuerte
     * @var Alimento
     * @var Granja
     * @param  int  $id
     * @return view/admin/granjas/tabla_mortalidad.blade.php compact $granja,$nombre_muerte,$alimento with $mortalidad
     */
    public function show($id)
    {
        $mortalidad = ReporteMortalidadPreceboCeba::find($id);
        $nombre_muerte = CausaMuerte::find($mortalidad->causa_id);
        $alimento = Alimento::find($mortalidad->alimento_id);
        $granja = Granja::find($mortalidad->granja_id);
        return view('admin.granjas.tabla_mortalidad', compact('granja', $granja,'nombre_muerte',$nombre_muerte,'alimento',$alimento))->with('mortalidad', $mortalidad);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
     * permite eliminar el lote seleccionado en la tabla list_reporte_mortalidad_precebo_ceba.blade.php
     *
     * @var ReporteMortalidadPreceboCeba
     * @var Granja
     * @param  int  $id
     * @return redirect/view/admin/granjas/list_reporte_mortalidad_precebo_ceba.blade.php
     */
    public function destroy($id)
    {
        $lote_mortalidad = ReporteMortalidadPreceboCeba::find($id);
        $granjas = Granja::all();
 
        flash('El Lote <strong>' . $lote_mortalidad->lote . '</strong> ha sido borrado exitosamente!!!')->warning()->important();     
        $lote_mortalidad->delete(); 
        return redirect()->route('admin.reporteMortalidad.index'); 
    }
}
