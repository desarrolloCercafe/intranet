@extends('template.plantilla')
@section('content')
	<title>Solicitudes Enviadas | Cercafe</title>
	@include('flash::message')	
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;"><i class="fa fa-list-alt"></i> Solicitudes Enviadas</h4>
		</div>
		<div class="panel-body table-responsive">
			<table class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Id</strong></td>
						<td><strong>De</strong></td>
						<td><strong>Para</strong></td>
						<td><strong>Asunto</strong></td>
						<td><strong>Fecha</strong></td>
						<td width="20"><strong>prioridad</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($solicitudes as $solicitud)
					@if(Auth::user()->id == $solicitud->emisor_id)
						<tr>
							<td>{{ $solicitud->id }}</td>
							<td>{{ $solicitud->nombre_completo }}</td>
							<td>{{ $solicitud->agente }}</td>
							<td>
								<a class="btn btn-link" href="{{ route('admin.respuesta.show', $solicitud->id) }}"><strong>{{ $solicitud->asunto }}</strong></a>
							</td>
							<td>{{ $solicitud->fecha_envio}}</td>

							@if($solicitud->estado_id == '1')
								<td>
									<strong class="text-primary">
										{{ $solicitud->nombre_estado}}
									</strong> 
								</td> 
							@elseif($solicitud->estado_id == '2')
								<td>
									<strong style="color: #8BC34A;">
										{{ $solicitud->nombre_estado}}
									</strong>
								</td>
							@elseif($solicitud->estado_id == '3')
								<td>
									<strong class="text-danger">
											{{ $solicitud->nombre_estado}}
									</strong>
								</td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
			</table>
		</div>
	</div>									
@endsection



