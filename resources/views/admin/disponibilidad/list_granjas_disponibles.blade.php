@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Lista de Granjas Disponibles</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4><i class="fa fa-list" aria-hidden="true"></i> Lista de Granjas Disponibles</h4>
		</div>
		<br>
		<div class="form-group container-fluid">
			{!!Form::open(['route'=>'admin.FilterGranjasDisponibles.store','class'=>'form-inline','method'=>'POST']) !!}
				<h1>Filtrar Informacion</h1>
				<div class="form-group">
					<select name="granja" id="" class="form-control">
						<option></option>
						@foreach($granjas as $granja)
							<option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					{!!Form::text('desde',null,['class'=>'form-control','readonly','style'=>'cursor:pointer;','placeholder'=>'Desde'])!!}
				</div>
				<div class="form-group">
					{!!Form::text('hasta',null,['class'=>'form-control','readonly','style'=>'cursor:pointer;','placeholder'=>'Hasta'])!!}
				</div>
				<div class="form-group">
					{!!Form::submit('Filtrar',array('class'=>'btn btn-success clear_dates'))!!}
				</div>
			{!!Form::close()!!}
			<div class="form-group pull-right">
				<a href="ExcelGranjasDisponibles" class="btn btn-success"><i>{!!Html::image('http://201.236.212.130:82/intranetcercafe/public/c.png','us',array('class' => 'imuser'))!!} </i> Exportar</a>
				<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
			</div>
		</div>
		<div class="panel-body table-responsive">
			<table id="table_granjas" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead>
					<tr style="color: white">
						<th>Nombre de la Granja</th>
						<th>Fecha de Creacion</th>
						<th>Semana</th>
						<th>Numero de Cerdos Disponibles</th>
						<th>Peso Promedio</th>
					</tr>
				</thead>
				<tbody>
					@foreach($granjas_disponibles as $granja)
						<tr>
							<td>{{$granja->nombre_granja}} </td>
							<td>{{$granja->fecha_creada}} </td>
							<td>{{$granja->semana}} </td>
							<td>{{$granja->cerdos_disponibles}} </td>
							<td>{{$granja->peso_promedio}} </td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$("#table_granjas").DataTable({
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
			$("[name='granja']").select2({
				placeholder:'Granja',
				allowClear:true
			});
			var dates = $("[name='desde'], [name='hasta']").datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "1950:2100",
				dateFormat: "yy-mm-dd",
				showButtonPanel: true,
			})
		})
	</script>
@endsection