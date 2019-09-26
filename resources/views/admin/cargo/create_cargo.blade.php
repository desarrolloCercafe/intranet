@extends('template.plantilla')
@section('content')
@include('flash::message')
	<title>Registrar Cargos | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Cargo</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.cargos.store', 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('nombre_cargo', 'Nombre: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_cargo', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('descripcion_cargo', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::textarea('descripcion_cargo',null, ['class'=>'form-control', 'cols' => '30', 'rows' => '10'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Cargo', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection