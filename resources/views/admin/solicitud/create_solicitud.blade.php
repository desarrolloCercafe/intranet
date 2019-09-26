@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Crear Solicitud | Cercafe</title>
		<div class="container-fluid table-responsive">
			<div class="panel panel-danger">
				<div class="panel-heading" id="titulo">
					<h4 style="font-size: 25px;"><i class="fa fa-envelope" aria-hidden="true"></i> Realizar solicitud</h4>
				</div>
				<div class="panel-body">
					{!!Form::open(['route'=> 'admin.solicitudes.store', 'method' => 'POST' ,'files' => true])!!}
						<fieldset>
							<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
							<div class="row">
								@foreach($users as $user)
									@if($user->nombre_completo == Auth::user()->nombre_completo)
										<input type="hidden" name="id_emisor" class="form-control" value="{{ $user->id }} ">
									@endif
								@endforeach
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('agente', 'Agentes: ', ['class' => 'control-label']) !!}
									<select name="agente" id="agente" class="form-control">
										@foreach($agentes as $agente)
											<option>{{$agente->email}} </option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('asunto', 'Asunto:',['class' => 'control-label']) !!}
									{!!Form::text('asunto', null, ['class'=>'form-control','placeholder'=>'...','required']) !!}
								</div>
								<div class="form-group col-lg-12 col-xs-12">
									{!!Form::label('descripcion_solicitud', 'Descripción: ', ['class'=>'control-label'])!!}
									{!!Form::textarea('descripcion_solicitud', null, ['class'=>'form-control', 'placeholder' => '...' , 'cols' => '10' , 'rows' => '10'])!!}
								</div>	
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('fecha_creacion', 'Fecha de Envío: ', ['class' => 'control-label'])!!}
									{!!Form::date('fecha_creacion',$date,['class'=> 'form-control','readonly']) !!}
								</div>	
								<input type="hidden" name="estado" class="form-control" value="1">
		 	
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('prioridad', 'Prioridad: ', ['class' => 'control-label']) !!}
									<select class="form-control" name="prioridad" required="required">
										<option value="1" style="color: brown;">Baja</option>
										<option value="2" style="color: blue;">Normal</option>
										<option value="3" style="color: green;">Media</option>
										<option value="4" style="color: yellow;">Alta</option>
										<option value="5" style="color: red;">Urgente</option>
									</select>
								</div>	
								<div class="form-group col-lg-12 col-xs-12">
									<div class="form-div">
										<label for="file" class="input-label control-label btn">
											<span id="label_span">Seleccione Archivo</span>
										</label>
										{!!Form::file('path',['id'=>'file','multiple'=>'true'])!!}
									</div>
								</div>	
								<div class="form-group col-lg-7 col-xs-12">
									<ul class="list-inline pull-left">
										<a href="javascript:history.go(-1);" class="btn btn-danger">Cancelar</a>
										{!!Form::submit('Solicitar', array('id' => 'enviar_solicitud','class'=>'btn btn-success'))!!}
									</ul>
								</div>	
							</div>
						</fieldset>
					{!!Form::close()!!}
				</div>
			</div>
		</div>
@endsection
