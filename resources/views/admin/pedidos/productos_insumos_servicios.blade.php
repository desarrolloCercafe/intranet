@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>PME{{$consecutivo}} | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> PME{{$consecutivo}}</h4>
		</div>
		<br>
		<div class="container-fluid col-xs-6 col-lg-12">
			<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
		</div>
		<div class="panel-body table-responsive">
			<table class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead>  
					<tr style="color: white;">
						<td><strong>Nombre de la Granja</strong></td>
						<td><strong>Nombre del Insumo</strong></td>
						<td><strong>Cantidad</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($productos_db as $producto_db)
						<tr>
							<td>{{$producto_db["granja"]}}</td>
							<td>{{$producto_db["insumo"]}}</td>
							<td>{{$producto_db["unidades"]}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
@endsection