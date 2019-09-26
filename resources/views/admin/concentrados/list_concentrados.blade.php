@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Concentrados | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt"></i> Lista de Concentrados</h4>
		</div>
		<br>
		<div class="container-fluid">
			<div class="form-group col-lg-12">
				<ul class="list-inline pull-right">
					<li><a href="{{ route('admin.concentrados.create') }}" type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Concentrados</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
						<td><strong>REF</strong></td>
						<td><strong>Concentrado</strong></td>
						<td><strong>Tipo de Concentrado</strong></td>
						<td><strong>Accion</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($concentrados as $concentrado)
						@if($concentrado->disable != 1)
							<tr>
								<td><strong>{{ $concentrado->ref_concentrado }}</strong></td>
								<td>{{ $concentrado->nombre_concentrado }}</td>
								<td>{{ $concentrado->tipo_concentrado }}</td>
								<td>
									<div class="btn-group">
										<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0; border: 1px solid rgba(255, 255, 255, .4);">Accion <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="{{ route('admin.concentrados.edit', $concentrado->id) }}" style="border-radius: 0; color: #198CC6;"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Concentrado</a></li>
											<li><a href="{{ route('admin.concentrados.destroy', $concentrado->id) }}" style="border-radius: 0; color: #E70C0C;"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar Concentrado</a></li>
										</ul>
									</div>
								</td>
							</tr>
						@else
							<tr>
								<td>{{ $concentrado->ref_concentrado }}</td>
								<td>{{ $concentrado->nombre_concentrado }}</td>
								<td>{{ $concentrado->tipo_concentrado }}</td>
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

