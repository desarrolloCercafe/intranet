@extends('template.plantilla')
@section('content')
		<div class="container" >
			<meta charset="utf-8">
			<title>Mis rutas | Cercafe</title>
			@include('flash::message')
			
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-heading">
					<h2 style="margin-left: 45%;">Tus Rutas</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}">
						<span class="button-icon has-bg">
							<i class="ti ti-angle-down"></i>
						</span>
					</div>
				</div>
				@if($ruts)
					<div class="row">
						<div class="col-xs-12">
							<div class="box">         
								<!-- /.box-header -->
								<div class="box-body">
									<table id="example2" class="table table-bordered table-hover">
										<thead>
											<tr class="danger">
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach($ruts as $rut)
												<tr>
													<th>
														<a href="{{ route('admin.misRutas.edit', $rut->ruta_id )}} ">
															{{ $rut->nombre_ruta }}
														</a>
													</th>
												</tr>
											@endforeach	
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					@include('template.js_tables')
				@else
					<br/><br/><br/><h2 style="margin-left: 25%">No Tienes Rutas Asignadas por el Momento...</h2><br/><br/><br/>
				<a href="javascript:history.go(-1);" class="btn btn-danger" style="margin-left: 45%">Regresar</a>
				@endif
@endsection


