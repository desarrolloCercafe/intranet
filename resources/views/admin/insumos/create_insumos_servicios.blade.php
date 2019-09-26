@extends('template.plantilla')
@section('content')
	@include('flash::message') 
	<title>Registrar Insumo | Cercafe</title>
	<div class="panel panel-danger"> 
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Insumo o Servicio</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.insumosServicios.store', 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('ref_insumo_servicio', 'Referencia: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('ref_insumo_servicio', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('nombre_insumo_servicio', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">	
						{!!Form::textarea('nombre_insumo_servicio',null, ['class'=>'form-control', 'placeholder' => '...', 'cols' => '30', 'rows' => '10'])!!}
					</div> 
				</div>
				<div class="form-group">
					{!!Form::label('tipo_insumo_servicio', 'Tipo: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('tipo_insumo_servicio', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('precio_insumo', 'Precio: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('precio_insumo', null, ['class'=>'form-control'])!!}
					</div>
				</div> 
				<div class="form-group">
					{!!Form::label('iva', 'Iva: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						<select class="form-control" id="iva_id" name="iva_id" style="width: 100% !important;">
	                        <option></option>
	                        @foreach($valores as $valor)
	                           <option value="{{$valor->id}}">{{$valor->valor_iva}}</option>
	                        @endforeach
	                    </select>
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('p_1', 'Proveedor #1: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_1', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('p_2', 'Proveedor #2: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_2', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group"> 
					{!!Form::label('p_3', 'Proveedor #3: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_3', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Insumo', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection