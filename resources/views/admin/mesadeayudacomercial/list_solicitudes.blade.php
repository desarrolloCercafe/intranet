@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Lista de Solicitudes</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-th-list" aria-hidden="true"></i> Quejas y Reclamos</h4>
		</div>
		<br>
		<div class="form-group container-fluid">
			@if(Auth::User()->rol_id == 7 || Auth::User()->id == 20 || Auth::User()->id == 36 || Auth::User()->id == 3)
				<a href="excelComercio" class="btn btn-success"><i>{!!Html::image('http://201.236.212.130:82/intranetcercafe/public/c.png','us',array('class' => 'imuser'))!!} </i> Exportar</a>
			@endif
		</div>
		<div class="panel-body table-responsive">	
			<table class="table table-bordered table-hover text-center" id="listComercio">
				<thead>
					<tr style="color: white;">
						<th>Numero de la Solicitud</th>
						<th>Correo al que fue Enviado</th>
						<th>Nombre de la Persona</th>
						<th>Motivo de la Peticion</th>
						<th>Motivo Adicional de la Peticion</th>
						<th>Fecha y Hora del Envio</th>
						<th>Estado</th>
						<th>Accion</th>
					</tr>
				</thead>
				<tbody>
					@foreach($solicitudes as $solicitud)
						@if(Auth::User()->id == 3 || Auth::User()->id == 32 || Auth::User()->id == 36 || Auth::User()->id == 18 || Auth::User()->id == 20 || Auth::User()->id == 65)
							<tr>
								<td><strong>SO</strong>{{$solicitud->id}} </td>
								<td>{{$solicitud->agente}} </td>
								<td>{{$solicitud->nombre_completo}}</td>
								<td>{{$solicitud->motivo_descripcion}}</td>
								@if($solicitud->motivo_adicional != null)
									<td>{{$solicitud->motivo_adicional}} </td>
								@else
									<td>No hay Motivo Adicional</td>
								@endif
								<td>{{$solicitud->fecha_hora}}</td>
								@if($solicitud->estado_id == 1)
									<td style="color: red;"><strong>{{$solicitud->nombre_estado}}</strong></td>
								@elseif($solicitud->estado_id == 2)
									<td style="color: green;"><strong>{{$solicitud->nombre_estado}}</strong></td>
								@elseif($solicitud->estado_id == 4)
									<td style="color: blue;"><strong>{{$solicitud->nombre_estado}} </strong></td>
								@endif
								<td><a href="{{route('admin.solicitudComercio.show',$solicitud->id)}}" data-toggle="tooltip" data-placement="top" title="Ver Informacion Detallada de la Solicitud" class="btn btn-link" aria-hidden="true"><i class="fa fa-eye fa-lg"></i></a></td>
							</tr>
						@else
							@if(Auth::User()->id == $solicitud->emisario_id)
								<tr>
									<th><strong>SO</strong>{{$solicitud->id}}</th>
									<td>{{$solicitud->agente}} </td>
									<td>{{$solicitud->nombre_completo}}</td>
									<td>{{$solicitud->motivo_descripcion}}</td>
									@if($solicitud->motivo_adicional != null)
										<td>{{$solicitud->motivo_adicional}} </td>
									@else 
										<td>No hay Motivo Adicional</td>
									@endif
									<td>{{$solicitud->fecha_hora}}</td>
									@if($solicitud->estado_id == 1)
										<td style="color: red;"><strong>{{$solicitud->nombre_estado}}</strong></td>
									@elseif($solicitud->estado_id == 2)
										<td style="color: green;"><strong>{{$solicitud->nombre_estado}}</strong></td>
									@elseif($solicitud->estado_id == 4)
										<td style="color: blue;"><strong>{{$solicitud->nombre_estado}} </strong></td>
									@endif
									<td><a href="{{route('admin.solicitudComercio.show',$solicitud->id)}}" data-toggle="tooltip" data-placement="top" title="Ver Informacion Detallada de la Solicitud" class="btn btn-link" aria-hidden="true"><i class="fa fa-eye fa-lg"></i></a></td>
								</tr>
							@endif
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$("#listComercio").DataTable({
				"language": {
					"sProcessing":     "Procesando...",
				    "sLengthMenu":     "Mostrar _MENU_ registros",
				    "sZeroRecords":    "No se encontraron resultados",
				    "sEmptyTable":     "Ningún dato disponible en esta tabla",
				    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				    "sInfoPostFix":    "",
				    "sSearch":         "Buscar:",
				    "sUrl":            "",
				    "sInfoThousands":  ",",
				    "sLoadingRecords": "Cargando...",
				    "oPaginate": {
				        "sFirst":    "Primero",
				        "sLast":     "Último",
				        "sNext":     "Siguiente",
				        "sPrevious": "Anterior"
				    },
				    "oAria": {
				        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
				    }
				},
				responsive: {
					breakpoints: [
				      {name: 'bigdesktop', width: Infinity},
				      {name: 'meddesktop', width: 1480},
				      {name: 'smalldesktop', width: 1280},
				      {name: 'medium', width: 1188},
				      {name: 'tabletl', width: 1024},
				      {name: 'btwtabllandp', width: 848},
				      {name: 'tabletp', width: 768},
				      {name: 'mobilel', width: 480},
				      {name: 'mobilep', width: 320}
				    ]
				}
			});
		})
	</script>
@endsection