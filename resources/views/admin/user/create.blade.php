@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registro | Cercafe</title> 
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus-square" aria-hidden="true"></i><strong> Agregar Usuario</strong></h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.users.store'], 'method'=>'POST'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
				<div class="row">
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('nombre_completo', 'Nombre: ', ['class' => 'control-label'])}}
						{{Form::text('nombre_completo', null, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('name', 'Usuario: ', ['class' => 'control-label'])}}
						{{Form::text('name', null, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('email', 'Correo: ', ['class' => 'control-label'])}}
						{{Form::text('email', null, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('password', 'Contraseña: ', ['class' => 'control-label'])}}
						{!!Form::password('password', ['class'=>'form-control', 'placeholder' => '******', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('documento', 'Documento: ', ['class' => 'control-label'])}}
						{{Form::text('documento', null, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('telefono', 'Telefono: ', ['class' => 'control-label'])}}
						{{Form::text('telefono', null, ['class' => 'form-control'])}}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('fecha_nacimiento', 'Fecha de Nacimiento: ', ['class'=>'control-label'])!!}
						{!!Form::text('fecha_nacimiento',null, ['id' => 'date_picker_nacimiento','class'=>'form-control', 'readonly', 'style' => 'cursor: pointer !important;', 'placeholder' => 'DD/MM/YY'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						<label class="control-label">Sexo:</label>
						<label for="radio-1">Masculino</label>
						<input type="radio" name="masculino" id="radio-1" value="1">
						<label for="radio-2">Femenino</label>
						<input type="radio" name="femenino" id="radio-2" value="1">
					</div>
					<div class="form-group col-lg-6 col-xs-12">
					        <label for="checkbox-1" class="control-label">Agente?</label>
						<input type="checkbox" name="agente" id="checkbox-1" value="1">
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('sede', 'Sede: ', ['class' => 'control-label'])}}
						{!!Form::select('sede', $sedes,[" "], ['class'=>'form-control','required' => 'required', 'placeholder' => 'Seleccione...'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('area', 'Area: ', ['class' => 'control-label'])}}
						{!!Form::select('area', $areas,[" "], ['class'=>'form-control','required' => 'required', 'placeholder' => 'Seleccione...'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('cargo', 'Cargo: ', ['class' => 'control-label'])}}
						{!!Form::select('cargo', $cargos,[" "], ['class'=>'form-control','required' => 'required', 'placeholder' => 'Seleccione...'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{{Form::label('rol', 'Rol: ', ['class' => 'control-label'])}}
						{!!Form::select('rol', $roles,[" "], ['class'=>'form-control','required' => 'required', 'placeholder' => 'Seleccione...'])!!}
					</div>
					<div class="form-group col-lg-12 col-xs-12">
						<ul class="list-inline" align="center">
							<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
							<li>{!!Form::submit('Registrar', array('class'=>'btn btn-success btn-md'))!!}</li>
						</ul>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
		<script type="text/javascript">
			$('input[type="radio"]').checkboxradio();
			$('input[type="checkbox"]').checkboxradio();
		</script>
	</div>
@endsection