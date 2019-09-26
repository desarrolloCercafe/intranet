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
    return view('bienvenida');
});
Route::get('refresh-csrf', function(){
	return csrf_token();
});
//Group Routes Intranet
Route::group(['prefix' => 'admin'], function()
{
	//Intranet System
	Route::get('intranet', 'UserController@bienvenida');

	Route::resource('users','UserController');
	Route::get('users/{id}/destroy', [
		'uses' => 'UserController@destroy',
		'as' => 'admin.users.destroy'
	]);

	Route::resource('cargos','CargoController');
	Route::get('cargos/{id}/destroy', [
		'uses' => 'CargoController@destroy',
		'as' => 'admin.cargos.destroy'
	]);

	Route::resource('sedes','SedeController');
	Route::get('sedes/{id}/destroy', [
		'uses' => 'SedeController@destroy',
		'as' => 'admin.sedes.destroy'
	]);

	Route::resource('vehiculos','VehiculoDespachoController');
	Route::get('vehiculos/{id}/destroy', [
		'uses' => 'VehiculoDespachoController@destroy',
		'as' => 'admin.vehiculos.destroy'
	]);

	Route::resource('conductores','ConductorController');
	Route::get('conductores/{id}/destroy', [
		'uses' => 'ConductorController@destroy',
		'as' => 'admin.conductores.destroy'
	]);

	Route::resource('areas','AreaController');
	Route::get('areas/{id}/destroy', [
		'uses' => 'AreaController@destroy',
		'as' => 'admin.areas.destroy'
	]);

	Route::resource('roles','RolController');
	Route::get('roles/{id}/destroy', [
		'uses' => 'RolController@destroy',
		'as' => 'admin.roles.destroy'
	]);

	Route::resource('rutas','RutaController');
	Route::get('rutas/{id}/destroy', [
		'uses' => 'RutaController@destroy',
		'as' => 'admin.rutas.destroy'
	]);

	Route::resource('medicamentos','MedicamentosController');
	Route::get('medicamentos/{id}/destroy', [
		'uses' => 'MedicamentosController@destroy',
		'as' => 'admin.medicamentos.destroy'
	]);

	Route::resource('insumosServicios','InsumosServiciosController');
	Route::get('insumosServicios/{id}/destroy', [
		'uses' => 'InsumosServiciosController@destroy',
		'as' => 'admin.insumosServicios.destroy'
	]);

	Route::resource('concentrados','ConcentradosController');
	Route::get('concentrados/{id}/destroy', [
		'uses' => 'ConcentradosController@destroy',
		'as' => 'admin.concentrados.destroy'
	]);

	Route::resource('productoCia','ProductoCiaController');
	Route::get('productoCia/{id}/destroy', [
		'uses' => 'ProductoCiaController@destroy',
		'as' => 'admin.productoCia.destroy'
	]);

	Route::resource('usRutas', 'RutaUsuarioController');
	Route::get('usRutas/{id}/destroy', [
		'uses' => 'RutaUsuarioController@destroy',
		'as' => 'admin.usRutas.destroy'
	]);

	Route::resource('misRutas', 'MiRutaController');
	Route::resource('bitacora', 'BitacoraController');
	Route::get('bitacora/download/{path}', [
		'uses' => 'BitacoraController@downloadFile',
		'as' => 'admin.bitacora.downloadFile'
	]);

	Route::get('bitacora/{id}/destroy', [
		'uses' => 'BitacoraController@destroy',
		'as' => 'admin.bitacora.destroy'
	]);

	//Auth System
	Route::resource('pass', 'LoginController');
	Route::resource('mail', 'MailController');

	//Mesa de Ayuda System
	Route::resource('solicitudes', 'SolicitudController');
	Route::get('realizadas', [
		'uses' => 'SolicitudController@realizadas',
		'as' => 'admin.solicitudes.realizadas'
	]);
	Route::get('tramitar/{id}', 'SolicitudController@tramitado');
	Route::get('noTramitar/{id}', 'SolicitudController@noTramitado');
	Route::get('responder/{id}', 'SolicitudController@responder');
	Route::get('descargar/download/{path}', [
		'uses' => 'SolicitudController@downloadAdjunto',
		'as' => 'admin.solicitudes.downloadAdjunto'
	]);

	Route::resource('respuesta', 'MessageController');
	Route::get('almacenadas/{id}', 'MessageController@showRespuestas');
	Route::resource('contesta', 'ContestaController');

	//Granjas System
	Route::resource('granjas','GranjasController');
	Route::resource('cebas','CebaController');
	Route::resource('granja','GranjasCercafeController');

	Route::get('cebas/{id}/destroy', [
		'uses' => 'CebaController@destroy',
		'as' => 'admin.cebas.destroy'
	]);

	Route::resource('desteteFinalizacion','DesteteFinalizacionController');
	Route::get('desteteFinalizacion/{id}/destroy', [
		'uses' => 'DesteteFinalizacionController@destroy',
		'as' => 'admin.desteteFinalizacion.destroy'
	]);

	Route::resource('destetosSemana','DestetosController');
	Route::get('destetosSemana/{id}/destroy', [
		'uses' => 'DestetosController@destroy',
		'as' => 'admin.destetosSemana.destroy'
	]);

	Route::resource('precebos','PreceboController');
	Route::get('precebos/{id}/destroy', [
		'uses' => 'PreceboController@destroy',
		'as' => 'admin.precebos.destroy'
	]);

	Route::resource('reporteMortalidad','ReporteMortalidadController');
	Route::get('reporteMortalidad/{id}/destroy', [
		'uses' => 'ReporteMortalidadController@destroy',
		'as' => 'admin.reporteMortalidad.destroy'
	]);

	Route::resource('pedidoMedicamentos', 'PedidoMedicamentosController');
	Route::get('editarpedidoM/{cons}', 'PedidoMedicamentosController@agregarProductos');
	Route::resource('pedidoMedicamentosVista', 'PedidoMedicamentosController@verMedicamento');
	Route::resource('pedidoInsumosServicios', 'PedidoInsumosController');
	Route::resource('pedidoConcentrados', 'PedidoConcentradosController');
	Route::get('editarpedidoC/{cons}', 'PedidoConcentradosController@agregarProductosConcentrados');
	Route::resource('pedidoConcentradosVista', 'PedidoConcentradosController@verPedido');
	Route::resource('pedidoProductosCia', 'PedidoCiaController');
	Route::resource('pedidoCiaVista', 'PedidoCiaController@verCia');
	Route::resource('asociacionGranjas', 'GranjasAsociadasController');
	Route::resource('entregaconcentrados', 'EntregaConcentradoController',['only' => ['index', 'store', 'update' ,'destroy']]);
	Route::get('entregas/get','EntregaConcentradoController@create');
	Route::post('modificarPedidoC', 'PedidoConcentradosController@update');
	Route::post('modificarPedidoS', 'PedidoCiaController@update');

	/*Ruta para la decisión de los concentrados*/
/*	Route::get('/decisionAdicional', 'PedidoConcentradosController@decisionPedido')->name('decisionPedido');*/
	Route::get('/decisionAdicional', 'PedidoConcentradosController@decisionPedido')->name('decisionPedido');

	Route::get('asociacionGranjas/{id}/destroy', [
		'uses' => 'GranjasAsociadasController@destroy',
		'as' => 'admin.asociacionGranjas.destroy'
	]);

	Route::resource('copiaPigWin', 'PigWinBackUpController');
	Route::get('copiaPigWin/download/{path}', [
		'uses' => 'PigWinBackUpController@downloadBack',
		'as' => 'admin.copiaPigWin.downloadBack'
	]);
	Route::get('copiaPigWin/{id}/destroy', [
		'uses' => 'PigWinBackUpController@destroy',
		'as' => 'admin.copiaPigWin.destroy'
	]);

	//Excel System
	Route::get('excelCeba', 'ExcelController@generateCebasExcel');
	Route::get('excelDesteteFinalizacion', 'ExcelController@generateDesteteFinalizacionExcel');
	Route::get('excelPrecebo', 'ExcelController@generatePrecebosExcel');
	Route::get('excelMortalidad', 'ExcelController@generateReporteMortalidadExcel');
	Route::get('excelDestetosSemana', 'ExcelController@generateReporteDestetosExcel');
	Route::get('excelFiltradoPorPedido/{ini}/{fin}/{gr}', 'ExcelController@filtroPorPedidos');
	Route::get('excelFiltradoPorProducto/{ini}/{fin}/{gr}', 'ExcelController@filtroPorProductos');
	Route::get('excelFiltradoPorPedidoConcentrado/{ini}/{fin}/{gr}', 'ExcelController@filtroPorPedidosConcentrados');
	Route::get('excelFiltradoPorProductoConcentrado/{ini}/{fin}/{gr}', 'ExcelController@filtroPorProductosConcentrados');
	Route::get('excelFiltradoPorPedidoCia/{ini}/{fin}/{gr}', 'ExcelController@filtroPorPedidosCia');
	Route::get('excelFiltradoPorProductoCia/{ini}/{fin}/{gr}', 'ExcelController@filtroPorProductosCia');
	Route::get('excelFiltradoCeba/{gr}/{lote}/{fecha_inicial}/{fecha_final}', 'ExcelController@filtroCeba');
	Route::get('excelFiltradoPrecebo/{gr}/{lote}/{fecha_inicial}/{fecha_final} ', 'ExcelController@filtroPrecebo');
	Route::get('excelFiltradoMortalidad/{gr}/{lote}/{fecha_inicial}/{fecha_final}', 'ExcelController@filtroPorMortalidadPreceboCeba');
	Route::get('excelFiltradoDesteteFinalizado/{gr}/{lote}/{fecha_inicial}/{fecha_final}', 'ExcelController@filtroDesteteFinalizacion');
	Route::get('excelFiltradoDestetosSemana/{gr}/{lote}', 'ExcelController@filtroPorDestetosSemana');
	Route::get('excelPreceboIndividual/{id}', 'ExcelController@excelPreceboIndividual');
	Route::get('excelCebaIndividual/{id}', 'ExcelController@excelCebaIndividual');
	Route::get('excelDesteteFinalizacionIndividual/{id}', 'ExcelController@excelDesteteFinalizacionIndividual');
	Route::get('excelMortalidadIndividual/{id}', 'ExcelController@excelMortalidadIndividual');
	Route::get('excelDestetoSemanalIndividual/{id}', 'ExcelController@excelDestetoSemanalIndividual');
	Route::get('excelPedidoMedicamentos/{cons}', 'ExcelController@porPedido');
	Route::get('excelPedidoConcentrados/{cons}', 'ExcelController@porPedidoConcentrado');
	Route::get('excelPedidoCia/{cons}', 'ExcelController@porPedidoCia');

	//Pdf System
	Route::get('pdfPedidoMedicamentos/{cons}', 'PdfController@pdfMedicamentos');
	Route::get('pdfPedidoConcentrados/{cons}', 'PdfController@pdfConcentrados');
	Route::get('pdfPedidoCia/{cons}', 'PdfController@pdfCia');
	Route::get('pdfPreceboIndividual/{id}', 'PdfController@pdfPreceboIndividual');
	Route::get('pdfCebaIndividual/{id}', 'PdfController@pdfCebaIndividual');
	Route::get('pdfDesteteFinalizacionIndividual/{id}', 'PdfController@pdfDesteteFinalizacionIndividual');
	Route::get('pdfMortalidadIndividual/{id}', 'PdfController@pdfMortalidadIndividual');
	Route::get('pdfDestetoSemanalIndividual/{id}', 'PdfController@pdfDestetoSemanaIndividual');

	//Filtros System
	Route::resource('filterPedidos', 'FilterPedidosController');
	Route::resource('filterConcentradoPedidos', 'FilterPedidosConcentradosController');
	Route::resource('filterCiaPedidos', 'FilterPedidosCiaController');
	Route::resource('filterCeba', 'FilterCebaController');
	Route::resource('filterPrecebo', 'FilterPreceboController');
	Route::resource('filterMortalidadPreceboCeba', 'FilterMortalidadPreceboCebaController');
	Route::resource('filterDesteteFinalizacion', 'FilterDFinalizacionController');
	Route::resource('filterDestetoSemana', 'FilterDestetosSemanaController');

	//informes system
	Route::get('tabla_dinamica','TablaDinamicaController@index');
	Route::post('TablaDinamica','TablaDinamicaController@consulta');
	Route::get('tabla_dinamica_Ceba','TablaDinamicaCebaController@index');
	Route::post('Tabla_Dinamica_Ceba','TablaDinamicaCebaController@ConsultaCeba');
	Route::post('ExcelPrecebo','GenerarExcelController@excel');
	Route::post('ExcelCeba','GeneralExcelCebaController@ExcelCeba');
	Route::post('descargar_consulta', 'PdfPreceboLoteController@generar_reporte_precebo_lote');
	Route::post('descargar_consulta_ceba', 'PdfCebaLoteController@generar_reporte_ceba_lote');
	Route::get('GenerarInforme','GeneralPreceboController@index');
	Route::post('GeneralCeba','GenerarInformeCebaController@Consulta_general');
	Route::get('ConsolidadoVista', 'ConsolidacionController@index');
	Route::post('Consolidado', 'ConsolidacionController@consolidar');
	Route::post('consolidadoceba','ConsolidadoCebaController@consolidadoceba');
	Route::post('GeneralPrecebo','GeneralPreceboController@Generar_informe');
	Route::post('general_informe','GenerarExcelPrecebosController@informe_general');
	Route::post('ConsolidacionExcel','ConsolidacionCercafeController@ConsolidadoExcel');

	// Commerce help desk system
	Route::resource('solicitudComercio', 'SolicitudComercioController');
	Route::get('descargar/download/{path}', [
		'uses' => 'SolicitudComercioController@downloadFile',
		'as' => 'admin.solicitudComercio.downloadFile'
	]);
	Route::resource('respuestacomercio','RespuestaComercioController');

	Route::post('recibir','RespuestaComercioController@recibido');
	Route::get('excelComercio','SolicitudComercioController@GenerateExcelComercio');

	//Disponibilidad Module
	Route::resource('disponibilidad','GranjasDisponiblesController');
	Route::resource('FilterGranjasDisponibles','FilterGranjasDisponiblesController');
	Route::get('ExcelGranjasDisponibles','GranjasDisponiblesController@GenerateExcelGranjas');
	Route::get('excelFilterGranjasDisponibles/{gr}/{fecha_inicial}/{fecha_final}','FilterGranjasDisponiblesController@excelFilterGranjasDisponibles');

	//Enketo Forms
	Route::resource('enketoformscategories', 'EnketoCollectorController');
	Route::get('dash', 'EnketoCollectorController@verDashboards');
	Route::get('dasharea/{area}', 'EnketoCollectorController@verDashboardsArea');

	//Errores o Mantenimiento
	Route::get('error500', 'ErrorsController@error500');

	//Iframes PowerBI
	Route::get('graficasgenerales', 'GraficasController@graficasGenerales');
	Route::get('graficasgranja', 'GraficasController@graficasGranja');

	//Vista inventarios
	Route::get('inventario', 'InventariosController@ingresarInventario');
	Route::post('inventario', 'InventariosController@store');
	Route::get('inventario/documento/{nombre_documento}', 'InventariosController@descargarFormato');
});
//Login System
Route::resource('log', 'LoginController');
Route::post('login/auth', 'authController@authUser');
// Route::get('login', 'LoginController@loginUser');
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::auth();

Route::get('/layoutDesposte', function(){
	 	return view('admin.desposte.solicitud.index');
});
