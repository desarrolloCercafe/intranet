@extends('template.plantilla')
@section('content')
	<title>Filtro Granjas Disponibles</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h3><i class="fa fa-filter"></i>Filtro de Granjas Disponibles</h3>
		</div>
		<br>
		<div class="container-fluid col-lg-12 col-md-12 col-xs-12">
			<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar</a>
			<a href="excelFilterGranjasDisponibles/{{$granja_filtro}}/{{$fecha_inicial}}/{{$fecha_final}} " class="btn btn-success"><i>{!!Html::image('http://201.236.212.130:82/intranetcercafe/public/c.png','us',array('class' => 'imuser'))!!} </i> Exportar</a>
		</div>
		<div class="panel-body table-responsive">
			<table class="table table-bordered table-hover text-center" cellspacing="0" width="100%" id="table_filter">
				<thead>
					<tr style="color: white;">
						<td>Nombre de la Granja</td>
						<td>Fecha de Creacion</td>
						<td>Semana</td>
						<td>Cerdos Disponibles</td>
						<td>Peso Promedio</td>
					</tr>
				</thead>
				<tbody>
					@foreach($granjas_d as $granja_d)
						<tr>
							<td>{{$granja_d['granja']}} </td>
							<td>{{$granja_d['fecha_creada']}} </td>
							<td>{{$granja_d['semana']}} </td>
							<td>{{$granja_d['cerdos_disponibles']}} </td>
							<td>{{$granja_d['peso_promedio']}} </td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$("#table_filter").DataTable({
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