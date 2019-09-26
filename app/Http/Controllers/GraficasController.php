<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class GraficasController extends Controller
{
    public function graficasGenerales()
    {
    	return view('admin.graficas.dashboards_generales');
    }
    public function graficasGranja()
    {
    	return view('admin.graficas.dashboards_granja');
    }
}
