@extends('template.plantilla')
@section('content')
	<title>Solicitudes | Cercafe</title>
	@include('flash::message')
	<style>
        .icon1{
		    background-color:#34B7F9;
		    color:#fff;
		    text-decoration:none;
		    display:block;
		    line-height:32px;
		    height:92px;
		    padding-left:10px;
		    border-radius:4px;
		    margin: 10px;
		    margin-right: 20px;

		}
		 .icon2{
		    background-color:#8BC34A;
		    color:#fff;
		    text-decoration:none;
		    display:block;
		    line-height:32px;
		    height:92px;
		    padding-left:10px;
		    border-radius:4px;
		    margin: 10px;
		    margin-right: 20px;

		}
		.icon3{
		    background-color:#FDAE05;
		    color:#fff;
		    text-decoration:none;
		    display:block;
		    line-height:32px;
		    height:92px;
		    padding-left:10px;
		    border-radius:4px;
		    margin: 10px;
		    margin-right: 20px;

		}
		.icon4{
		    background-color:#df0101;
		    color:#fff;
		    text-decoration:none;
		    display:block;
		    line-height:32px;
		    height:92px;
		    padding-left:10px;
		    border-radius:4px;
		    margin: 10px;
		    margin-right: 20px;

		}
		.a1{
			margin-right: 61px;
			color: white;	
		}

		.a2{
			margin-right: 61px;
			color: white;

		}

		.a3{
			margin-right: 61px;
			color: white;
		}
		.a4{
			margin-right: 61px;
			color: white;
		}
	</style>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;"><i class="fa fa-list-alt"></i> Solicitudes Recibidas</h4>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Id</strong></td>
						<td><strong>Emisor</strong></td>
						<td><strong>Asunto</strong></td>
						<td><strong>Fecha de Envio</strong></td>
						<td><strong>Estado</strong></td>
						<td><strong>Prioridad</strong></td>
					</tr>
				</thead>
				<tbody>
				@if($solicitudes)
					<?php
						$Total_peticiones       =0;
						$Peticiones_resultas    =0;
						$Peticiones_tramite     =0;
						$Peticiones_no_tramitada=0;
				 	?>
					@foreach($solicitudes as $solicitud)
						@if($solicitud->agente == Auth::user()->email)
							<tr>
								<td>{{$solicitud->id}} </td>
								<td>{{$solicitud->nombre_completo}} </td>
								<td>
									<a class="btn btn-link" href="{{route('admin.solicitudes.show',$solicitud->id)}}"><strong>{{$solicitud->asunto}}</strong></a>
								</td>
								<td>{{$solicitud->fecha_envio}} </td>

								@if($solicitud->estado_id == '1')
									<td><strong style="color: #FDAE05;">{{$solicitud->nombre_estado}} </strong></td> 

									@if($solicitud->prioridad == '1')
										<td>
											<strong style="color: brown;">Baja</strong>
										</td>
									@elseif($solicitud->prioridad == '2')
										<td>
											<strong style="color: #2E9AFE;">Normal</strong>
										</td>
									@elseif($solicitud->prioridad == '3')
										<td>
											<strong style="color: green;">Media</strong>
										</td>
									@elseif($solicitud->prioridad == '4')
										<td>
											<strong style="color: orange;">Alta</strong>
										</td>
									@elseif($solicitud->prioridad == '5')
										<td>
											<strong style="color: red;">Urgente</strong>
										</td>
									@endif
									<?php
				 		 				$Peticiones_resultas++;
				 					?>
								@elseif($solicitud->estado_id == '2')
									<td><strong style="color: #8BC34A;">{{$solicitud->nombre_estado}} </strong></td>

									@if($solicitud->prioridad == '1')
										<td>
											<strong style="color: brown;">Baja</strong>
										</td>
									@elseif($solicitud->prioridad == '2')
										<td>
											<strong style="color: #2E9AFE;">Normal</strong>
										</td>
									@elseif($solicitud->prioridad == '3')
										<td>
											<strong style="color: green;">Media</strong>
										</td>
									@elseif($solicitud->prioridad == '4')
										<td>
											<strong style="color: orange;">Alta</strong>
										</td>
									@elseif($solicitud->prioridad == '5')
										<td>
											<strong style="color: red;">Urgente</strong>
										</td>
									@endif
									<?php
				 		 				$Peticiones_tramite++;
				 					?>
								@elseif($solicitud->estado_id == '3')
									<td><strong style="color: #E11F08;">{{$solicitud->nombre_estado}} </strong></td>

									@if($solicitud->prioridad == '1')
										<td>
											<strong style="color: brown;">Baja</strong>
										</td>
									@elseif($solicitud->prioridad == '2')
										<td>
											<strong style="color: #2E9AFE;">Normal</strong>
										</td>
									@elseif($solicitud->prioridad == '3')
										<td>
											<strong style="color: green;">Media</strong>
										</td>
									@elseif($solicitud->prioridad == '4')
										<td>
											<strong style="color: orange;">Alta</strong>
										</td>
									@elseif($solicitud->prioridad == '5')
										<td>
											<strong style="color: red;">Urgente</strong>
										</td>
									@endif
									<?php 
								 		$Peticiones_no_tramitada++;
									?>
								@endif
							</tr>
							<?php
				 		 		$Total_peticiones++;
				 			?>
						@endif
					@endforeach
					<div class="text-center">
						<div class="col-md-1"></div>
						<div class="col-md-2 icon1">
							<span >
								<a  href="#" class="fa fa-ticket fa-4x a1"></a>
								<i class="fa-4x a1">
									<?php 
										print $Total_peticiones;
									?>
								</i>
							</span>
							<strong>Tickets Registrados</strong>
						</div>
						
						<div class="col-md-2 icon2">
							<span>
								<a href="#"  class="fa fa-check-square  fa-4x a2"></a> 
								<i href="#" class="fa-4x a2">
									<?php 
										print $Peticiones_tramite;
									?> 
								</i>	
							</span>
							<strong>Tramitados</strong>
						</div>
						
						<div class="col-md-2 icon3">
							<span>
								<a href="#"  class="fa fa-spinner fa-spin fa-4x a3"></a>
								<i href="#" class="fa-4x a3">
									<?php
						 		 		print $Peticiones_resultas;
						 			?>
								</i>
							</span>
							
							<strong>Pendientes</strong>
						</div>
						
						<div class="col-md-2 icon4">
							<span>
								<a href="#" class="fa fa-exclamation-circle fa-4x a4"></a>
								<i href="#" class="fa-4x a4">
									<?php 
										print $Peticiones_no_tramitada;
									?>
								</i> 
							</span>
							<strong>No Tramitados</strong>
						</div>
					</div>
				@endif
				</tbody>
			</table>
		</div>
	</div>
@endsection