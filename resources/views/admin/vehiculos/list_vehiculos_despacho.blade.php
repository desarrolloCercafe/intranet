@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Vehiculos de Despacho | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-truck" aria-hidden="true"></i> Vehiculos Registrados</h4>
		</div>
		<br/>
		<div class="container-fluid">
			<div class="form-group col-lg-6 col-xs-5">
				<ul class="list-inline">
					<li><a href="{{ route('admin.vehiculos.create') }}" type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Vehiculo</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Placa</strong></td> 
						<td><strong>Capacidad en Toneladas</strong></td>
						<td><strong>Acciones</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($vehiculos as $vehiculo)
						<tr>
							<td>{{ $vehiculo->placa }}</td>
							<td>{{ $vehiculo->capacidad }}</td>
							<td>
								<div class="btn-group">
									<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0; border: 1px solid rgba(255, 255, 255, .4);">Accion <span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="{{ route('admin.vehiculos.edit', $vehiculo->id) }}" style="border-radius: 0; color: #198CC6;"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Vehiculo</a></li>
										<li><a href="{{ route('admin.vehiculos.destroy', $vehiculo->id) }}" style="border-radius: 0; color: #E70C0C;"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar Vehiculo</a></li>
									</ul>
								</div>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
		</div>
	</div>
@endsection


