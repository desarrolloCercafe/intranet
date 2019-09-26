@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registrar Conductor | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-user" aria-hidden="true"></i> Ingresar Conductor</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.conductores.store'], 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('nombre_conductor', 'Nombre: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_conductor',null, ['class'=>'form-control', 'placeholder' => '...'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('telefono_conductor', 'Telefono: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('telefono_conductor', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Conductor', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection