@extends('template.plantilla')
@section('content') 
	<title>Cambiar Contraseña | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center">Restaurar Contraseña a <strong>{{$user->name}}</strong></h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.pass.update', $user], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{{Form::label('email_usuario', 'Email: ', ['class' => 'col-lg-4 control-label'])}}
					<div class="col-lg-4">
						{{Form::text('email_usuario', $user->email, ['class' => 'form-control', 'readonly'])}}
					</div>
				</div>
				<div class="form-group">
					{{Form::label('new_password', 'Nueva Contraseña: ', ['class' => 'col-lg-4 control-label'])}}
					<div class="col-lg-4">
						{!!Form::password('new_password',['class'=>'form-control', 'placeholder' => '*******', 'required'])!!}
					</div>
				</div>
				<div class="form-group">
					{{Form::label('repeat_password', 'Confirmar Contraseña: ', ['class' => 'col-lg-4 control-label'])}}
					<div class="col-lg-4">
						{!!Form::password('repeat_password',['class'=>'form-control', 'placeholder' => '*******', 'required'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Reestablecer', array('class'=>'btn btn-warning'))!!}</li>
					</ul> 
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection