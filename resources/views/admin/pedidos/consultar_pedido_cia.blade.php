@extends('template.plantilla')
@section('content')
	{{-- @include('flash::message') --}}
	<title>Pedidos de Semen | Cercafe</title>
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
		<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Listado Pedidos de Semen</h4>
		</div>
		<br>
		<div class="container-fluid col-xs-6 col-lg-12"> 
			 {!!Form::open(['route'=> 'admin.filterCiaPedidos.store', 'class'=>'form-inline', 'method'=>'POST'])!!}
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
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Consecutivo</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha Creación</strong></td>
						<td><strong>Fecha Estimada</strong></td>
						<td><strong>Fecha Entrega</strong></td>
						<td><strong>Estado</strong></td>
						<td><strong>Documentacion</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($pedidos as $pedido)
						@if($pedido->estado_id == 1)
							<script type="text/javascript">
								$(document).ready(function () 
								{
									$("#modificar_f_semen{{$pedido->consecutivo}}").datepicker(
									{ 
										changeMonth: true,
										changeYear: true,
										yearRange: "1950:2100",
										dateFormat: "yy-mm-dd", 
										showButtonPanel: true,
									});
								})

								function enviarCampos(id)
					            {  
					            	modificar = []; 
					            	var consecutivo = id;
					            	var entrega = document.getElementById("modificar_f_semen"+id).value;

						            item = {} 
					                item["cons"] = consecutivo;
					                item["fecha"] = entrega;
					                
					                modificar.push(item); 
					 
					                modificar["modificar_semen"] = modificar;

									var token = $("#token").val(); 
									$.ajax({
							            type: "POST",
							            headers: {'X-CSRF-TOKEN': token},
							            url: "http://201.236.212.130:82/intranetcercafe/public/admin/modificarPedidoS", 
							            dataType: 'json',
							            data: {data: JSON.stringify(modificar)}
							        });
							        swal({
					                    title:'Pedido Modificado Satisfactoriamente.',
					                    text:'',
					                    type:'info',
					                    showCancelButton:false,
					                    confirmButtonClass:'btn-primary',
					                    confirmButtonText:'Recargar'
					                },
					                function(isConfirm)
					                {
					                   	location.reload();
					                });      
					            }
							</script>
			                <tr>
			                    <td>
			                        <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PSE{{$pedido->consecutivo}}</button>
			                    </td>
			                    <td>{{ $pedido->nombre_granja }}</td>
			                    <td>{{ $pedido->fecha_creacion }}</td>
			                    <td>{{ $pedido->fecha_estimada }}</td>
			                    <td>
			                    	<strong>
			                    		<input class="form-control" type="text" id="modificar_f_semen{{$pedido->consecutivo}}" value="{{ $pedido->fecha_entrega }}" readonly="true" placeholder="Seleccione..." />
			                    	</strong>
			                    </td>
		                    	<td><strong style="color: #FDAE05;"> En Tramite </strong></td>
		                    	<td>
	                                <a href="#" class="btn btn-info" onclick="enviarCampos({{ $pedido->consecutivo }});"><i class="fa fa-calculator"></i> Facturar</a>
                            	</td>    
	                        </tr>
	                    @endif 
                    @endforeach
				</tbody>
			</table>			
		</div>
	</div>
	<div class="form-group">
		<button class="btn btn-info" id="HistorialCia">Historial</button>
	</div>
	<div class="panel panel-default historial_cia">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Historial</h4>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_cia" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Consecutivo</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha Creación</strong></td>
						<td><strong>Fecha Estimada</strong></td>
						<td><strong>Fecha Entrega</strong></td>
						<td><strong>Estado</strong></td>
						<td><strong>Documentacion</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($pedidos as $pedido)
						@if($pedido->estado_id == 2)
							<tr>
								<td>
				                    <button class="btn btn-link consecutivo" data-id="{{$pedido->consecutivo}}" data-toggle="modal" data-target="#myModal">PSE{{$pedido->consecutivo}}</button>
				                </td>
								<td>{{ $pedido->nombre_granja }}</td>
			                    <td>{{ $pedido->fecha_creacion }}</td>
			                    <td>{{ $pedido->fecha_estimada }}</td>
		                    	<td><strong>{{ $pedido->fecha_entrega }}</strong></td>
		                    	<td><strong style="color: #8BC34A;"> Tramitado </strong></td>
		                    	<td>
	                                <a href="/intranetcercafe/public/admin/excelPedidoCia/{{$pedido->consecutivo}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!}</i></a>
	                                <a href="/intranetcercafe/public/admin/pdfPedidoCia/{{$pedido->consecutivo}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
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
								<td><strong>Nombre del Producto</strong></td>
								<td><strong>Cantidad (Botellas)</strong></td>
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
		$(".historial_cia").hide();
			
		$("#HistorialCia").click(function () {
			$(".historial_cia").show();
			$("#data_cia").DataTable();
		});
		$(".consecutivo").click(function () {
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
                url: "http://201.236.212.130:82/intranetcercafe/public/admin/pedidoCiaVista",
                dataType: 'json',
                data: {data: JSON.stringify(pedido)},
			}).done(function (msg) {
				var Productos = msg.data;
				console.log(Productos);
				var consecutivo = msg.consecutivo;
				console.log(consecutivo);
				
				var html = '';
				html += "<i class='fa fa-list-alt'></i><strong> PSE"+consecutivo+"</strong>";
				$(".texto").append(html);

				$.each(Productos,function (key,value) {
					var html = '';
					html += '<tr>';
						html += '<td>'+value.granja+'</td>';
						html += '<td>'+value.producto_cia+'</td>';
						html += '<td>'+value.dosis+'</td>';
					html += '</tr>';
					$("#producs").append(html);
				})
			})
		})
	})
</script>
@endsection
