@extends('template.plantilla')
@section('content')
	<title>Informacion Destetos Semanales | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-building-o" aria-hidden="true"></i> {{$granja->nombre_granja}} </h4>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-sm-4 col-xs-12 col-lg-4">
					<label class="control-label">Numero del Lote:</label>
					{{Form::text('lote',$desteto_s->lote,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12 col-lg-4">
					<label class="control-label">Año del Destete:</label>
					{{Form::text('año',$desteto_s->año_destete,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Semana del Destete:</label>
					{{Form::text('semana',$desteto_s->semana_destete,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Numero de Destetos:</label>
					{{Form::text('numero',$desteto_s->numero_destetos,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Mortalidad en Precebo:</label>
					{{Form::text('numero',$desteto_s->mortalidad_precebo,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Mortalidad en Ceba:</label>
					{{Form::text('numero',$desteto_s->mortalidad_ceba,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Disponibilidad en Venta:</label>
					{{Form::text('numero',$desteto_s->disponibilidad_venta,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Kilos en Venta:</label>
					{{Form::text('numero',$desteto_s->kilos_venta,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4">
					<label for="" class="control-label">Tipo de Exportación:</label>
					<br>
					<a href="/intranetcercafe/public/admin/pdfDestetoSemanalIndividual/{{$desteto_s->id}}" class="btn btn-default boton" data-toggle="tooltip" data-placement="top" title="Exportar a PDF"><i class="fa fa-file-pdf-o fa-2x"></i></a>
					<a href="/intranetcercafe/public/admin/excelDestetoSemanalIndividual/{{$desteto_s->id}}" class="btn btn-default boton_excel" data-toggle="tooltip" data-placement="top" title="Exportar a EXCEL"><i class="fa fa-file-excel-o fa-2x"></i></a>
				</div>
				<div class="col-sm-7">
					<ul class="pagination">
						<a href="javascript:history.go(-1);" class="btn btn-info pull-right btn-md"><i class="fa fa-arrow-left"></i> Regresar</a>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection