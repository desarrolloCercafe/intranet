@extends('template.plantilla')
@section('content')

	<title>Pedidos Concentrado | Cercafe</title>
	<style type="text/css">
		a>strong{
			font-weight: 700;
		}
		a:hover{
			text-decoration: none;
		}
		div.modal-header{
			background: red;
		}
		div.modal-header>h3{
			color: white;
		}
	</style>
	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Pedidos por validar</h4>
		</div>
		<br>
		@if(Auth::User()->rol_id == 9 || Auth::User()->rol_id == 7)
			<div class="container-fluid col-lg-12">
				{!!Form::open(['route'=>'admin.filterConcentradoPedidos.store','class'=>'form-inline','method'=>'POST'])!!}
					<div class="form-group">
						<label>Desde:</label>
						{!!Form::text('fecha_de',null, ['id' => 'date_picker_desde', 'class'=>'form-control', 'readonly', 'required', 'style' => 'cursor: pointer !important;'])!!}
					</div>
					<div class="form-group">
						<label>Hasta:</label>
						{!!Form::text('fecha_hasta',null, ['id' => 'date_picker_hasta', 'class'=>'form-control', 'readonly', 'required', 'style' => 'cursor: pointer !important;'])!!}
					</div>
					<div class="form-group">
						{!! Form::select('granja', $granjas, array('0' => 'Seleccione una granja'), ['placeholder' => 'Selecciona una granja', 'class' => 'form-control' ]) !!}
					</div>
					<div class="form-group">
						<select name="tipo" id="tipo" class="form-control">
	                        <option value="">Formato de Busqueda</option>
	                        <option value="pd">Pedidos</option>
	                        <option value="pr">Productos</option>
	                    </select>
					</div>
					<div class="form-group">
						{!!Form::submit('Buscar', array('class'=>'btn btn-success'))!!}
					</div>
					<div class="form-group pull-right">
						<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
						<a href="{{ route('admin.entregaconcentrados.index')}}" class="btn btn-warning"><i class="fa fa-clock"> </i> Asignar Turno</a>
					</div>
				{!! Form::close() !!}
			</div>
		@endif
		<div class="panel-body table-responsive" style="overflow-y: scroll;">
			<table id="tabla_consecutivos" class="table table-bordered table-hover text-center" cellpadding="0" width="100%">
				<thead style="background-color: #df0101;">
					<tr style="color: white;">
						<td><strong>Consecutivo</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha de Creación</strong></td>
						<td><strong>Fecha Estimada</strong></td>
						<td><strong>Tipo Pedido</strong></td>
						<td><strong>Fecha de Entrega</strong></td>
						<td><strong>Conductor</strong></td>
						<td><strong>Vehiculo</strong></td>
						<td><strong>Documentacion</strong></td>
					</tr>
				</thead>
				<tbody>
					@if($pedidos)
						<?php
							$total_pedidos = 0;
							$pedidos_tramitados = 0;
							$pedidos_pendientes = 0;
						?>
					@endif
					@if(Auth::User()->rol_id == 10)
						@foreach($g_as as $g)
							@if($g->user_id == Auth::User()->id)
								@foreach($pedidos as $pedido)
									@if($g->granja_id == $pedido->granja_id)
										@if($pedido->estado_id != 8 && $pedido->estado_id != 2 && $pedido->estado_id != 9)
											<script type="text/javascript">
												$(document).ready(function ()
												{
													$("#modificar_f_concentrados{{$pedido->consecutivo}}").datepicker(
													{
														changeMonth: true,
														changeYear: true,
														yearRange: "1950:2100",
														dateFormat: "yy-mm-dd",
														showButtonPanel: true,
													});
												})
												function enviarCampos(id, dif)
									            {
															var modificar = [];
									            			var consecutivo = id;
									            			var entrega = document.getElementById("modificar_f_concentrados"+id).value;
									            			var conductor = document.getElementById("cd"+id).value;
															var vehiculo = document.getElementById("vh"+id).value;

															var fecha_estimada = document.getElementById("fecha_estimada"+id).innerHTML;
															var fecha_creacion = document.getElementById("fecha_creacion"+id).innerHTML;

									            			console.log(id + " " + consecutivo + " " + entrega + " " + conductor + " " + vehiculo);

										           		item = {}
									               		item["cons"] = consecutivo;
									               		item["fecha"] = entrega;
									               		item["cond"] = conductor;
															item["placa"] = vehiculo;
															item["fecha_estimada"] = fecha_estimada;
															item["fecha_creacion"] = fecha_creacion;

									               		modificar.push(item);

														   modificar["modificar_concentrados"] = modificar;

														   console.log("llego1");

															console.log(modificar);
															var token = $("#token").val();
															$.ajax({
											       		    type: "POST",
											       		    headers: {'X-CSRF-TOKEN': token},
											       		    url: "http://201.236.212.130:82/intranetcercafe/public/admin/modificarPedidoC",
											       		    dataType: 'json',
											       		    data: {data: JSON.stringify(modificar)}
											       		});
											       		swal({
						                           		    title:'Pedido Modificado Satisfactoriamente.',
						                           		    text:'',
						                           		    type:'success',
						                           		    showCancelButton:false,
						                           		    buttons:true,
						                           		    successMode:true
						                           		})
						                           		.then((willDelete) => {
						                           		  if (willDelete) {
						                           		     location.reload(true);
						                           		  } else {
						                           		    swal("Ha ocurrido un Error!");
						                           		  }
						                           		});
													}
											</script>
											<tr id="fila{{$pedido->consecutivo}}" class="fila{{$pedido->consecutivo}}">
												<td>
							                        <a href="#" class="consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido->consecutivo}}</a>
							                    </td>
							                    <td>{{ $pedido->nombre_granja }}</td>
							                    <td id="fecha_creacion{{$pedido->consecutivo}}">{{ $pedido->fecha_creacion }}</td>
												<td id="fecha_estimada{{$pedido->consecutivo}}">{{ $pedido->fecha_estimada }}</td>
												<?php
													$fechaFin = strtotime($pedido->fecha_estimada);
													$fechaInicio = strtotime($pedido->fecha_creacion);

													$resultado =$fechaFin - $fechaInicio;

													$diferencia = round($resultado/86400);
												?>
			                    				<td>
													@if ($diferencia <  5)
														<style>
															.fila{{$pedido->consecutivo}}{
																background:#b0f7f4 ;
															}
														</style>
														@if ($pedido->estado_id == 6)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background:  #f7e90d ;
																}
															</style>
														@endif
														@if ($pedido->estado_id == 7)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background:  #6af70d;
																}
															</style>
														@endif
														<strong style="color: red;">Adicional</strong>
													@else
														<strong style="color: blue;">Semanal</strong>
													@endif
												</td>
						                    	<td>
							                    	<input id="modificar_f_concentrados{{$pedido->consecutivo}}" class="form-control" type="text" name="fecha" value="{{ $pedido->fecha_entrega }}" readonly />
							                    </td>
							                    <td>
							                    	<select name="conductor" class="form-control" style="width: 100% !important;" id="cd{{$pedido->consecutivo}}" selected="selected" />
							                    		@if($pedido->conductor_asignado == 'por verificar')
								                    		<option value="por verificar">{{ $pedido->conductor_asignado }}</option>
							                                @foreach($conduct as $c)
							                                    <option value="{{$c->id}}">{{$c->nombre}}</option>
							                                @endforeach
							                            @else
							                            	@foreach($conduct as $c)
							                            		@if($pedido->conductor_asignado == $c->nombre)
							                                    	<option value="{{$c->id}}">{{$c->nombre}}</option>
							                                    @endif
							                                @endforeach
							                                @foreach($conduct as $c)
							                                    <option value="{{$c->id}}">{{$c->nombre}}</option>
							                                @endforeach
							                            @endif
							                        </select>
							                    </td>
							                    <td>
							                    	<select name="vehiculo" class="form-control" style="width: 100% !important;" id="vh{{$pedido->consecutivo}}" selected="selected">
						                                @if($pedido->vehiculo_asignado == 'por verificar')
								                    		<option value="por verificar">{{ $pedido->vehiculo_asignado }}</option>
							                                @foreach($vehicul as $v)
						                                    	<option value="{{$v->id}}">{{$v->placa}}</option>
						                                	@endforeach
							                            @else
							                            	@foreach($vehicul as $v)
							                            		@if($pedido->vehiculo_asignado == $v->placa)
							                                    	<option value="{{$v->id}}">{{$v->placa}}</option>
							                                    @endif
							                                @endforeach
							                                @foreach($vehicul as $v)
							                                    <option value="{{$v->id}}">{{$v->placa}}</option>
							                                @endforeach
							                            @endif
							                        </select>
							                    </td>
						                        <td>
													<a  class="btn btn" id="validar" onclick="enviarCampos({{ $pedido->consecutivo }}, {{$diferencia}});"><i class="fa fa-check-square fa-2x"></i></a>
						                        	 <a href="editarpedidoC/{{$pedido->consecutivo}}" class="btn btn"><i class="fa fa-edit fa-2x" style="color: #FDAE05;"></i></a>
					                            </td>
					                        </tr>
										@endif
									@endif
								@endforeach
							@endif
						@endforeach
					@elseif(Auth::User()->rol_id == 6)
						@foreach($g_as as $g)
							@if($g->user_id == Auth::User()->id)
								@foreach($pedidos as $pedido)
									@if($pedido->estado_id == 1 || $pedido->estado_id == 6 || $pedido->estado_id == 7)
										@if($g->granja_id == $pedido->granja_id)
					                    	<tr id="fila{{$pedido->consecutivo}}" class="fila{{$pedido->consecutivo}}">
						                    	<td>
							                        <a href="#" class="consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido->consecutivo}}</a>
							                    </td>
							                    <td>{{ $pedido->nombre_granja }}</td>
							                    <td id="fecha_creacion{{$pedido->consecutivo}}">{{ $pedido->fecha_creacion }}</td>
							                    <td id="fecha_estimada{{$pedido->consecutivo}}">{{ $pedido->fecha_estimada }}</td>
						                		<?php
													$fechaFin = strtotime($pedido->fecha_estimada);
													$fechaInicio = strtotime($pedido->fecha_creacion);
													$resultado =$fechaFin - $fechaInicio;
													$diferencia = round($resultado/86400);
												?>
			                    				<td>
													@if ($diferencia <  5)
														<style>
															.fila{{$pedido->consecutivo}}{
																background:#b0f7f4 ;
															}
														</style>
														@if ($pedido->estado_id == 6)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background:  #f7e90d ;
																}
															</style>
														@endif
														@if ($pedido->estado_id == 7)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background:  #6af70d;
																}
															</style>
														@endif
														<strong style="color: red;">Adicional</strong>
													@else
														<strong style="color: blue;">Semanal</strong>
													@endif
												</td>
						                		<td>
							                    	<strong>
							                    		{{ $pedido->fecha_entrega }}
							                    	</strong>
							                    </td>
							                    <td>
							                    	{{ $pedido->conductor_asignado }}</option>
							                    </td>
							                    <td>
													{{ $pedido->vehiculo_asignado }}
							                    </td>
						                        <td>
						                            <a href="/intranetcercafe/public/admin/excelPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
						                            <a href="/intranetcercafe/public/admin/pdfPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
						                        </td>
					                       	</tr>
										@endif
									@elseif($pedido->estado_id == 1 || $pedido->estado_id == 6 || $pedido->estado_id == 7)
										<tr id="fila{{$pedido->consecutivo}}" class="fila{{$pedido->consecutivo}}">
					                    	<td>
						                        <a href="#" class="consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido->consecutivo}}</a>
						                    </td>
						                    <td>{{ $pedido->nombre_granja }}</td>
						                    <td id="fecha_creacion{{$pedido->consecutivo}}">{{ $pedido->fecha_creacion }}</td>
											<td id="fecha_estimada{{$pedido->consecutivo}}">{{ $pedido->fecha_estimada }}</td>
											<?php
													$fechaFin = strtotime($pedido->fecha_estimada);
													$fechaInicio = strtotime($pedido->fecha_creacion);
													$resultado =$fechaFin - $fechaInicio;
													$diferencia = round($resultado/86400);
											?>
			                    			<td>
													@if ($diferencia < 5)
														<style>
															.fila{{$pedido->consecutivo}}{
																background:#b0f7f4 ;
															}
														</style>
														@if ($pedido->estado_id == 6)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background:  #f7e90d ;
																}
															</style>
														@endif
														@if ($pedido->estado_id == 7)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background:  #6af70d ;
																}
															</style>
														@endif
														<strong style="color: red;">Adicional</strong>
													@else
														<strong style="color: blue;">Semanal</strong>
													@endif
											</td>
					                		<td>
						                    	<strong>
						                    		-----
						                    	</strong>
						                    </td>
						                    <td>
						                    	----
						                    </td>
						                    <td>
												----
						                    </td>
					                        <td>
					                             <a href="editarpedidoC/{{$pedido->consecutivo}}" class="btn btn"><i class="fa fa-edit fa-2x" style="color: #FDAE05;"></i></a>
					                        </td>
				                       	</tr>
									@endif
								@endforeach
							@endif
						@endforeach
					@elseif(Auth::User()->rol_id == 9)
						@foreach($pedidos as $pedido)
							@if($pedido->estado_id == 1 || $pedido->estado_id == 6 || $pedido->estado_id == 7)
								<tr id="fila{{$pedido->consecutivo}}" class="fila{{$pedido->consecutivo}}">
									<td>
				                        <a href="#" class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido->consecutivo}}</a>
				                    </td>
				                    <td>{{ $pedido->nombre_granja }}</td>
				                    <td id="fecha_creacion{{$pedido->consecutivo}}">{{ $pedido->fecha_creacion }}</td>
									<td id="fecha_estimada{{$pedido->consecutivo}}">{{ $pedido->fecha_estimada }}</td>
										<?php
													$fechaFin = strtotime($pedido->fecha_estimada);
													$fechaInicio = strtotime($pedido->fecha_creacion);
													$resultado =$fechaFin - $fechaInicio;
													$diferencia = round($resultado/86400);
										?>
			                    	<td>
										@if ($diferencia < 5)
											<style>
												.fila{{$pedido->consecutivo}}{
													background:#b0f7f4 ;
												}
											</style>
											@if ($pedido->estado_id == 6)
												<style>
													.fila{{$pedido->consecutivo}}{
														background: #f7e90d;
													}
												</style>
											@endif
											@if ($pedido->estado_id == 7)
												<style>
													.fila{{$pedido->consecutivo}}{
														background:  #6af70d ;
													}
												</style>
											@endif
										<strong style="color: red;">Adicional</strong>
										@else
											<strong style="color: blue;">Semanal</strong>
										@endif
									</td>
			                		<td>
				                    	<strong>
				                    		{{ $pedido->fecha_entrega }}
				                    	</strong>
				                    </td>
				                    <td>
				                    	{{ $pedido->conductor_asignado }}</option>
				                    </td>
				                    <td>
										{{ $pedido->vehiculo_asignado }}
				                    </td>
			                        <td>
			                            <a href="/intranetcercafe/public/admin/excelPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
			                            <a href="/intranetcercafe/public/admin/pdfPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
			                        </td>
								</tr>
							@endif
						@endforeach
					@else
						@foreach($pedidos as $pedido)
							@if($pedido->estado_id != 8 && $pedido->estado_id != 2 && $pedido->estado_id != 9)

								<script type="text/javascript">
									$(document).ready(function ()
									{
										$("#modificar_f_concentrados{{$pedido->consecutivo}}").datepicker(
										{
											changeMonth: true,
											changeYear: true,
											yearRange: "1950:2100",
											dateFormat: "yy-mm-dd",
											showButtonPanel: true,
										});
									})
									function enviarCampos(id, dif)
						            {
						            		var modificar = [];
						            		var consecutivo = id;
						            		var entrega = document.getElementById("modificar_f_concentrados"+id)	.value;
						            		var conductor = document.getElementById("cd"+id).value;
											var vehiculo = document.getElementById("vh"+id).value;

											var fecha_estimada = document.getElementById("fecha_estimada"+id);
											var fecha_creacion = document.getElementById("fecha_creacion"+id);

							            	item = {}
						                	item["cons"] = consecutivo;
						                	item["fecha"] = entrega;
						                	item["cond"] = conductor;
											item["placa"] = vehiculo;
											item["fecha_estimada"] = fecha_estimada.innerHTML;
											item["fecha_creacion"] = fecha_creacion.innerHTML;

											   modificar.push(item);

											if(!localStorage.getItem("usuario")){
												localStorage.setItem("usuario", {{Auth::User()->id}});
											}

											console.log("llego2");

						               		modificar["modificar_concentrados"] = modificar;

												var token = $("#token").val();
												$.ajax({
								       		    type: "POST",
								       		    headers: {'X-CSRF-TOKEN': token},
								       		    url: "http://201.236.212.130:82/intranetcercafe/public/admin/modificarPedidoC",
								       		    dataType: 'json',
								       		    data: {data: JSON.stringify(modificar)}
								       		});
								       		swal({
			                           		    title:'Pedido Modificado Satisfactoriamente.',
			                           		    text:'',
			                           		    type:'success',
			                           		    showCancelButton:false,
			                           		    buttons:true,
			                           		    successMode:true
			                           		})
			                           		.then((willDelete) => {
			                           		  if (willDelete) {
			                           		     location.reload(true);
			                           		  } else {
			                           		    swal("Ha ocurrido un Error!");
			                           		  }
			                           		});
										}

						            //}
								</script>
								<tr id="fila{{$pedido->consecutivo}}" class="fila{{$pedido->consecutivo}}">
									<td>
				                        <a href="#" class="consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido->consecutivo}}</a>
				                    </td>
				                    <td>{{ $pedido->nombre_granja }}</td>
				                    <td id="fecha_creacion{{$pedido->consecutivo}}">{{ $pedido->fecha_creacion }}</td>
									<td id="fecha_estimada{{$pedido->consecutivo}}">{{ $pedido->fecha_estimada }}</td>
									<?php
													//aquí es donde al desarrollador le aparece el contenido
													$fechaFin = strtotime($pedido->fecha_estimada);
													$fechaInicio = strtotime($pedido->fecha_creacion);

													$resultado =$fechaFin - $fechaInicio;

													$diferencia = round($resultado/86400);
									?>
			                    	<td>
										@if ($diferencia < 5)
											<style>
												.fila{{$pedido->consecutivo}}{
													background:#b0f7f4 ;
												}
											</style>
											@if ($pedido->estado_id == 6)
												<style>
													.fila{{$pedido->consecutivo}}{
														background:  #f7e90d ;
													}
												</style>
											@endif
											@if ($pedido->estado_id == 7)
												<style>
													.fila{{$pedido->consecutivo}}{
														background:  #6af70d ;
													}
												</style>
											@endif
											<strong style="color: red;">Adicional</strong>
											@else
												<strong style="color: blue;">Semanal</strong>
											@endif
									</td>
			                    	<td>
				                    	<strong>
				                    		<input id="modificar_f_concentrados{{$pedido->consecutivo}}" class="form-control" type="text" name="fecha" value="{{ $pedido->fecha_entrega }}" readonly />
				                    	</strong>
				                    </td>
				                    <td>
				                    	<select name="conductor" class="form-control" style="width: 100% !important;" id="cd{{$pedido->consecutivo}}" selected="selected" />
				                    		@if($pedido->conductor_asignado == 'por verificar')
					                    		<option value="por verificar">{{ $pedido->conductor_asignado }}</option>
				                                @foreach($conduct as $c)
				                                    <option value="{{$c->id}}">{{$c->nombre}}</option>
				                                @endforeach
				                            @else
				                            	@foreach($conduct as $c)
				                            		@if($pedido->conductor_asignado == $c->nombre)
				                                    	<option value="{{$c->id}}">{{$c->nombre}}</option>
				                                    @endif
				                                @endforeach
				                                @foreach($conduct as $c)
				                                    <option value="{{$c->id}}">{{$c->nombre}}</option>
				                                @endforeach
				                            @endif
				                        </select>
				                    </td>
				                    <td>
				                    	<select name="vehiculo" class="form-control" style="width: 100% !important;" id="vh{{$pedido->consecutivo}}" selected="selected">
			                                @if($pedido->vehiculo_asignado == 'por verificar')
					                    		<option value="por verificar">{{ $pedido->vehiculo_asignado }}</option>
				                                @foreach($vehicul as $v)
			                                    	<option value="{{$v->id}}">{{$v->placa}}</option>
			                                	@endforeach
				                            @else
				                            	@foreach($vehicul as $v)
				                            		@if($pedido->vehiculo_asignado == $v->placa)
				                                    	<option value="{{$v->id}}">{{$v->placa}}</option>
				                                    @endif
				                                @endforeach
				                                @foreach($vehicul as $v)
				                                    <option value="{{$v->id}}">{{$v->placa}}</option>
				                                @endforeach
				                            @endif
				                        </select>
				                    </td>
			                        <td>
										<a  class="btn btn" id="validar" onclick="enviarCampos({{ $pedido->consecutivo }}, {{$diferencia}});"><i class="fa fa-check-square fa-2x"></i></a>
			                        	 <a href="editarpedidoC/{{$pedido->consecutivo}}" class="btn btn"><i class="fa fa-edit fa-2x" style="color: #FDAE05;"></i></a>
		                            </td>
		                        </tr>
							@endif
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
	@if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 9)
		<div class="form-group">
			<button class="btn btn-info" id="verHistorial">Ver Historial</button>
		</div>
	@endif
	<div class="panel panel-default historial">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Pedidos Validados</h4>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list_consecutivos" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;">
					<tr style="color: white;">
						<td><strong>Consecutivo</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha de Creacion</strong></td>
						<td><strong>Tipo Pedido</strong></td>
						<td><strong>Fecha de Entrega</strong></td>
						<td><strong>Conductor</strong></td>
						<td><strong>Vehiculo</strong></td>
						<td><strong>Documentacion</strong></td>
					</tr>
				</thead>
				<tbody>
					@if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 9)
						@foreach($pedidos as $pedido)

							@if($pedido->estado_id  == 2 || $pedido->estado_id  == 9 || $pedido->estado_id  == 8)
		                    	<tr id="fila{{$pedido->consecutivo}}" class="fila{{$pedido->consecutivo}}">
			                    	<td>
				                        <a href="#" class="consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido->consecutivo}}</a>
				                    </td>
				                    <td>{{ $pedido->nombre_granja }}</td>
				                    <td id="fecha_creacion{{$pedido->consecutivo}}">{{ $pedido->fecha_creacion }} </td>
			                			<?php
													$fechaFin = strtotime($pedido->fecha_estimada);
													$fechaInicio = strtotime($pedido->fecha_creacion);
													$resultado =$fechaFin - $fechaInicio;
													$diferencia = round($resultado/86400);
										?>
			                    	<td>
										@if ($diferencia < 5)
											@if ($pedido->estado_id == 9)
													<style>
															.fila{{$pedido->consecutivo}}{
																background:#6af70d ;
															}
													</style>
											@endif
											@if ($pedido->estado_id == 8)
													<style>
															.fila{{$pedido->consecutivo}}{
																background: #ee454f ;
															}
													</style>
											@endif
											<strong style="color: red;">Adicional</strong>
										@else
											<strong style="color: blue;">Semanal</strong>
										@endif
									</td>
			                		<td>
				                    	<strong>
				                    		{{ $pedido->fecha_entrega }}
				                    	</strong>
				                    </td>
				                    <td>
				                    	{{ $pedido->conductor_asignado }}
				                    </td>
				                    <td>
										{{ $pedido->vehiculo_asignado }}
				                    </td>
			                        <td>
			                            <a href="/intranetcercafe/public/admin/excelPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
			                            <a href="/intranetcercafe/public/admin/pdfPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
			                        </td>
		                       	</tr>
							@endif
						@endforeach
					@else
						@foreach($g_as as $g)
							@if($g->user_id == Auth::User()->id)
								@foreach($pedidos as $pedido)
									@if($pedido->estado_id == 2 || $pedido->estado_id == 9 || $pedido->estado_id == 8)
										@if($g->granja_id == $pedido->granja_id)
					                    	<tr id="fila{{$pedido->consecutivo}}" class="fila{{$pedido->consecutivo}}">
						                    	<td>
							                        <a href="#" class="consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido->consecutivo}}</a>
							                    </td>
							                    <td>{{ $pedido->nombre_granja }}</td>
							                    <td id="fecha_creacion{{$pedido->consecutivo}}">{{ $pedido->fecha_creacion}} </td>
						                		<?php
													$fechaFin = strtotime($pedido->fecha_estimada);
													$fechaInicio = strtotime($pedido->fecha_creacion);
													$resultado =$fechaFin - $fechaInicio;
													$diferencia = round($resultado/86400);
												?>
			                    				<td>
													@if ($diferencia < 5)
														@if ($pedido->estado_id == 9)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background:#6af70d ;
																}
															</style>
														@endif
														@if ($pedido->estado_id == 8)
															<style>
																.fila{{$pedido->consecutivo}}{
																	background: #ee454f ;
																}
															</style>
														@endif
														<strong style="color: red;">Adicional</strong>
													@else
														<strong style="color: blue;">Semanal</strong>
													@endif
												</td>
						                		<td>
							                    	<strong>
							                    		{{ $pedido->fecha_entrega }}
							                    	</strong>
							                    </td>
							                    <td>
							                    	{{ $pedido->conductor_asignado }}
							                    </td>
							                    <td>
													{{ $pedido->vehiculo_asignado }}
							                    </td>
						                        <td>
						                            <a href="/intranetcercafe/public/admin/excelPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
						                            <a href="/intranetcercafe/public/admin/pdfPedidoConcentrados/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
						                        </td>
					                       	</tr>
										@endif
									@endif
								@endforeach
							@endif
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>

	<div class="modal fade" id="myModal" role="dialog" onclick="borrarInputConsecutivo()">
		<div class="modal-dialog modal-lg">
		  	<div class="modal-content">
			    <div class="modal-header" id="titulo">
			    	<h3 style="font-size: 25px;" class="texto"></h3>
			    </div>
			    <div class="modal-body">
			    	<div class="table-responsive">
				    	<table class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
							<thead>
								<tr style="color: white;">
									<td><strong>Nombre de la Granja</strong></td>
									<td><strong>Nombre del Concentrado</strong></td>
									<td><strong># Bultos</strong></td>
									<td><strong># Kilos</strong></td>
								</tr>
							</thead>
							<tbody id="producs">

							</tbody>
						</table>
			    	</div>
			    </div>
			    <div class="modal-footer">
					<div style="display: flex;">
						<input type="hidden" id="consecutivoConcentrado">
						<button type="button" class="btn btn-success" data-dismiss="modal" style="display:none" id="aceptarPedidoAdicional" onclick="DecisionAdicional(1)">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal" style="display:none" id="rechazarPedidoAdicional" onclick="DecisionAdicional(2)">Rechazar</button>
					</div>
					<button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarModal" style="float: right;">Cerrar</button>
			    </div>
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	pedido = [];
	@foreach($pedidos as $pedido)
		var estado = {{$pedido->estado_id}};
		var consecutivo = {{$pedido->consecutivo}};
		item = {}
        item["estado"] = estado;
        item["consecutivo"] = consecutivo;
        pedido.push(item);
	@endforeach
	pedido["pedido_concentrados"] = pedido;
</script>
<script>
	$(document).ready(function () {
		$("#tabla_consecutivos").DataTable({
			paging: false,
			ordering: true
		});
		// $("[name='conductor']").select2();
		// $("[name='vehiculo']").select2();
		$(".historial").hide();
		$("#verHistorial").click(function () {
			$(".historial").show();
			var table = $("#data_list_consecutivos").DataTable({
				ordering: true
			});
		});
		$(".consecutivo").click(function () {
			$('#tabla_consecutivos').DataTable( {
			    destroy: true,
			    paging: true
			} );
			$("#producs").html('');
			$(".texto").html('');
			var token = $("[name='_token']").val();
			var consecutivo = $(this).attr('data-id');
			console.log(consecutivo);
			var pedido = [];
			item = {};

			item["consecutivo"] = consecutivo;
			pedido.push(item);
			$.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': token},
                url: "http://201.236.212.130:82/intranetcercafe/public/admin/pedidoConcentradosVista",
                dataType: 'json',
                data: {data: JSON.stringify(pedido)},
			}).done(function (msg) {
				var Productos = msg.data;
				console.log(Productos);
				var consecutivo = msg.consecutivo;
				console.log(consecutivo);
				var Dif_fecha = msg.diferenciaFechas;
				console.log(Dif_fecha);

				var titulo = '';
				titulo += "<i class='fa fa-list-alt'></i><strong> PCO"+consecutivo.consecutivo+"</strong>";
				$(".texto").append(titulo);

				//alert(Productos.length);
				for(let index = 0; index<Productos.length; index++){
					dataElements = Productos[index];
							var html = '';
							html += '<tr>';
								html += '<td>'+dataElements.nombre_granja+'</td>';
								html += '<td>'+dataElements.nombre_concentrado+'</td>';
								html += '<td>'+dataElements.no_bultos+'</td>';
								html += '<td>'+dataElements.no_kilos+'</td>';
							html += '</tr>';
							$("#producs").append(html);
				}

						var aceptarAdicional = document.getElementById('aceptarPedidoAdicional');
						var rechazarAdicional = document.getElementById('rechazarPedidoAdicional');
						var cerrarModal =  document.getElementById('cerrarModal');

					if(Dif_fecha[0].dif_dias < 5 && Dif_fecha[0].estado_id != 8 && Dif_fecha[0].estado_id != 9){
						if(localStorage.getItem("usuario") == 3 || localStorage.getItem("usuario") == 51 || localStorage.getItem("usuario") == 32 || localStorage.getItem("usuario") == 18 || localStorage.getItem("usuario") == 107){
							var inputConsecutivo = document.getElementById('consecutivoConcentrado');
							inputConsecutivo.value = consecutivo.consecutivo;
							aceptarAdicional.style.display = "block";
							rechazarAdicional.style.display = "block";
						}
					}else{
							borrarInputConsecutivo();
							aceptarAdicional.style.display = "none";
							rechazarAdicional.style.display = "none";
					}

				//Esta es su posición: alert(Dif_fecha[0].dif_dias);
			})
		})
	})
</script>
@endsection




