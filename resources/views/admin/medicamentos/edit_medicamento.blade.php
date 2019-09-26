@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Editar Medicamento| Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Editar Medicamento</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.medicamentos.update', $medicamento], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('ref_medicamento', 'Referencia: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('ref_medicamento', $medicamento->ref_medicamento, ['class'=>'form-control'])!!}
					</div>
				</div> 
				<div class="form-group">
					{!!Form::label('nombre_medicamento', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">	
						{!!Form::text('nombre_medicamento', $medicamento->nombre_medicamento, ['class'=>'form-control', 'placeholder' => '...'])!!}
					</div> 
				</div>
				<div class="form-group">
					{!!Form::label('tipo_medicamento', 'Tipo: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('tipo_medicamento', $medicamento->tipo_medicamento, ['class'=>'form-control'])!!}
					</div>
				</div>

				<div class="form-group">
					{!!Form::label('p_1', 'Proveedor #1: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_1', $medicamento->proveedor_1, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('p_2', 'Proveedor #2: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_2', $medicamento->proveedor_2, ['class'=>'form-control'])!!}
					</div>
				</div>

				<div class="form-group">
					{!!Form::label('p_3', 'Proveedor #3: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_3', $medicamento->proveedor_3, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('p_4', 'Proveedor #4: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_4', $medicamento->proveedor_4, ['class'=>'form-control'])!!}
					</div>
				</div>

				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Editar Medicamento', array('class'=>'btn btn-info btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection