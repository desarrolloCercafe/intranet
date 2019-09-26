@extends('template.plantilla')
@section('content')
	@include('flash::message')	
	<title>Filtro Ceba | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Reportes de Ceba</h4>
		</div> 
		<br>
		<div class="container-fluid col-xs-6 col-lg-12">
			<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar</a>
			<span><a href="/intranetcercafe/public/admin/excelFiltradoCeba/{{$granja_filtro}}/{{$lote_filtro}}/{{$fecha_inicial}}/{{$fecha_final}} " class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} Exportar</i></a></span>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #DF0101"> 
					<tr style="color: white;">
						<td><strong>Acción</strong></td>
						<td><strong>Lote</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha Inicial</strong></td>
						<td><strong>Fecha Final</strong></td>
						<td><strong>Numero Inicial</strong></td>
						<td><strong>Consumo Total</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($cebas_db as $ceba_db)
						<tr> 
							<td>
								<a href="{{ route('admin.cebas.destroy', $ceba_db["id_ceba"]) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar lote"><i class="fa fa-trash-o" aria-hidden="true"></i></a>

								<a href="{{ route('admin.filterCeba.show', $ceba_db["id_ceba"])}}" class="btn btn-default boton_ojo" data-toggle="tooltip" data-placement="top" title="Ver Información Adicional"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
							</td>
							<td>{{$ceba_db["lote"]}}</td>
							<td>{{$ceba_db["granja"]}}</td>
							<td>{{$ceba_db["fecha_inicial"]}}</td>
							<td>{{$ceba_db["fecha_final"]}}</td>
							<td>{{$ceba_db["inic"]}}</td>
							<td>{{$ceba_db["consumo_total"]}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
@endsection