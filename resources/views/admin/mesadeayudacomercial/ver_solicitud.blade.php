
@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<meta charset="utf-8">
	<title>PQR Numero {{$solicitud->id}} </title>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6">
				<h2 style="color: red;"><strong>PQR Numero: {{$solicitud->id}}</strong></h2>
			</div>
			<div class="col-lg-6">
				<h2 style="color: red;"><strong>Motivo: </strong>{{$solicitud->motivo_descripcion}}</h2>
			</div>
			@if($solicitud->motivo_adicional != null)
				<div class="col-lg-6">
					<h2><strong>Motivo Adicional: </strong>{{$solicitud->motivo_adicional}} </h2>
				</div>
			@endif
			<div class="col-lg-6">
				<h4><strong>Nombre Completo: </strong>{{$solicitud->nombre_completo}} </h4>
			</div>
			<div class="col-lg-6">
				<h4><strong>Medio de la PQR: </strong>{{$solicitud->medio}}</h4>
			</div>
			<div class="col-lg-6">
				<h4><strong>Categoria de la PQR: </strong>{{$solicitud->categoria}}</h4>
			</div>
			<div class="col-lg-6">
				<h4><strong>Cedula: </strong>{{$solicitud->cedula}} </h4>
			</div>
			<div class="col-lg-6">
				<h4><strong>Direccion: </strong>{{$solicitud->direccion}}</h4>
			</div>
			<div class="col-lg-6">
				<h4><strong>Telefono: </strong>{{$solicitud->telefono}}</h4>
			</div>
			<div class="col-lg-6">
				<h4><strong>Correo Electronico de la Persona: </strong>{{$solicitud->correo_electronico}} </h4>
			</div>
			<div class="col-lg-6">
				<h4><strong>Fecha y Hora de Envio: </strong>{{$solicitud->fecha_hora}} </h4>
			</div>
			@foreach($emisario as $user)
				<div class="col-lg-6">
					<h4><strong>Ingresado Por:</strong>{{$user->nombre_completo}} </h4>
				</div>
			@endforeach
			<div class="col-lg-6">
				@if($estado->nombre_estado == 'Tramitado')
					<h4><strong>Estado: </strong><strong style="color: green;"> {{$estado->nombre_estado}}</strong></h4>
				@elseif ($estado->nombre_estado == 'Pendiente')
					<h4><strong>Estado:</strong><strong style="color: red;"> {{$estado->nombre_estado}}</strong></h4>
				@elseif($estado->nombre_estado == 'Recibido')
					<h4><strong>Estado:</strong><strong style="color: blue;">{{$estado->nombre_estado}} </strong></h4>
				@endif
			</div>
			<div class="form-group col-lg-12">
				<h3><strong>Descripcion: </strong></h3>
				<textarea name="" id="" class="form-control" readonly rows="15">{{$solicitud->descripcion}} </textarea>
			</div>
			<div class="form-group col-lg-6">
				@if($solicitud->path != null)
					<a href="{{route('admin.solicitudComercio.downloadFile',$solicitud->path)}} " class="btn btn-primary">
						<span class="fa fa-download" aria-hidden="true">
							<strong>Descargar Adjunto</strong>
						</span>
					</a>
				@endif
			</div>
			<div class="col-lg-12">
				@foreach($users as $user)
					@if(Auth::User()->rol_id == 12 || Auth::User()->rol_id == 7 || Auth::User()->id == 36)
						@if(Auth::User()->id == $user->id)
							{!!Form::open(['route'=>'admin.respuestacomercio.store','class'=>'form-horizontal','method'=>'POST']) !!}
								@if($estado->nombre_estado == 'Pendiente')
									<div class="form-group col-md-12 control-label">
										<a href="javascript:history.go(-1);" class="btn btn-info"><span class="fa fa-arrow-circle-o-left"></span> Regresar</a><br/><br/>
									</div>
								@elseif($estado->nombre_estado == 'Recibido')
									<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
									{!!Form::hidden('emisario',$user->id)!!}
									{!!Form::hidden('moderador',$user->nombre_completo)!!}
									{!!Form::hidden('solicitud_id',$solicitud->id)!!}
									{!!Form::hidden('motivo_descripcion',$solicitud->motivo_descripcion)!!}
									{!!Form::hidden('motivo_adicional',$solicitud->motivo_adicional)!!}
									{!!Form::hidden('correo',$solicitud->correo_electronico)!!}
									{!!Form::hidden('agente',$solicitud->agente)!!}
									{!!Form::hidden('fecha_redaccion',null)!!}
									{{-- <input type="hidden" name="correo_secundario" value="servicioalcliente@cercafe.com.co"> --}}
									<div class="form-group">
										<label for="">Por favor Digite la Respuesta:</label>
										{!!Form::textarea('descripcion_respuesta',null,['class'=>'form-control','placeholder'=>'....','style' => 'margin-top: 1em;','required'])!!}
									</div>
									<div class="form-group col-md-12 control-label">
										{!!Form::submit('Enviar respuesta', array('class'=>'btn btn-warning'))!!}
										<a href="javascript:history.go(-1);" class="btn btn-info"><span class="fa fa-arrow-circle-o-left"></span> Regresar</a><br/><br/>
									</div>
								@endif
							{!!Form::close()!!}
							{!!Form::open(['url' => 'admin/recibir','method' => 'POST','class' => 'form-horizontal'])!!}
								{!!Form::hidden('agente',$solicitud->agente)!!}
								{!!Form::hidden('solicitud_id',$solicitud->id)!!}
								{!!Form::hidden('correo',$solicitud->correo_electronico)!!}
								{!!Form::hidden('motivo_descripcion',$solicitud->motivo_descripcion)!!}
								{!!Form::hidden('motivo_adicional',$solicitud->motivo_adicional)!!}
								{!!Form::hidden('descripcion',$solicitud->descripcion)!!}
								{{-- <input type="hidden" name="correo_secundario" value="servicioalcliente@cercafe.com.co"> --}}
								@if($estado->nombre_estado == 'Pendiente')
									<div class="form-group col-md-12 control-label">
										{!!Form::submit('Recibir Solicitud',array('class'=>'btn btn-info'))!!}
									</div>
								@elseif($estado->nombre_estado == 'Tramitado')

								@endif
							{!!Form::close()!!}
						@endif
					@endif
				@endforeach
				<h1>Respuesta de la solicitud</h1>
				<div class="panel-body table-responsive">	
					<table class="table table-bordered table-hover text-center">
						<thead>
							<tr style="color: white;">
								<th>Fecha y Hora de Redaccion</th>
								<th>Usuario quien Respondio la Solicitud</th>
								<th>Descripcion de la Respuesta</th>
							</tr>
						</thead>
						<tbody>
							@foreach($respuestas as $respuesta)
								@if($respuesta->solicitud_id == $solicitud->id)
									<tr>
										<td>{{$respuesta->fecha_redaccion}}</td>
										<td>{{$respuesta->nombre_completo}}</td>
										<td><textarea name="" id="" class="form-control" cols="30" rows="10" readonly>{{$respuesta->descripcion}}</textarea></td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			var d = new Date();
	        var m = d.getMonth() + 1;
	        var mes = (m < 10) ? '0' + m : m;
	        d = (d.getFullYear()+'-'+mes+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
	        // console.log(d);
	        $("[name='fecha_redaccion']").val(d);
		})
	</script>
@endsection