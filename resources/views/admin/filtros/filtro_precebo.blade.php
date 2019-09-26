@extends('template.plantilla')
@section('content')
	@include('flash::message')	
	<title>Filtro Precebo | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Reportes de Precebo</h4>
		</div>
		<br>
		<div class="container-fluid col-xs-6 col-lg-12">
			<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar</a>
			<span><a href="/intranetcercafe/public/admin/excelFiltradoPrecebo/{{$granja_filtro}}/{{$lote_filtro}}/{{$fecha_inicial}}/{{$fecha_final}} " class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} Exportar</i></a></span>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
						<td><strong>Acción</strong></td>
						<td><strong>Lote</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha de Destete</strong></td>
						<td><strong>Fecha de Traslado</strong></td>
						<td><strong>Numero Inicial</strong></td>
						<td><strong>Numero Final</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($precebos_db as $precebo_db)
						<tr>
							<td>
								<a href="{{ route('admin.precebos.destroy', $precebo_db["id_precebo"]) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Lote"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								
								<a href="{{ route('admin.filterPrecebo.show', $precebo_db["id_precebo"])}}" class="btn btn-default boton_ojo" data-toggle="tooltip" data-placement="top" title="Ver Información Adicional"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
							</td>
							<td>{{$precebo_db["lote"]}} </td>
							<td>{{$precebo_db["granja"]}}</td>
							<td>{{$precebo_db["fecha_destete"]}}</td>
							<td>{{$precebo_db["fecha_traslado"]}}</td>
							<td>{{$precebo_db["numero_inicial"]}}</td>
							<td>{{$precebo_db["numero_final"]}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
@endsection