@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registrar Rol | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Editar Rol</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.roles.update', $rol], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('nombre_rol', 'Nombre: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_rol', $rol->nombre_rol, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Editar', array('class'=>'btn btn-info btn-md'))!!}</li>	
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection