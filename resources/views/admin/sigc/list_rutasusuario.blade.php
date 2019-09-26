@extends('template.plantilla')
@section('content')
		<div class="container" >
			<meta charset="utf-8">
			<title>Permisos | Cercafe</title>
			@include('flash::message')
			<a href="{{ route('admin.usRutas.create') }}" class="btn btn-primary" style="margin-left: 88%;">Asignar Ruta <span class="glyphicon glyphicon-plus"></a>
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-heading">
					<h2 style="margin-left: 45%;">Rutas Asignadas</h2>
						<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
						</div>
							
						<div class="row">
							<div class="col-xs-12">
								<div class="box">
											            
									<!-- /.box-header -->
									 <div class="box-body">
              							<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr class="danger">
													<th>Usuario</th>
													<th>Ruta</th>
													<th>Opciones</th>
													</tr>
											</thead>
											<tbody>
												@foreach($rutas as $ruta)
													<tr>
														<td>{{$ruta->nombre_completo}}</td>
														<td>{{ $ruta->nombre_ruta }}</td>
														<td>
															<a href="{{ route('admin.usRutas.destroy', $ruta->id) }}" class="btn btn-danger" onclick="return confirm('¿Seguro que desea desvincular?')"><span class="lnr lnr-trash"></span></a>
														</td>
													</tr>
												@endforeach	
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						@include('template.js_tables')
@endsection




	