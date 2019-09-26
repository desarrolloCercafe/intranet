@extends('template.plantilla')
@section('content')
	<title>Filtro Mortalidad P.C| Cercafe</title>
	@include('flash::message')	
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Reportes de Mortalidad</h4>
		</div>
		<br>
		<div class="container-fluid col-xs-6 col-lg-12">
			<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar</a>
			<span><a href="/intranetcercafe/public/admin/excelFiltradoMortalidad/{{$granja_filtro}}/{{$lote_filtro}}/{{$fecha_inicial}}/{{$fecha_final}} " class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} Exportar</i></a></span>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101"> 
					<tr style="color: white;">
						<td><strong>Acción</strong></td>
						<td><strong>Lote</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha</strong></td>
						<td><strong>Sexo del Porcino</strong></td>
						<td><strong>Posible Causa</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($reportes_db as $reporte_db)
						<tr>
							<td>
								<a href="{{ route('admin.reporteMortalidad.destroy', $reporte_db["id_mortalidad"]) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Lote"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								
								<a href="{{ route('admin.filterMortalidadPreceboCeba.show', $reporte_db["id_mortalidad"])}}" class="btn btn-default boton_ojo" data-toggle="tooltip" data-placement="top" title="Ver Información Adicional"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
							</td>
							<td>{{$reporte_db["lote"]}}</td>
							<td>{{$reporte_db["granja"]}}</td>
							<td>{{$reporte_db["fecha"]}}</td>
							<td>{{$reporte_db["sexo"]}}</td> 
							<td>{{$reporte_db["causa"]}}</td>
						</tr>
					@endforeach	
				</tbody>
			</table>			
		</div>
	</div>
@endsection