@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Insumos y Servicios | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt"></i> Lista de Insumos y Servicios</h4>
		</div>
		<br>
		<div class="container-fluid">
			<div class="form-group col-lg-12">
				<ul class="list-inline pull-right">
					<li><a href="{{ route('admin.insumosServicios.create') }}" type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumo o Servicios</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
						<td><strong>REF</strong></td>
						<td><strong>Insumo</strong></td>
						<td><strong>Tipo de Insumo</strong></td>
						<td><strong>Accion</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($insumos_servicios as $insumo_servicio)
						@if($insumo_servicio->disable != 1)
							<tr>
								<td><strong>{{ $insumo_servicio->ref_insumo }}</strong></td>
								<td>{{ $insumo_servicio->nombre_insumo }}</td>
								<td>{{ $insumo_servicio->tipo_insumo }}</td>
								<td>
									<div class="btn-group">
										<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0; border: 1px solid rgba(255, 255, 255, .4);">Accion <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="{{ route('admin.insumosServicios.edit', $insumo_servicio->id) }}" style="border-radius: 0; color: #198CC6;"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Insumo</a></li>
											<li><a href="{{ route('admin.insumosServicios.destroy', $insumo_servicio->id) }}" style="border-radius: 0; color: #E70C0C;"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar Insumo</a></li>
										</ul>
									</div>
								</td>
							</tr>
						@else
							<tr>
								<td>{{ $insumo_servicio->ref_insumo }}</td>
								<td>{{ $insumo_servicio->nombre_insumo }}</td>
								<td>{{ $insumo_servicio->tipo_insumo }}</td>
								<td>
									<button disabled="true" class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 2px; border: 1px solid rgba(255, 255, 255, .4);">Disable</button>
								</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

