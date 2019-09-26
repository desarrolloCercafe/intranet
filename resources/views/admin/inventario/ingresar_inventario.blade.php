@extends('template.plantilla')
@section('content')
	@include('flash::message')
<title> Ingresar inventario | Cercafe</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

<div class="container-fluid col-md-12">
	<div class="col-xs-12 col-md-12 text-center">
		<div class="panel-heading" id="titulo">
			<h2>Archivos Planos <i class="fa fa-file-excel" aria-hidden="true"></i></h2>
		</div>
		@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7)
			<div class="acordeon-container">
				<a class="accordion-titulo">Importar Información<span class="toggle-icon"></span></a>
				<div class="accordion-content">
					<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'inventario'])!!}
									<div class="form-row">
										<div class="form-group col-md-12 col-lg-6 col-sm-12 p-0">
											<label>Subir inventario desposte</label>
											<input type="hidden" name="tipo_inventario" value="desposte">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-6 col-lg-3 col-xs-12 p-0 col-sm-6" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/desposte_inventario">Descargar formato</a>
										</div>
										<div class="col-md-6 col-lg-3 col-xs-12 col-sm-6 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir inventario</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'medicamentos'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir inventario Medicamentos</label>
											<input type="hidden" name="tipo_inventario" value="medicamentos">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/medicamentos_inventario">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir inventario</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'calidad'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir saldos Calidad</label>
											<input type="hidden" name="tipo_inventario" value="calidad">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/formato_calidad">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir saldos</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'informe_colaboradores'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir consolidado de nuevos colaboradores</label>
											<input type="hidden" name="tipo_inventario" value="colaboradores">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/informacion_colaboradores">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir informe</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'existenciaMedicamentos'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir Existencias</label>
											<input type="hidden" name="tipo_inventario" value="existenciaMedicamentos">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/formato_existencia_medicamentos">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir Existencias</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'ventasDesposte'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir Ventas Desposte</label>
											<input type="hidden" name="tipo_inventario" value="ventasDesposte">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/formato_ventas_desposte">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir Ventas</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
							<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'valorInventario'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir Valor Final Inventario</label>
											<input type="hidden" name="tipo_inventario" value="valorInventario">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/valor_final_inventario_mtp">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir Valor</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
					
					</div>
				</div>
			</div>
			@elseif(Auth::User()->rol_id == 11 || Auth::User()->area_id == 9)
				<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'valorInventario'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir Valor Final Inventario</label>
											<input type="hidden" name="tipo_inventario" value="valorInventario">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/valor_final_inventario_mtp">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir Valor</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
		@elseif(Auth::User()->area_id == 2)
			<div class="acordeon-container">
				<a class="accordion-titulo">Desposte<span class="toggle-icon"></span></a>
				<div class="accordion-content">
					<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'inventario'])!!}
									<div class="form-row">
										<div class="form-group col-md-12 col-lg-6 col-sm-12 p-0">
											<label>Subir inventario desposte</label>
											<input type="hidden" name="tipo_inventario" value="desposte">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-6 col-lg-3 col-xs-12 p-0 col-sm-6" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/desposte_inventario">Descargar formato</a>
										</div>
										<div class="col-md-6 col-lg-3 col-xs-12 col-sm-6 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir inventario</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="pull-right bg-danger">
							<h4><strong class="text-danger">ATENCIÓN!!</strong></h4>
							<p>Para <strong>EVITAR</strong> complicaciones al momento de subir la información, <strong class="text-danger">utilice la plantilla por defecto</strong> que puede descargar desde el boton <strong class="text-success">"Descargar formato"</strong>. Verifique tambien la extension del documento: <strong>NUNCA</strong> intente subir archivos con extension <strong class="text-danger">.xls o cualquier otra</strong>; estas no se recibirán correctamente, en su defecto utilice <strong class="text-success">.XLSX</strong> para cualquiera de los casos, ademas respete los encabezados predefinidos en la plantilla...</p>
						</div>
					</div>
				</div>
			</div>
			<div class="acordeon-container">
				<a class="accordion-titulo">Medicamentos<span class="toggle-icon"></span></a>
				<div class="accordion-content">
					<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'medicamentos'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir inventario Medicamentos</label>
											<input type="hidden" name="tipo_inventario" value="medicamentos">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/medicamentos_inventario">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir inventario</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="pull-right bg-danger">
							<h4><strong class="text-danger">ATENCIÓN!!</strong></h4>
							<p>Para <strong>EVITAR</strong> complicaciones al momento de subir la información, <strong class="text-danger">utilice la plantilla por defecto</strong> que puede descargar desde el boton <strong class="text-success">"Descargar formato"</strong>. Verifique tambien la extension del documento: <strong>NUNCA</strong> intente subir archivos con extension <strong class="text-danger">.xls o cualquier otra</strong>; estas no se recibirán correctamente, en su defecto utilice <strong class="text-success">.XLSX</strong> para cualquiera de los casos, ademas respete los encabezados predefinidos en la plantilla...</p>
						</div>
					</div>
				</div>
			</div>
			<div class="acordeon-container">
				<a class="accordion-titulo">Calidad<span class="toggle-icon"></span></a>
				<div class="accordion-content">
					<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'calidad'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir saldos Calidad</label>
											<input type="hidden" name="tipo_inventario" value="calidad">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/formato_calidad">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir saldos</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="pull-right bg-danger">
							<h4><strong class="text-danger">ATENCIÓN!!</strong></h4>
							<p>Para <strong>EVITAR</strong> complicaciones al momento de subir la información, <strong class="text-danger">utilice la plantilla por defecto</strong> que puede descargar desde el boton <strong class="text-success">"Descargar formato"</strong>. Verifique tambien la extension del documento: <strong>NUNCA</strong> intente subir archivos con extension <strong class="text-danger">.xls o cualquier otra</strong>; estas no se recibirán correctamente, en su defecto utilice <strong class="text-success">.XLSX</strong> para cualquiera de los casos, ademas respete los encabezados predefinidos en la plantilla...</p>
						</div>
					</div>
				</div>
			</div>
				<div class="acordeon-container">
				<a class="accordion-titulo">Calidad<span class="toggle-icon"></span></a>
				<div class="accordion-content">
					<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
							<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'ventasDesposte'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir Ventas Desposte</label>
											<input type="hidden" name="tipo_inventario" value="ventasDesposte">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/formato_ventas_desposte">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir Ventas</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="pull-right bg-danger">
							<h4><strong class="text-danger">ATENCIÓN!!</strong></h4>
							<p>Para <strong>EVITAR</strong> complicaciones al momento de subir la información, <strong class="text-danger">utilice la plantilla por defecto</strong> que puede descargar desde el boton <strong class="text-success">"Descargar formato"</strong>. Verifique tambien la extension del documento: <strong>NUNCA</strong> intente subir archivos con extension <strong class="text-danger">.xls o cualquier otra</strong>; estas no se recibirán correctamente, en su defecto utilice <strong class="text-success">.XLSX</strong> para cualquiera de los casos, ademas respete los encabezados predefinidos en la plantilla...</p>
						</div>
					</div>
				</div>
			</div>
		@elseif(Auth::User()->area_id == 10)
			<div class="acordeon-container">
				<a class="accordion-titulo">Colaboradores<span class="toggle-icon"></span></a>
				<div class="accordion-content">
					<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'informe_colaboradores'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir consolidado de nuevos colaboradores</label>
											<input type="hidden" name="tipo_inventario" value="colaboradores">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/informacion_colaboradores">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir informe</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="pull-right bg-danger">
							<h4><strong class="text-danger">ATENCIÓN!!</strong></h4>
							<p>Para <strong>EVITAR</strong> complicaciones al momento de subir la información, <strong class="text-danger">utilice la plantilla por defecto</strong> que puede descargar desde el boton <strong class="text-success">"Descargar formato"</strong>. Verifique tambien la extension del documento: <strong>NUNCA</strong> intente subir archivos con extension <strong class="text-danger">.xls o cualquier otra</strong>; estas no se recibirán correctamente, en su defecto utilice <strong class="text-success">.XLSX</strong> para cualquiera de los casos, ademas respete los encabezados predefinidos en la plantilla...</p>
						</div>
					</div>
				</div>
			</div>
		@elseif(Auth::User()->area_id == 7)
			<div class="acordeon-container">
				<a class="accordion-titulo">Existencia Medicamentos<span class="toggle-icon"></span></a>
				<div class="accordion-content">
					<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
						<div class="panel panel-default">
							<div class="panel-body">
								{!!Form::open(['inventario', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on', 'id' => 'existenciaMedicamentos'])!!}
									<div class="form-row">
										<div class="form-group col-md-6 col-lg-6 p-0">
											<label>Subir Existencias</label>
											<input type="hidden" name="tipo_inventario" value="existenciaMedicamentos">
											<input type="file" name="file" class="form-control" required="" accept=".csv, .xlsx">
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<a class="btn btn-success btn-block" href="inventario/documento/formato_existencia_medicamentos">Descargar formato</a>
										</div>
										<div class="col-md-3 col-lg-3 p-0" style="margin-top: 24px;">
											<button type="submit" class="btn btn-primary btn-block">Subir Existencias</button>
										</div>
									</div>
								{!!Form::close()!!}
							</div>
						</div>
						<div class="pull-right bg-danger">
							<h4><strong class="text-danger">ATENCIÓN!!</strong></h4>
							<p>Para <strong>EVITAR</strong> complicaciones al momento de subir la información, <strong class="text-danger">utilice la plantilla por defecto</strong> que puede descargar desde el boton <strong class="text-success">"Descargar formato"</strong>. Verifique tambien la extension del documento: <strong>NUNCA</strong> intente subir archivos con extension <strong class="text-danger">.xls o cualquier otra</strong>; estas no se recibirán correctamente, en su defecto utilice <strong class="text-success">.XLSX</strong> para cualquiera de los casos, ademas respete los encabezados predefinidos en la plantilla...</p>
						</div>
					</div>
				</div>
			</div>
		@else
		 	<p class="text-danger"><strong>No logramos procesar tu solicitud</strong></p>
		@endif
	</div>
</div>

<script type="text/javascript">
  var flag;
  if (flag) {
  	console.log('Se subio el documento');
  	$("#inventario")[0].reset();
  	$("#medicamentos")[0].reset();
  	$("#informe_colaboradores")[0].reset();
  	$("#calidad")[0].reset();
  	$("#existenciaMedicamentos")[0].reset();
  	location.replace('http://201.236.212.130:82/intranetcercafe/public/admin/inventario');
  }

</script>

{!!Html::script('js/acordeon.js')!!}
{!!Html::style('media/css/acordeon.css')!!}
@endsection