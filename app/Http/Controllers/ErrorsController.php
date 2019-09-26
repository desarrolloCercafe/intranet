<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ErrorsController extends Controller
{
    public function error500()
    {
    	return view('errors.503');
    }
}
