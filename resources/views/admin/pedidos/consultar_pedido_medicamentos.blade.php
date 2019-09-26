@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Pedidos | Cercafe</title>
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
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Nuevos Pedidos</h4>
		</div>
		<br>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		@if(Auth::User()->rol_id == 8 || Auth::user()->rol_id == 7)
			<div class="container-fluid col-xs-6 col-lg-12">
				{!!Form::open(['route'=> 'admin.filterPedidos.store', 'class'=>'form-inline', 'method'=>'POST'])!!} 
					<div class="form-group">
						<label>Desde:</label>
						{!!Form::text('fecha_de',null, ['id' => 'date_picker_desde', 'class'=>'form-control', 'readonly', 'required', 'style' => 'cursor: pointer !important;'])!!}
					</div>
					<div class="form-group">
						<label>Hasta:</label>
						{!!Form::text('fecha_hasta',null, ['id' => 'date_picker_hasta', 'class'=>'form-control', 'readonly', 'required', 'style' => 'cursor: pointer !important;'])!!}
					</div>
					<div class="form-group">
						{!! Form::select('granja', $granjas, array('0' => 'Seleccione una granja'), ['placeholder' => 'Selecciona una granja', 'class' => 'form-control col-xs-8' ]) !!}
					</div>
					<div class="form-group">
						<select name="tipo" id="tipo" class="form-control col-xs-8">
	                        <option value=" ">Formato de Busqueda</option>
	                        <option value="pd">Pedidos</option>
	                        <option value="pr">Productos</option>
	                    </select>
					</div>
					<div class="form-group">
						{!!Form::submit('Buscar', array('class'=>'btn btn-success'))!!}
					</div>
				{!! Form::close() !!}
			</div>
		@endif
		@if(Auth::User()->rol_id == 8 || Auth::user()->rol_id == 7)
			<div class="panel-body table-responsive">
				<table id="data_list_med" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
					<thead style="background-color: #df0101;"> 
						<tr style="color: white;">
							<td><strong>Consecutivo</strong></td>
							<td><strong>Granja</strong></td>
							<td><strong>Fecha</strong></td>
							<td><strong>Estado</strong></td>
							<td><strong>Tipo de Pedido</strong></td>
							<td><strong>Documentacion</strong></td>
						</tr>
					</thead> 
					<tbody>
						@foreach($pedidos as $pedido)
							@if($pedido->origen == 1)
								@if(Auth::user()->id == 68 || Auth::user()->id == 23 || Auth::user()->rol_id == 7)
									@if($pedido->estado_id == 1)
						                <tr>
						                    <td>
						                        <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PME{{$pedido->consecutivo}}</button>
						                    </td>
						                    <td>{{ $pedido->nombre_granja }}</td>
						                    <td>{{ $pedido->fecha_creacion }}</td>
					                    	<td><strong style="color: #DF0101;"> Pendiente </strong></td>
					                    	@if($pedido->tipo_pedido == 1)
					                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
					                    	@else
												<td style="color: #045FB4"><strong>Adicional</strong></td>
					                    	@endif
					                    	<td>
				                                <a href="{{ route('admin.pedidoMedicamentos.edit', $pedido->consecutivo) }}" class="btn btn" ><i class="fa fa-check-square fa-3x"></i></a> 
				                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
							                    <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
			                            	</td>
				                        </tr>
				                    @elseif($pedido->estado_id == 4)
										<tr>
						                    <td>
						                        <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PME{{$pedido->consecutivo}}</button>
						                    </td>
						                    <td>{{ $pedido->nombre_granja }}</td>
						                    <td>{{ $pedido->fecha_creacion }}</td>
					                    	<td><strong style="color: #2E64FE;">Recibido </strong></td>
					                    	@if($pedido->tipo_pedido == 1)
					                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
					                    	@else
												<td style="color: #045FB4"><strong>Adicional</strong></td>
					                    	@endif
					                    	<td>
				                                <a href="{{ route('admin.pedidoMedicamentos.edit', $pedido->consecutivo) }}" class="btn btn-success"><i class="fa fa-check"></i> Tramitar</a> 
				                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
							                    <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
			                            	</td> 
				                        </tr>
				                    @endif
				                @endif
			                @else
			                	@if(Auth::user()->id == 81 || Auth::user()->id == 68 || Auth::user()->id == 23 || Auth::user()->rol_id == 8)
				                	@if($pedido->estado_id == 1)
						                <tr>
						                    <td>  
						                        <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PME{{$pedido->consecutivo}}</button>
						                    </td>
						                    <td>{{ $pedido->nombre_granja }}</td>
						                    <td>{{ $pedido->fecha_creacion }}</td>
					                    	<td><strong style="color: #DF0101;"> Pendiente </strong></td>
					                    	@if($pedido->tipo_pedido == 1)
					                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
					                    	@else
												<td style="color: #045FB4"><strong>Adicional</strong></td>
					                    	@endif
					                    	<td> 
				                                <a href="{{ route('admin.pedidoMedicamentos.edit', $pedido->consecutivo) }}" class="btn btn-primary"><i class="fa fa-check"></i> Validar</a> 
				                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
							                    <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
			                            	</td>   
				                        </tr>
				                    @elseif($pedido->estado_id == 4)
										<tr>
						                    <td> 
						                        <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PME{{$pedido->consecutivo}}</button>
						                    </td>
						                    <td>{{ $pedido->nombre_granja }}</td>
						                    <td>{{ $pedido->fecha_creacion }}</td>
					                    	<td><strong style="color: #2E64FE;"> Recibido </strong></td>
					                    	@if($pedido->tipo_pedido == 1)
					                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
					                    	@else
												<td style="color: #045FB4"><strong>Adicional</strong></td>
					                    	@endif
					                    	<td>  
				                                <a href="{{ route('admin.pedidoMedicamentos.edit', $pedido->consecutivo) }}" class="btn btn-success"><i class="fa fa-check"></i> Tramitar</a> 
				                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
							                    <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
			                            	</td>
				                        </tr>
				                    @endif
				                @endif
				            @endif 
	                    @endforeach
					</tbody>
				</table>			
			</div>
		@else 
			<div class="panel-body table-responsive">
				<table id="data_list_medicamentos" class="table table-bordered table-hover text-center" cellspacing="0" width="100%"> 
					<thead style="background-color: #df0101;"> 
						<tr style="color: white;">
							<td><strong>Consecutivo</strong></td>
							<td><strong>Granja</strong></td>
							<td><strong>Fecha</strong></td>
							<td><strong>Estado</strong></td>
							<td><strong>Tipo de Pedido</strong></td>
							<td><strong>Documentacion</strong></td>
						</tr>
					</thead>
					<tbody>
						@foreach($g_as as $g)
							@if($g->user_id == Auth::User()->id)
								@foreach($pedidos as $pedido)
									@if($g->granja_id == $pedido->granja_id)
						                <tr>
						                    <td> 
						                        <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PME{{$pedido->consecutivo}}</button>
						                    </td>
						                    <td>{{ $pedido->nombre_granja }}</td>
						                    <td>{{ $pedido->fecha_creacion }}</td>
						                    @if($pedido->estado_id == 2)
					                    		<td><strong style="color: #8BC34A;"> Tramitado </strong></td>
					                    		@if($pedido->tipo_pedido == 1)
						                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
						                    	@else
													<td style="color: #045FB4"><strong>Adicional</strong></td>
						                    	@endif
					                    		<td>
					                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
					                                <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
				                            	</td>
					                    	@elseif($pedido->estado_id == 4)
					                    		<td><strong style="color: #2E64FE;"> Recibido </strong></td>
					                    		@if($pedido->tipo_pedido == 1)
						                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
						                    	@else
													<td style="color: #045FB4"><strong>Adicional</strong></td>
						                    	@endif
					                    		<td>
					                    			<script type="text/javascript">                         	
														var f = new Date();
														if (f.getDate() >= '22' && f.getDate() <= '28') 
														{
															document.write('<a href="editarpedidoM/{{$pedido->consecutivo}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>');
														}
					                                </script>
					                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
					                                <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
			                            		</td>
					                    	@elseif($pedido->estado_id == 1)
					                    		<td><strong style="color: #DF0101;"> Pendiente </strong></td>
					                    		@if($pedido->tipo_pedido == 1)
						                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
						                    	@else
													<td style="color: #045FB4"><strong>Adicional</strong></td>
						                    	@endif
					                    		<td>
					                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
					                                <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
					                                <script type="text/javascript">                         	
														var f = new Date();
														if (f.getDate() >= '22' && f.getDate() <= '28')
														{
															document.write('<a href="editarpedidoM/{{$pedido->consecutivo}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>');
														}
					                                </script>
			                            		</td>
					                    	@endif
				                        </tr>
				                    @endif
			                    @endforeach
			                @endif
			            @endforeach
					</tbody>
				</table>			
			</div>
		@endif
	</div>
	@if(Auth::User()->rol_id == 8 || Auth::user()->rol_id == 7)
		<div class="form-group">
			<button class="btn btn-info" id="verHistorial">Ver Historial</button>
		</div>
	@endif
	<div class="panel panel-default historial">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Historicos</h4>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list_estados" class="table table-bordered table-hover text-center" cellspacing="0" width="100%"> 
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Consecutivo</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha</strong></td>
						<td><strong>Estado</strong></td>
						<td><strong>Tipo de Pedido</strong></td>
						<td><strong>Documentacion</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($pedidos as $pedido)
						@if($pedido->estado_id == 2) 
			                <tr>
			                    <td>
			                        <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PME{{$pedido->consecutivo}}</button>
			                    </td>
			                    <td>{{ $pedido->nombre_granja }}</td>
			                    <td>{{ $pedido->fecha_creacion }}</td>
		                    	<td><strong style="color: #8BC34A;"> Tramitado </strong></td>
		                    	@if($pedido->tipo_pedido == 1)
		                    		<td style="color: #FF8000"><strong>Mensual</strong></td>
		                    	@else
									<td style="color: #045FB4"><strong>Adicional</strong></td>
		                    	@endif
		                    	<td> 
	                                <a href="/intranetcercafe/public/admin/excelPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
	                                <a href="/intranetcercafe/public/admin/pdfPedidoMedicamentos/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
                            	</td>
	                        </tr>
                        @endif 
                    @endforeach
				</tbody>
			</table>			
		</div>
	</div>
	<div class="modal fade" id="myModal" role="dialog">
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
									<td><strong>Nombre del Medicamento</strong></td>
									<td><strong>Cantidad</strong></td>
								</tr>
							</thead>
							<tbody id="producs">
								
							</tbody>
						</table>
			    	</div>
			    </div>
			    <div class="modal-footer">
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    </div>
		  	</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$(".historial").hide();
		$("#data_list_med").DataTable({
			paging:false,
		});
		$("#verHistorial").click(function () {
			$(".historial").show();
			$("#data_list_estados").DataTable();
		})
		$(".consecutivo").click(function () {
			$("#data_list_med,#data_list_medicamentos").DataTable({
				destroy: true,
				paging:true
			});
			$("#producs").html('');
			$(".texto").html('');
			var token = $("[name='_token']").val();
			var consecutivo = $(this).attr('data-id')
			var pedido = [];
			item = {};

			item["consecutivo"] = consecutivo;
			pedido.push(item);
			$.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': token},
                url: "http://201.236.212.130:82/intranetcercafe/public/admin/pedidoMedicamentosVista",
                dataType: 'json',
                data: {data: JSON.stringify(pedido)},
			}).done(function (msg) {
				var Productos = msg.data;
				var consecutivo = msg.consecutivo;
				
				var html = '';
				html += "<i class='fa fa-list-alt'></i><strong> PME"+consecutivo+"</strong>";
				$(".texto").append(html);

				$.each(Productos,function (key,value) {
					var html = '';
					html += '<tr>';
						html += '<td>'+value.granja+'</td>';
						html += '<td>'+value.medicamento+'</td>';
						html += '<td>'+value.unidades+'</td>';
					html += '</tr>';
					$("#producs").append(html);
				})
			})
		})
	})
</script>
@endsection
