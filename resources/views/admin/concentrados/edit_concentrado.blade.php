@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Editar Concentrado| Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Editar Concentrado</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.concentrados.update', $concentrado], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('ref_medicamento', 'Referencia: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('ref_concentrado', $concentrado->ref_concentrado, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('nombre_concentrado', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">	
						{!!Form::text('nombre_concentrado', $concentrado->nombre_concentrado, ['class'=>'form-control', 'placeholder' => '...'])!!}
					</div> 
				</div>
				<div class="form-group">
					{!!Form::label('tipo_concentrado', 'Tipo: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('tipo_concentrado', $concentrado->tipo_concentrado, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('kg', 'Unidad en Kilogramos: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('kg', $concentrado->kg, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Editar Concentrado', array('class'=>'btn btn-info btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection