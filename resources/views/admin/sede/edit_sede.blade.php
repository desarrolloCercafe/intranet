@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Editar Sede | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Editar Sede</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.sedes.update', $sede], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('nombre_sede', 'Nombre de la Sede: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_sede', $sede->nombre_sede, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('descripcion_sede', 'Descripcion: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::textarea('descripcion_sede', $sede->descripcion_sede, ['class'=>'form-control', 'placeholder' => '...', 'cols' => '30', 'rows' => '10'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('telefono_sede', 'Telefono de la Sede: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('telefono_sede', $sede->telefono_sede, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Editar Sede', array('class'=>'btn btn-info btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection