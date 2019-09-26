<?php

namespace App\Http\Controllers;
// use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class authController extends Controller
{
  public function authUser(Request $request) 
  {
  		  if ($request['name'] == 'hola') 
        {
            return response('Logueado', 200);
        }else {
        	return response('No logueado', 500);
        }
        
        
  }
}
