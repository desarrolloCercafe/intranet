@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Editar Vehiculo | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Editar Vehiculo</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.vehiculos.update', $vehiculo], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('placa_vehiculo', 'Placa: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('placa_vehiculo', $vehiculo->placa, ['class'=>'form-control', 'placeholder' => '...', 'cols' => '30', 'rows' => '10'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('capacidad_vehiculo', 'Capacidad en Ton: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('capacidad_vehiculo', $vehiculo->capacidad, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Editar Vehiculo', array('class'=>'btn btn-info btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection