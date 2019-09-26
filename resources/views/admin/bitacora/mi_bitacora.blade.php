@extends('template.plantilla')
@section('content')
	@include('flash::message') 
	<title>Bitacora | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;"><i class="fa fa-list-alt"></i> Archivos de Bitácora</h4>
		</div>
		<br>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
						<td><strong>Archivo</strong></td>
						<td><strong>Autor</strong></td>
						<td><strong>Opción</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($archivos as $archivo)
						<tr>
							<td>{{ $archivo->nombre_archivo }}</td>
							<td>{{ $archivo->nombre_usuario }}</td>
							<td>
								<div class="btn-group">
									<a href="{{ route('admin.bitacora.downloadFile', $archivo->path) }}"><button type="button" class="btn btn-success"><span class="fa fa-download" aria-hidden="true"></span> Descargar</button>
									</a>
								
									@if($archivo->nombre_usuario == Auth::user()->nombre_completo)
										<a href="{{ route('admin.bitacora.destroy', $archivo->id) }}" onclick="return confirm('¿Seguro que desea eliminarlo?')">
											<button type="button" class="btn btn-danger"><span class="fa fa-trash" aria-hidden="true"></span> Eliminar</button>
										</a>
									@endif
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection