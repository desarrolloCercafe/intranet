@extends('template.plantilla')
@section('content')
	@include('flash::message')	
	<title>Filtro | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt"></i> Filtro de Productos</h4>
		</div> 
		<br>
		<div class="container-fluid col-xs-6 col-lg-12">
			<div class="form-group">
				<a href="javascript:history.go(-1);" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Regresar</a>
            	<a href="/intranetcercafe/public/admin/excelFiltradoPorProductoCia/{{$f_ini}}/{{$f_fin}}/{{$grj}}" class="btn btn-success"><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} Exportar</i></a>
			</div>
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead style="background-color: #df0101"> 
					<tr style="color: white;">
						<td><strong>Fecha</strong></td>
						<td><strong>Nombre de la Granja</strong></td>
						<td><strong>Codigo</strong></td>
						<td><strong>Producto</strong></td>
						<td><strong>Cantidad</strong></td>
						<td><strong>Consecutivo</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($productos_db as $producto_db)
                        <tr>
                            <td>{{ $producto_db["fecha"] }}</td>
                            <td>{{ $producto_db["granja"] }}</td>
                            <td>{{ $producto_db["ref"] }}</td>
                            <td>{{ $producto_db["producto"] }}</td>
                            <td>{{ $producto_db["dosis"] }}</td>
                            <td>
                                <a href="#">
                                    <strong>PSE{{ $producto_db["consecutivo"] }}</strong>
                                </a>
                            </td>
                        </tr>
                    @endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
