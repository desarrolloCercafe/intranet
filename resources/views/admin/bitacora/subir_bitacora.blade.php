@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Archivar Bitacora | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;"><i class="fa fa-envelope" aria-hidden="true"></i> Subir Archivo</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.bitacora.store', 'method'=>'POST', 'files' => true])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="row">
					<div class="form-group col-lg-6">
						{!!Form::label('nombre_archivo', 'Nombre del Archivo: ', ['class'=>'control-labell'])!!}
						{!!Form::text('nombre_archivo', null, ['class'=>'form-control'])!!}
					</div>
					<div class="form group col-lg-6">
						{!!Form::label('nombre_usuario', 'Autor: ', ['class'=>'control-label'])!!}
						{!!Form::text('nombre_usuario', Auth::user()->nombre_completo, ['class'=>'form-control', 'readonly'])!!}
					</div>
					<div class="form-group col-lg-12 col-xs-12">
						<div class="form-div">
							<label for="file" class="input-label control-label btn">
								<span id="label_span">Seleccione Archivo</span>
							</label>
							{!!Form::file('path', ['id' => 'file', 'class'=>'form-control', 'multiple' => 'true', 'required'])!!}
						</div>
					</div> 
					<div class="form-group col-lg-7">
						<ul class="list-inline pull-right">
							<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
							<li>{!!Form::submit('Subir a Bitácora', array('class'=>'btn btn-success btn-md'))!!}</li>
						</ul>
					</div>	
				</div>
			</form>
		</div>
	</div>
@endsection