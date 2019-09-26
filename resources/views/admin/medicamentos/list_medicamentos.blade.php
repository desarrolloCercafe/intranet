@extends('template.plantilla')
@section('content')
	@include('flash::message') 
	<title>Medicamentos | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt"></i> Lista de Medicamentos</h4>
		</div>
		<br>
		<div class="container-fluid">
			<div class="form-group col-lg-12">
				<ul class="list-inline pull-right">
					<li><a href="{{ route('admin.medicamentos.create') }}" type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Medicamentos</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
						<td><strong>REF</strong></td>
						<td><strong>Medicamento</strong></td>
						<td><strong>Tipo de Medicamento</strong></td>
						<td><strong>Accion</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($medicamentos as $medicamento)
						@if($medicamento->disable != 1)
							<tr>
								<td><strong>{{ $medicamento->ref_medicamento }}</strong></td>
								<td>{{ $medicamento->nombre_medicamento }}</td>
								<td>{{ $medicamento->tipo_medicamento }}</td>
								<td>
									<div class="btn-group">
										<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0; border: 1px solid rgba(255, 255, 255, .4);">Accion <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="{{ route('admin.medicamentos.edit', $medicamento->id) }}" style="border-radius: 0; color: #198CC6;"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Medicamento</a></li>
											<li><a href="{{ route('admin.medicamentos.destroy', $medicamento->id) }}" style="border-radius: 0; color: #E70C0C;"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar Medicamento</a></li>
										</ul>
									</div>
								</td>
							</tr>
						@else
							<tr>
								<td>{{ $medicamento->ref_medicamento }}</td>
								<td>{{ $medicamento->nombre_medicamento }}</td>
								<td>{{ $medicamento->tipo_medicamento }}</td>
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

