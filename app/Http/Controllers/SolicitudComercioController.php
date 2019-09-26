<?php

namespace App\Http\Controllers;
use Mail;
use DB;
use Session;
use Carbon\Carbon;
use App\SolicitudComercio;
use App\Estado;
use App\RespuestaComercio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class SolicitudComercioController extends Controller
{ 
  public function __construct()
  {
    $this->middleware('auth');
  } 
  /**
  * permite la vista list_solicitudes.blade.php con todas las solicitudes 
  * 
  * @return view('admin.mesadeayudacomercial.list_solicitudes')->with('solicitudes',$solicitudes);
  */
  public function index()
  {
    $solicitudes = DB::table('solicitudes_comercio')
    ->join('estados','solicitudes_comercio.estado_id','=','estados.id')
    ->select('solicitudes_comercio.*','estados.nombre_estado')->get();

    return view('admin.mesadeayudacomercial.list_solicitudes')->with('solicitudes',$solicitudes);
  }

  /**
  * permite visualizar el formulario create_solicitud.blade.php para realizar la solicitud
  * 
  * @var User
  * @return view('admin.mesadeayudacomercial.create_solicitud')->with('users',$users);
  */

  public function create()
  {
    $users = User::all();
    return view('admin.mesadeayudacomercial.create_solicitud')->with('users',$users);
  }

  /**
  * permite registrar una nueva solicitud desde la vista create_solicitud.blade.php, una vez
  * ingresada la informacion se enviara mediante correo electronico la informacion ingresada
  *
  * @var SolicitudComercio
  * @param  Illuminate\Http\Request $request
  * @return redirect()->route('admin.solicitudComercio.index')
  */

  public function store(Request $request)
  {
    $correos = implode(',', $request->agente);

    $solicitud = new SolicitudComercio;
    $solicitud->medio = $request->medio;
    $solicitud->agente = $correos.','.$request->servicio;
    $solicitud->categoria = $request->categoria;
    $solicitud->nombre_completo = $request->nombre_completo;
    $solicitud->cedula = $request->cedula;
    $solicitud->correo_electronico = $request->correo;
    $solicitud->motivo_descripcion = $request->motivo;
    $solicitud->direccion = $request->direccion;
    $solicitud->telefono = $request->telefono;
    $solicitud->fecha_hora = $request->fecha_hora;
    $solicitud->descripcion = $request->descripcion_solicitud;
    $solicitud->estado_id = $request->estado;
    $solicitud->remember_token = $request->_token;
    $solicitud->emisario_id = $request->emisor_id;
    if ($request->path == null)
    {
      $solicitud->path = null;
    }
    else
    {
      $solicitud->path = $request->path;
    }

    $file = $request->path;
    if ($file == null) 
    {
      $nombre = null;
    }
    else
    {
      $nombre = $file->getClientOriginalName();
      \Storage::disk('local4')->put($nombre,  \File::get($file));
    }
      
    if ($request->adicion == null) {
      $solicitud->motivo_adicional = null;
    }
    else
    {
      $solicitud->motivo_adicional = $request->adicion;
    }
    $solicitud->save();

    $emails = $request->agente;
    foreach ($emails as $email)
    {
      Mail::send('admin.mesadeayudacomercial.mensaje_solicitud', $request->all(), function($msj) use ($email)
      {
        $msj->from(Input::get("correo"), Input::get("nombre_completo"));
        $msj->to($email)->subject('Solicitud...Mesa de Ayuda');
      });
    }

    Mail::send('admin.mesadeayudacomercial.mensaje_solicitud', $request->all(), function($msj)
    {
      $msj->from(Input::get("correo"), Input::get("nombre_completo"));
      $msj->to(Input::get('servicio'))->subject('Solicitud...Mesa de Ayuda');
    });
    flash('<strong>Solicitudes Enviada/s</strong> !!!!')->success()->important();
    return redirect()->route('admin.solicitudComercio.index');
  }

  /**
  * permite visualizar toda la informacion de la solicitud seleccionada en la vista 
  * list_solicitudes.blade.php
  *
  * @var User
  * @var SolicitudComercio
  * @var Estado
  * @param int $id
  * @return view('admin.mesadeayudacomercial.ver_solicitud',compact('solicitud',$solicitud,'estado',$estado,'respuestas',$respuestas,'users',$users))
  */

  public function show($id)
  {
    $users = User::all();
    $solicitud = SolicitudComercio::find($id);
    $estado = Estado::find($solicitud->estado_id);
    $respuestas = DB::table('respuestas_comercio')
    ->join('users','respuestas_comercio.emisario_id','=','users.id')
    ->select('respuestas_comercio.*','users.nombre_completo')->get();
    $emisario = DB::table('solicitudes_comercio')
    ->join('users','users.id','=','solicitudes_comercio.emisario_id')
    ->select('users.nombre_completo')
    ->where('solicitudes_comercio.id',$id)->get();
    return view('admin.mesadeayudacomercial.ver_solicitud',compact('solicitud',$solicitud,'estado',$estado,'users',$users,'emisario',$emisario,'respuestas',$respuestas));
  }

  /**
  * permite descargar el archivo seleccionado desde la vista ver_solicitud.blade.php
  *
  * @param varchar $file
  * @return response()->download($pathtoFile); 
  */

  public function downloadFile($file)
  {
    $pathtoFile = public_path('comercio/'.$file);
    return response()->download($pathtoFile);
  }

  /**
  * permite generar un archivo excel desde la vista lis_solicitudes.blade.php
  * con todos los registros existentes de la base de datos 
  */

  public function GenerateExcelComercio()
  {
    $date = Carbon::now();
    $date->format('D-M-Y');
    Excel::create('Reporte de Solicitudes de Comercio del Dia '.$date, function ($excel)
    {
      $solicitudes = DB::table('solicitudes_comercio')
        ->join('estados','solicitudes_comercio.estado_id','=','estados.id')
        ->join('users','solicitudes_comercio.emisario_id','=','users.id')
        ->select('solicitudes_comercio.id as SolicitudNumero','solicitudes_comercio.agente','solicitudes_comercio.nombre_completo as Cliente','medio','categoria','cedula','direccion','solicitudes_comercio.telefono','correo_electronico as CorreoPersona','fecha_hora as FechayHoradeEnvio','motivo_descripcion as MotivodelaPQR','motivo_adicional as MotivoAdicional','descripcion','estados.nombre_estado as Estado','users.nombre_completo as IngresadoPor','moderador as RespondidoPor')->get();
      $solicitudes = json_decode(json_encode($solicitudes),true);

      $excel->sheet('Solicitudes',function ($sheet) use ($solicitudes)
      {
        $sheet->fromArray($solicitudes);
      });
    })->export('xls');
  }
}
