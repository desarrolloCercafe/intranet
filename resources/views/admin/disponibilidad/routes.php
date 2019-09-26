<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('administrador.admin');
});

Route::get('comeBack','interfazController@comeBack');

Route::get('graficas','GraficasController@index');
Route::get('graficas_granjas','GraficaGranjaController@index');
Route::post('report_precebo_multiple','GraficasController@report_precebo_multiple');
Route::post('report_precebo_mensual','GraficaMensualController@report_precebo_mensual');
Route::post('report_precebo_granjas','GraficaGranjaController@report_precebo_granjas');
Route::post('report_precebo_granjas_mensual','GraficaGranjaMensualController@report_precebo_granjas_mensual');
Route::post('report_precebo_granjas_anual','GraficaGranjaAnualController@report_precebo_granjas_anual');
Route::post('report_precebo_general','GraficaGranjaGeneralController@report_precebo_general');

// Route::get('viewSolicitud','SolicitudComercioController@index'); //
Route::get('listSolicitud','SolicitudComercioController@listSolicitud'); //
Route::resource('solicitudes','SolicitudComercioController@store'); // 
// Route::resource('verSolicitud','SolicitudComercioController@solicitudAdicional');
// Route::get('download/{file}','SolicitudComercioController@downladFile');
Route::resource('solicitudes', 'SolicitudComercioController');
Route::get('listarsolicitudes','SolicitudComercioController@listSolicitud');
Route::get('downladFile/{file}','SolicitudComercioController@downladFile');
Route::resource('respuesta','RespuestaComercioController');
Route::get('excelComercio','SolicitudComercioController@GenerateExcelComercio');

Route::resource('granjas','GranjasController');


Route::resource('disponibilidad','GranjasDisponiblesController');
Route::get('ExcelGranjasDisponibles','GranjasDisponiblesController@GenerateExcelGranjas');
Route::resource('FilterGranjasDisponibles','FilterGranjasDisponiblesController');
Route::get('excelFilterGranjasDisponibles/{gr}/{fecha_inicial}/{fecha_final}','FilterGranjasDisponiblesController@excelFilterGranjasDisponibles');