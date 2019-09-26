@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registrar Vehiculo | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Ingresar Vehiculo</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.vehiculos.store'], 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('placa_vehiculo', 'Placa: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('placa_vehiculo',null, ['class'=>'form-control', 'placeholder' => '...'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('capacidad_vehiculo', 'Capacidad en Ton: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('capacidad_vehiculo', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Vehiculo', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection