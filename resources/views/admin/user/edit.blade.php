@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Editar | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus-square" aria-hidden="true"></i><strong> Editar Usuario</strong></h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.users.update', $user], 'method'=>'PUT'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="row">
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('nombre_completo', 'Nombre: ', ['class' => 'control-label'])}}
						{{Form::text('nombre_completo', $user->nombre_completo, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('name', 'Usuario: ', ['class' => 'control-label'])}}
						{{Form::text('name', $user->name, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('email', 'Correo: ', ['class' => 'control-label'])}}
						{{Form::text('email', $user->email, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('documento', 'Documento: ', ['class' => 'control-label'])}}
						{{Form::text('documento', $user->documento, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('telefono', 'Telefono: ', ['class' => 'control-label'])}}
						{{Form::text('telefono', $user->telefono, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('fecha_nacimiento', 'Fecha de Nacimiento: ', ['class'=>'control-label'])!!}
						{!!Form::text('fecha_nacimiento',$user->fecha_nacimiento, ['id' => 'date_picker_nacimiento','class'=>'form-control', 'readonly', 'style' => 'cursor: pointer !important;', 'placeholder' => 'DD/MM/YY'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('sede', 'Sede: ', ['class' => 'control-label'])}}
						{!!Form::select('sede',$sedes,[$user->sede_id],['class'=>'form-control','required' => 'required', 'placeholder' => 'seleccione...'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('area', 'Area: ', ['class' => 'control-label'])}}
						{!!Form::select('area',$areas,[$user->area_id],['class'=>'form-control','required' => 'required', 'placeholder' => 'seleccione...'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('cargo', 'Cargo: ', ['class' => 'control-label'])}}
						{!!Form::select('cargo',$cargos,[$user->cargo_id],['class'=>'form-control','required' => 'required', 'placeholder' => 'seleccione...'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('rol', 'Rol: ', ['class' => 'control-label'])}}
						{!!Form::select('rol',$roles,[$user->rol_id],['class'=>'form-control','required' => 'required', 'placeholder' => 'seleccione...'])!!}
					</div>
					<div class="form-group col-lg-12 col-xs-12">
						<ul class="list-inline" align="center">
							<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
							<li>{!!Form::submit('Editar Usuario', array('class'=>'btn btn-info btn-md'))!!}</li>
						</ul>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection