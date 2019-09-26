@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Granjas | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-industry"></i> Lista de Granjas</h4>
		</div>
		<br>
		<div class="container-fluid">
			<div class="form-group col-lg-12">
				<ul class="list-inline pull-right">
					<li><a href="{{route('admin.granja.create')}} " type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Crear Granja</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered table-condensed table-hover" id="granjas_Cerca" >
				<thead style="color: white;">
					<th>Id</th>
					<th>Granja</th>
					<th>Descripcion Granja</th>
					<th>Direccion</th>
					<th>Telefono</th>
					<th>Porcentaje Precebo</th>
					<th>Porcentaje Ceba</th>
					<th>Opciones</th>
				</thead>
				@foreach ($granjas as $granja)
					<tr>
						<td>{{ $granja->id}}</td>
						<td>{{ $granja->nombre_granja}}</td>
						<td>{{ $granja->descripcion_granja}}</td>
						<td>{{ $granja->direccion_granja}}</td>
						<td>{{ $granja->numero_contacto_granja}}</td>
						<td>{{ $granja->porcentaje_precebo}}</td>
						<td>{{ $granja->porcentaje_ceba}}</td>
						<td>
							<a href="{{route('admin.granja.show',$granja->id)}}" class="btn btn-primary">Editar</a>
							{{-- <a href="{{route('admin.granja.destroy',$granja->id)}}" id="eliminando" class="btn btn-danger">Eliminar</a> --}}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
@endsection

