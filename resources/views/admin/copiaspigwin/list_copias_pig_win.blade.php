@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>BackUps PigWin | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-database" aria-hidden="true"></i> Copias de Seguridad 'PigWin'</h4>
		</div>
		<br>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
						<td><strong>Archivo</strong></td>
						<td><strong>Fecha</strong></td>
						<td><strong>Usuario</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Opciones</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($copias as $copia)
						<tr>
							<td>{{ $copia->nombre_copia }}</td>
							<td>{{ $copia->fecha_archivo }}</td>
							<td>{{ $copia->nombre_usuario }}</td>
							<td>{{ $copia->nombre_granja }}</td>
							<td>
								<a href="{{ route('admin.copiaPigWin.downloadBack', $copia->path) }}" class="btn btn-success">
									<span class="lnr lnr-enter-down"> Descargar</span>
								</a>
								<a href="{{ route('admin.copiaPigWin.destroy', $copia->id) }}" class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminarlo?')"><span class="fa fa-trash"></span></a>
							</td> 
						</tr>
					@endforeach		
				</tbody>
			</table>
		</div>
	</div>	
@endsection