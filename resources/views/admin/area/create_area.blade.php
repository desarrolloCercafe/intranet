@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registrar Area | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Area</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.areas.store'], 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('nombre_area', 'Nombre: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_area', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('descripcion_area', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::textarea('descripcion_area',null, ['class'=>'form-control', 'cols' => '30', 'rows' => '10'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Area', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{{Form::close()}}
		</div>
	</div>
@endsection