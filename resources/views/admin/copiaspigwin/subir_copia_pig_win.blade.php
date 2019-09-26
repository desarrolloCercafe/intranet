@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Nueva Copia | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center">Subir BackUp PigWin</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.copiaPigWin.store', 'class'=>'form-horizontal', 'method'=>'POST', 'files' => true])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('fecha_actual', 'Fecha de Envío: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::date('fecha_actual',$date, ['class'=>'form-control', 'readonly'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('granja', 'Tu Granja: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!! Form::select('granja', $granjas, array('0' => 'Seleccione una granja'), ['placeholder' => 'Selecciona una granja', 'class' => 'form-control col-xs-8' ]) !!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('nombre_archivo', 'Nombre de Archivo: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_archivo', null, ['class'=>'form-control', 'placeholder' => 'name', 'required'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('nombre_usuario', 'Autor: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_usuario', Auth::user()->nombre_completo, ['class'=>'form-control', 'placeholder' => 'Nombre', 'required', 'readonly'])!!}
					</div>
				</div>
				<div class="form-group text-center">
					<div class="form-div">
						<label for="file" class="input-label control-label btn">
							<span id="label_span">Seleccione Archivo</span>
						</label>
						{!!Form::file('path',['id'=>'file','multiple'=>'true', 'required'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<a href="javascript:history.go(-1);" class="btn btn-danger">Cancelar</a>
						<li>{!!Form::submit('Subir Copia', array('id' =>'enviar_pigwin','class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>		
@endsection