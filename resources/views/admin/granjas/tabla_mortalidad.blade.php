@extends('template.plantilla')
@section('content')
	<title>Informacion Mortalidad | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-building-o" aria-hidden="true"></i> {{$granja->nombre_granja}} </h4>
		</div>
		<div class="panel-body">		
			<div class="row">
				<div class="form-group col-sm-4 col-xs-12 col-lg-4">
					<label class="control-label">Numero del Lote:</label>
					{{Form::text('lote',$mortalidad->lote,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">sala:</label>
					{{Form::text('sala',$mortalidad->sala,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12 col-lg-4">
					<label class="control-label">Cantidad de Cerdos:</label>
					{{Form::text('numero_cerdos',$mortalidad->numero_cerdos,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Sexo del Porcino:</label>
					{{Form::text('sexo',$mortalidad->sexo_cerdo,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Peso del Porcino:</label>
					{{Form::text('peso',$mortalidad->peso_cerdo,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Fecha de la Muerte:</label>
					{{Form::text('fecha',$mortalidad->fecha,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Edad del Porcino:</label>
					{{Form::text('edad',$mortalidad->edad_cerdo,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Causa de la Muerte:</label>
					{{Form::text('muerte',$nombre_muerte->causa,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Tipo de Alimento:</label>
					{{Form::text('alimento',$alimento->nombre_alimento,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4">
					<label for="" class="control-label">Tipo de Exportación:</label>
					<br>
					<a href="/intranetcercafe/public/admin/pdfMortalidadIndividual/{{$mortalidad->id}}" class="btn btn-default boton" data-toggle="tooltip" data-placement="top" title="Exportar a PDF"><i class="fa fa-file-pdf-o fa-2x"></i></a>
					<a  href="/intranetcercafe/public/admin/excelMortalidadIndividual/{{$mortalidad->id}}" class="btn btn-default boton_excel" data-toggle="tooltip" data-placement="top" title="Exportar a EXCEL"><i class="fa fa-file-excel-o fa-2x"></i></a>
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