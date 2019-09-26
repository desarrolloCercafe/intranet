@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Usuarios | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt"></i> Lista de Usuarios</h4>
		</div>
		<br>
		<div class="container-fluid">
			<div class="form-group col-lg-12">
				<ul class="list-inline pull-right">
					<li><a href="{{ route('admin.users.create') }}" type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a></li>
				</ul>
			</div> 
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td width="100"><strong>Documento</strong></td>
						<td width="100"><strong>Usuario</strong></td>
						<td width="100"><strong>Nombre</strong></td>
						<td width="100"><strong>Rol</strong></td>
						<td width="100"><strong>Cargo</strong></td>
						<td width="100"><strong>Area</strong></td>
						<td width="100"><strong>Acciones</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user) 
						<tr>
							<td>{{ $user->documento }}</td>
							<td><strong>{{ $user->name}}</strong></td>
							<td>{{ $user->nombre_completo}}</td>
							<td>{{ $user->nombre_rol }}</td>
							<td>{{ $user->nombre_cargo }}</td>
							<td>{{ $user->nombre_area }}</td>
							<td>
								<div class="btn-group">
									<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0; border: 1px solid rgba(255, 255, 255, .4);">Accion <span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="{{ route('admin.pass.show', $user->id) }}" style="color: #FFC300;"><i class="fa fa-key" aria-hidden="true"></i> Cambiar Contraseña</a></li>
										<li><a href="{{ route('admin.users.edit', $user->id) }}" style=" color: #198CC6;"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Usuario</a></li>
										<li><a href="{{ route('admin.users.destroy', $user->id) }}" style="color: #E70C0C;"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar Usuario</a></li>
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




