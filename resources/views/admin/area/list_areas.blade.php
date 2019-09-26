@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Areas | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-briefcase" aria-hidden="true"></i> Areas Registradas</h4>
		</div>
		<br>
		<div class="container-fluid">
			<div class="form-group col-lg-6 col-xs-5">
				<ul class="list-inline">
					<li><a href="{{ route('admin.areas.create') }}" type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar una Nueva Area</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body ">
			<table class="table table-bordered table-hover table-responsive text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Id</strong></td>
						<td><strong>Cargo</strong></td>
						<td width="200"><strong>Acciones</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($areas as $area)
						<tr>
							<td>{{ $area->id }}</td>
							<td>{{ $area->nombre_area }}</td> 
							<td>
								<div class="btn-group">
									<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0; border: 1px solid rgba(255, 255, 255, .4);">Accion <span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="{{ route('admin.areas.edit', $area->id) }}" style="border-radius: 0; color: #198CC6;"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Area</a></li>
										<li><a href="{{ route('admin.areas.destroy', $area->id) }}" style="border-radius: 0; color: #E70C0C;"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar Area</a></li>
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


