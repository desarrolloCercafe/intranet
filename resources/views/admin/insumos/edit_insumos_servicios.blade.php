@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Editar  Insumo| Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Editar Insumo o Servicio</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.insumosServicios.update', $insumo_servicio], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('ref_insumo_servicio', 'Referencia: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('ref_insumo_servicio', $insumo_servicio->ref_insumo, ['class'=>'form-control'])!!}
					</div>
				</div> 
				<div class="form-group"> 
					{!!Form::label('nombre_insumo_servicio', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">	
						{!!Form::textarea('nombre_insumo_servicio', $insumo_servicio->nombre_insumo, ['class'=>'form-control', 'placeholder' => '...', 'cols' => '30', 'rows' => '10'])!!}
					</div> 
				</div>
				<div class="form-group">
					{!!Form::label('tipo_insumo_servicio', 'Tipo: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('tipo_insumo_servicio', $insumo_servicio->tipo_insumo, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('p_1', 'Proveedor #1: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_1', $insumo_servicio->proveedor_1, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('p_2', 'Proveedor #2: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_2', $insumo_servicio->proveedor_2, ['class'=>'form-control'])!!}
					</div>
				</div>

				<div class="form-group">
					{!!Form::label('p_3', 'Proveedor #3: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_3', $insumo_servicio->proveedor_3, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('p_4', 'Proveedor #4: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_4', $insumo_servicio->proveedor_4, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center"> 
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Editar Insumo', array('class'=>'btn btn-info btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection