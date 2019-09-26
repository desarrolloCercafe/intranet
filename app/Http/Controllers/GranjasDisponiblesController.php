<?php

namespace App\Http\Controllers;
use App\Granja;
use DB;
use Carbon\carbon;
use App\GranjasDisponibles;
use App\AsociacionGranja;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\User;
use Auth;

class GranjasDisponiblesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Permite Acceder a vista list_granjas_disponibles.blade.php 
     * con los datos cargados desde la base de datos
     *
     * @var Granja
     * @var AsociacionGranja
     * @var Granjas_disponibles
     * @return view('admin.disponibilidad.list_granjas_disponibles',compact('granjas_disponibles',$granjas_disponibles,'granjas',$granjas,'g_as',$g_as))
     */
    public function index()
    {   
        $g_as = AsociacionGranja::all();
        $granjas = Granja::all();
        $granjas_disponibles = DB::table('granjas_disponibles')
        ->join('granjas','granjas.id','=','granjas_disponibles.granja_id')
        ->select('granjas_disponibles.*','granjas.nombre_granja')->get();
        return view('admin.disponibilidad.list_granjas_disponibles',compact('granjas_disponibles',$granjas_disponibles,'granjas',$granjas,'g_as',$g_as));
    }

    /**
     * permite acceder a la vista create_granjas_disponibles.blade.php para la creacion de un 
     * nuevo registro 
     *
     * @var Granja
     * @var AsociacionGranja
     * @return view('admin.disponibilidad.create_granjas_disponibles',compact('granjas',$granjas,'g_as',$g_as))
     */
    public function create()
    {
        $granjas = Granja::all();
        $g_as = AsociacionGranja::all();
        return view('admin.disponibilidad.create_granjas_disponibles',compact('granjas',$granjas,'g_as',$g_as));
    }

    /**
     * permite crear un nuevo registro desde el formulario create_granjas_disponibles.blade.php.
     *
     * @var GranjasDisponibles
     * @param  \Illuminate\Http\Request  $request
     * @return return redirect()->route('admin.disponibilidad.create');
     */
    public function store(Request $request)
    {
        $date = Carbon::now();
        $date->format('D-M-Y');
        $granjas = New GranjasDisponibles;
        $granjas->granja_id = $request->granja;
        $granjas->semana = $request->semana;
        $granjas->cerdos_disponibles = $request->numero_cerdos;
        $granjas->peso_promedio = $request->peso_promedio;
        $granjas->fecha_creada = $date;
        $granjas->remember_token = $request->_token;
        $granjas->save();

        flash('La Granja fue Ingresada con Exito')->success()->important();
        return redirect()->route('admin.disponibilidad.create'); 
    }

    /**
    * Permite generar un archivo excel al presionar un boton desde la vista list_granjas_disponibles.blade.php
    * @var GranjasDisponibles
    */

    public function GenerateExcelGranjas()
    {
        $date = Carbon::now();
        $date->format('d-m-y');
        Excel::create('Reporte de Granjas Disponibles del Dia '.$date,function ($excel)
        {
            $granjas = DB::table('granjas_disponibles')
            ->join('granjas','granjas.id','=','granjas_disponibles.granja_id')
            ->select('granjas.nombre_granja as NombreGranja','fecha_creada as FechaIngreso','semana','cerdos_disponibles as CerdosDisponibles','peso_promedio as PesoPromedio')->get();
            $granjas = json_decode(json_encode($granjas),true);

            $excel->sheet('Granjas Disponibles',function ($sheet) use ($granjas)
            {
                $sheet->fromArray($granjas);
            });
        })->export('xls');
    }
}
