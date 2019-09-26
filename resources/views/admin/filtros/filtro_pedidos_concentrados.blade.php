@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Filtro Concentrados | Cercafe</title>
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
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Pedidos Filtrados</h4>
		</div>
		<br>
		<div class="container-fluid col-xs-6 col-lg-12">
			 <div class="form-group">
			 	<a href="javascript:history.go(-1);" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Regresar</a>
                <a href="/intranetcercafe/public/admin/excelFiltradoPorPedidoConcentrado/{{$f_ini}}/{{$f_fin}}/{{$grj}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} Exportar</i></a>
			 </div>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101;"> 
					<tr style="color: white;">
						<td><strong>Consecutivo</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha de Creación</strong></td>
						<td><strong>Fecha de Entrega</strong></td>
						<td><strong>Documentacion</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($pedidos_db as $pedido_db)
		                <tr>
		                    <td>
		                        {{-- <a href="#"> 
		                            <strong>PCO{{ $pedido_db["consecutivo"] }}</strong>
		                        </a> --}}
		                        <button class="btn btn-link consecutivo" data-id="{{$pedido_db["consecutivo"]}}" data-toggle="modal" data-target="#myModal">PCO{{$pedido_db["consecutivo"]}}</button>
		                    </td>
		                    <td>{{ $pedido_db["granja"] }}</td>
		                    <td>{{ $pedido_db["fecha_creacion"] }}</td>
		                    <td>{{ $pedido_db["fecha_entrega"] }}</td>
		                    <td> 
                                <a href="/intranetcercafe/public/admin/excelPedidoConcentrados/{{$pedido_db["consecutivo"]}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i></a>
                                <a href="/intranetcercafe/public/admin/pdfPedidoConcentrados/{{$pedido_db["consecutivo"]}}" class="btn btn-danger"><i>{!!Html::image('pdf.png','us',array('class' => 'imuser'))!!} </i></a>
                            </td>
                        </tr>
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
		    	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		    </div>
		  </div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
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
                url: "http://201.236.212.130:82/intranetcercafe/public/admin/pedidoConcentradosVista",
                dataType: 'json',
                data: {data: JSON.stringify(pedido)},
			}).done(function (msg) {
				var Productos = msg.data;
				// console.log(Productos);
				var consecutivo = msg.consecutivo;
				console.log(consecutivo);
				
				var html = '';
				html += "<i class='fa fa-list-alt'></i><strong> PCO"+consecutivo+"</strong>";
				$(".texto").append(html);

				$.each(Productos,function (key,value) {
					var html = '';
					html += '<tr>';
						html += '<td>'+value.granja+'</td>';
						html += '<td>'+value.concentrado+'</td>';
						html += '<td>'+value.bultos+'</td>';
						html += '<td>'+value.kilos+'</td>';
					html += '</tr>';
					$("#producs").append(html);
				})
			})
		})
	})
</script>
@endsection
