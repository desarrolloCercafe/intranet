@extends('template.plantilla')
@section('content')  
	<title>Informacion Ceba | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-building-o" aria-hidden="true"></i> {{$granja->nombre_granja}} </h4>
		</div>
		<div class="panel-body">		
			<div class="row">
				<div class="form-group col-sm-4 col-xs-12 col-lg-4">
					<label class="control-label">Numero del Lote:</label>
					{{Form::text('lote',$ceba_c->lote,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Fecha Inicial:</label>
					{{Form::text('fecha_igreso',$ceba_c->fecha_ingreso_lote,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12 col-lg-4">
					<label class="control-label">Fecha Final:</label>
					{{Form::text('fecha_salida',$ceba_c->fecha_salida_lote,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Numero Inicial de Cerdos:</label>
					{{Form::text('incial',$ceba_c->inic,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Numero Final de Cerdos:</label>
					{{Form::text('incial',$ceba_c->cant_final_cerdos,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Porcentaje de Mortalidad:</label>
					{{Form::text('descartes',$ceba_c->por_mortalidad .'%',['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Dias:</label>
					{{Form::text('dias',$ceba_c->dias,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Peso Promedio Inicial:</label>
					{{Form::text('entrega',$ceba_c->peso_promedio_ingresado,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Peso Promedio Final:</label>
					{{Form::text('entrega',$ceba_c->peso_promedio_vendido,['class'=>'form-control','readonly'])}}
				</div>
				
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Consumo Promedio:</label>
					{{Form::text('dias_jaulon',$ceba_c->cons_promedio_ini,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Consumo Promedio Día:</label>
					{{Form::text('dias_jaulon',$ceba_c->cons_promedio_dia_ini,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Ganancia Promedio:</label>
					{{Form::text('peso_vendido',$ceba_c->ato_promedio_ini,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Ganancia Promedio Día:</label>
					{{Form::text('peso_vendido',$ceba_c->ato_promedio_dia_ini,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Conversion Real:</label>
					{{Form::text('peso_vendido',$ceba_c->conversion_ini,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Conversion Ajustada:</label>
					{{Form::text('peso_vendido',$ceba_c->conversion_ajust_ini,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Consumo Promedio con Mortalidad:</label>
					{{Form::text('dias_jaulon',$ceba_c->consumo_promedio_lote,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Consumo Promedio Día con Mortalidad:</label>
					{{Form::text('dias_jaulon',$ceba_c->consumo_promedio_lote_dias,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Ganancia Promedio con Mortalidad:</label>
					{{Form::text('peso_vendido',$ceba_c->ato_promedio_fin,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Ganancia Promedio Día con Mortalidad:</label>
					{{Form::text('peso_vendido',$ceba_c->ato_promedio_dia_fin,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Conversion Real con Mortalidad:</label>
					{{Form::text('peso_vendido',$ceba_c->conversion_fin,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="" class="control-label">Conversion Ajustada con Mortalidad:</label>
					{{Form::text('peso_vendido',$ceba_c->conversion_ajust_fin,['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-sm-4">
					<label for="" class="control-label">Tipo de Exportación:</label>
					<br>
					<a href="/intranetcercafe/public/admin/pdfCebaIndividual/{{$ceba_c->id}}" class="btn btn-default boton" data-toggle="tooltip" data-placement="top" title="Exportar a PDF"><i class="fa fa-file-pdf-o fa-2x"></i></a>
					<a href="/intranetcercafe/public/admin/excelCebaIndividual/{{$ceba_c->id}}" class="btn btn-default boton_excel" data-toggle="tooltip" data-placement="top" title="Exportar a EXCEL"><i class="fa fa-file-excel-o fa-2x"></i></a>
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