<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Granja;
use App\GranjasDisponibles;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use DB;
use App\Http\Requests;

class FilterGranjasDisponiblesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * permite realizar la filtracion de las granjas desde la vista list_granjas_disponibles.blade.php
    * 
    * @var Granja
    * @var GranjasDiponibles
    * @param Illuminate\Http\Request $request
    * @return return view('admin.disponibilidad.filter_granjas_disponibles',compact('granja_filtro','fecha_inicial','fecha_final','granjas_d',$granjas_d));
    */

    public function store(Request $request)		
    {
    	$granjas = Granja::all();
    	$granjas_disponibles = GranjasDisponibles::all();
    	if ($request->granja != null) {
    		$granja_filtro = $request->granja;
    		if ($request->desde != null && $request->hasta != null) {
    			$fecha_inicial = $request->desde;
    			$fecha_final = $request->hasta;
    			$fechas = GranjasDisponibles::whereBetween('fecha_creada',[$request->desde,$request->hasta])->get();
    			foreach ($fechas as $fecha) {
    				if ($request->granja == $fecha->granja_id) {
    					foreach ($granjas as $granja) {
    						if ($fecha->granja_id == $granja->id) {
    							$granjas_d[$fecha->id]["id_granja"] = $fecha->id;
    							$granjas_d[$fecha->id]["granja"] = $granja->nombre_granja;
    							$granjas_d[$fecha->id]["fecha_creada"] = $fecha->fecha_creada;
    							$granjas_d[$fecha->id]["semana"] = $fecha->semana;
    							$granjas_d[$fecha->id]["cerdos_disponibles"] = $fecha->cerdos_disponibles;
    							$granjas_d[$fecha->id]["peso_promedio"] = $fecha->peso_promedio;
    						}
    					}
    				}
    			}
    		}else{
    			$fecha_inicial = '+';
    			$fecha_final = '+';
    			foreach ($granjas_disponibles as $g_diponible) {
    				if ($g_diponible->granja_id == $request->granja) {
    					foreach ($granjas as $granja) {
    						if ($granja->id == $g_diponible->granja_id) {
    							$granjas_d[$g_diponible->id]["id_granja"] = $g_diponible->id;
    							$granjas_d[$g_diponible->id]["granja"] = $granja->nombre_granja;
    							$granjas_d[$g_diponible->id]["fecha_creada"] = $g_diponible->fecha_creada;
    							$granjas_d[$g_diponible->id]["semana"] = $g_diponible->semana;
    							$granjas_d[$g_diponible->id]["cerdos_disponibles"] = $g_diponible->cerdos_disponibles;
    							$granjas_d[$g_diponible->id]["peso_promedio"] = $g_diponible->peso_promedio;
    						}
    					}
    				}
    			}
    		}
    		if (!empty($granjas_d) && is_array($granjas_d)) {
	            return view('admin.disponibilidad.filter_granjas_disponibles',compact('granja_filtro','fecha_inicial','fecha_final','granjas_d',$granjas_d));
	        }else{
	            flash('<strong>No existen registros asociados al Rango de Fecha o Granja Seleccionada!!!</strong>')->error()->important();
	            return redirect()->route('admin.disponibilidad.index'); 
	        } 
    	}elseif ($request->desde != null && $request->hasta != null) {
    		$granja_filtro = '-';
    		$fecha_inicial =$request->desde;
    		$fecha_final = $request->hasta;
    		$fechas = GranjasDisponibles::whereBetween('fecha_creada',[$request->desde,$request->hasta])->get();
    		foreach ($fechas as $fecha) {
    			foreach ($granjas as $granja) {
    				if ($granja->id == $fecha->granja_id) {
    					$granjas_d[$fecha->id]["id_fecha"] = $fecha->id;
						$granjas_d[$fecha->id]["granja"] = $granja->nombre_granja;
						$granjas_d[$fecha->id]["fecha_creada"] = $fecha->fecha_creada;
						$granjas_d[$fecha->id]["semana"] = $fecha->semana;
						$granjas_d[$fecha->id]["cerdos_disponibles"] = $fecha->cerdos_disponibles;
						$granjas_d[$fecha->id]["peso_promedio"] = $fecha->peso_promedio;
    				}
    			}
    		}
    		if (!empty($granjas_d) && is_array($granjas_d)) {
    			return view('admin.disponibilidad.filter_granjas_disponibles',compact('granja_filtro','fecha_inicial','fecha_final','granjas_d',$granjas_d));
	            // dd($granjas_d);
	        }else{
	            flash('<strong>No existen Registros de acuerdo al Rango de Fecha Solicitado!!!</strong>')->error()->important();
	            return redirect()->route('admin.disponibilidad.index'); 
	        }
    	}else{
    		flash('<strong>No hay Parametros de Busqueda!!!!</strong>')->error()->important();
    		return redirect()->route('admin.disponibilidad.index');
    	}
    }

    /**
    * permite generar un archivo excel desde la vista filter_granjas_disponibles.blade.php de acuerdo
    * a la filtracion realizada
    * @var Granja
    * @var GranjasDisponibles
    * @param int $gr, date $fecha_inicial, $fecha_final
    */

    public function excelFilterGranjasDisponibles($gr,$fecha_inicial,$fecha_final)
    {
    	$date = Carbon::now();
    	$date->format('d-m-y');
    	if ($gr != '-') {
    		if ($fecha_inicial != '+' && $fecha_final != '+') {
    			Excel::create('Filtro por Granja Desde el '.$fecha_inicial.' Hasta el '.$fecha_final.' del Dia '.$date,function ($excel) use ($gr, $fecha_inicial, $fecha_final)
    			{
    				$granjas = Granja::all();
    				$granjas_disponibles = GranjasDisponibles::all();
    				$fechas = GranjasDisponibles::whereBetween('fecha_creada',[$fecha_inicial, $fecha_final])->get();

    				foreach ($fechas as $fecha) {
    					if ($fecha->granja_id == $gr) {
    						foreach ($granjas as $granja) {
    							if ($granja->id == $fecha->granja_id) {
    								if ($granja->id == $gr) {
                                        $granjas_d[$fecha->id]["granja"] = $granja->nombre_granja;
                                        $granjas_d[$fecha->id]["fecha_creada"] = $fecha->fecha_creada;
                                        $granjas_d[$fecha->id]["semana"] = $fecha->semana;
                                        $granjas_d[$fecha->id]["cerdos_disponibles"] = $fecha->cerdos_disponibles;
                                        $granjas_d[$fecha->id]["peso_promedio"] = $fecha->peso_promedio;
    								}
    							}
    						}
    					}
    				}
    				$granjas_d = json_decode(json_encode($granjas_d),true);
    				$excel->sheet('Granjas Disponibles',function ($sheet) use ($granjas_d)
    				{
    					foreach ($granjas_d as $granja_d) {
    						$sheet->row(1,['Nombre de la Granja','Fecha de Creacion','Semana','Cerdos Disponibles','Peso Promedio']);
    						$row = [];
    						$row[0] = $granja_d['granja'];
    						$row[1] = $granja_d['fecha_creada'];
    						$row[2] = $granja_d['semana'];
    						$row[3] = $granja_d['cerdos_disponibles'];
    						$row[4] = $granja_d['peso_promedio'];
    						$sheet->appendrow($row);
    					}
    				});
    			})->export('xls');
    		}else{
    			Excel::create('Filtro de Granjas del Dia '.$date,function ($excel) use ($gr)
    			{
    				$granjas = Granja::all();
    				$granjas_disponibles = GranjasDisponibles::all();

    				foreach ($granjas_disponibles as $granja_disponible) {
    					if ($granja_disponible->granja_id == $gr) {
    						foreach ($granjas as $granja) {
    							if ($granja->id == $gr) {
    								$granjas_d[$granja_disponible->id]["granja"] = $granja->nombre_granja;
                                    $granjas_d[$granja_disponible->id]["fecha_creada"] = $granja_disponible->fecha_creada;
                                    $granjas_d[$granja_disponible->id]["semana"] = $granja_disponible->semana;
                                    $granjas_d[$granja_disponible->id]["cerdos_disponibles"] = $granja_disponible->cerdos_disponibles;
                                    $granjas_d[$granja_disponible->id]["peso_promedio"] = $granja_disponible->peso_promedio;
    							}
    						}
    					}
    				}
    				$granjas_d = json_decode(json_encode($granjas_d),true);
    				$excel->sheet('Granjas Disponibles',function ($sheet) use ($granjas_d)
    				{
    					foreach ($granjas_d as $granja_d) {
    						$sheet->row(1,['Nombre de la Granja','Fecha de Creacion','Semana','Cerdos Disponibles','Peso Promedio']);
    						$row = [];
    						$row[0] = $granja_d['granja'];
    						$row[1] = $granja_d['fecha_creada'];
    						$row[2] = $granja_d['semana'];
    						$row[3] = $granja_d['cerdos_disponibles'];
    						$row[4] = $granja_d['peso_promedio'];
    						$sheet->appendrow($row);
    					}
    				});
    			})->export('xls');
    		}
    	}elseif ($fecha_inicial != '+' && $fecha_final != '+') {
    		Excel::create('Reportes de las Granjas Disponibles desde el '.$fecha_inicial.' Hasta el '.$fecha_final.' del Dia '.$date,function ($excel) use ($fecha_inicial,$fecha_final)
    		{
    			$granjas = Granja::all();
    			$fechas = GranjasDisponibles::whereBetween('fecha_creada',[$fecha_inicial,$fecha_final])->get();
    			foreach ($fechas as $fecha) {
    				foreach ($granjas as $granja) {
    					if ($fecha->granja_id == $granja->id) {
    						$granjas_d[$fecha->id]["granja"] = $granja->nombre_granja;
                            $granjas_d[$fecha->id]["fecha_creada"] = $fecha->fecha_creada;
                            $granjas_d[$fecha->id]["semana"] = $fecha->semana;
                            $granjas_d[$fecha->id]["cerdos_disponibles"] = $fecha->cerdos_disponibles;
                            $granjas_d[$fecha->id]["peso_promedio"] = $fecha->peso_promedio;
    					}
    				}
    			}
    			$granjas_d = json_decode(json_encode($granjas_d),true);
    			$excel->sheet('Granjas Disponibles',function ($sheet) use ($granjas_d)
    			{
    				foreach ($granjas_d as $granja_d) {
    					$sheet->row(1,['Nombre de la Granja','Fecha de Creacion','Semana','Cerdos Disponibles','Peso Promedio']);
						$row = [];
						$row[0] = $granja_d['granja'];
						$row[1] = $granja_d['fecha_creada'];
						$row[2] = $granja_d['semana'];
						$row[3] = $granja_d['cerdos_disponibles'];
						$row[4] = $granja_d['peso_promedio'];
						$sheet->appendrow($row);
    				}
    			});
    		})->export('xls');
    	}
    }
}
