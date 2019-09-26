@extends('template.plantilla')
@section('content')
	@include('flash::message')	
	<title>Filtro Destetos S| Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Reportes Destetos por Semana</h4>
		</div>
		<br>
		<div class="container-fluid col-xs-6 col-lg-12">
			<a href="javascript:history.go(-1);" class="btn btn-info" style="margin-bottom: 1em;"><i class="fa fa-arrow-left"></i> Regresar</a>
			<span><a href="/intranetcercafe/public/admin/excelFiltradoDestetosSemana/{{$granja_filtro}}/{{$lote_filtro}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} Exportar</i></a></span>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color:#df0101"> 
					<tr style="color: white;">
						<td><strong>Acción</strong></td>
						<td><strong>Lote</strong></td>
						<td><strong>Granja donde se Crio</strong></td>
						<td><strong>Semana de Destete</strong></td>
						<td><strong>Semana Venta</strong></td>
						<td><strong>Año de Venta</strong></td>
						<td><strong>Numero de Destetos</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($destetosS_db as $destetoS_db)
						<tr>
							<td>
								<a href="{{ route('admin.destetosSemana.destroy', $destetoS_db["id"]) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Lote"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								
								<a href="{{ route('admin.filterDestetoSemana.show', $destetoS_db["id"])}}" class="btn btn-default boton_ojo" data-toggle="tooltip" data-placement="top" title="Ver Información Adicional"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
							</td>
							<td>{{$destetoS_db["lote"]}}</td>
							<td>{{$destetoS_db["granja"]}}</td>
							<td>{{$destetoS_db["semana_destete"]}}</td>
							<td>{{$destetoS_db["semana_venta"]}}</td>
							<td>{{$destetoS_db["año_venta"]}}</td>
							<td>{{$destetoS_db["destetos"]}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
@endsection