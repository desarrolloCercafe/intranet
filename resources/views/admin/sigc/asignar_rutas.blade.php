@extends('template.plantilla')
@section('content')
	<div class="container" >
		<meta charset="utf-8"> 
		<title>Asignar Rutas | Cercafe</title>
		@include('flash::message')
		{!!Form::open(['route'=> 'admin.usRutas.store', 'class'=>'form-horizontal', 'method'=>'POST', 'style'=>'background: #fafafa;'])!!}
			<fieldset>
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<legend><span style="margin-left: 37%; color: #df0101; font-size:30px;">Asignar Ruta</span></legend>

				<div class="form-group">
					{!!Form::label('usuario', 'Usuarios: ', ['class'=>'col-md-4 control-label'])!!}
					<div class="col-md-4">
						{!!Form::select('usuario', $usuarios, ['class'=>'form-control','required' => 'required'])!!}	
					</div>
				</div>
						
				<div class="form-group">
					{!!Form::label('ruta', 'Ruta: ', ['class'=>'col-md-4 control-label'])!!}
					<div class="col-md-4">
						{!!Form::select('ruta', $rutas, ['class'=>'form-control','required' => 'required'])!!}
					</div>
				</div>

				<!-- Button -->
				<div class="form-group">
					<div class="col-md-4 control-label" style="margin-left: 20%">
						{!!Form::submit('Asignar', array('class'=>'btn btn-primary'))!!}
						<a href="{{ route('admin.usRutas.index') }}" class="btn btn-danger">Cancelar</a>
					</div>
				</div>
			</fieldset>
		{!!Form::close()!!}
	</div>
@endsection
			
			