@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registrar Medicamento | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Medicamento</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.medicamentos.store', 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('ref_medicamento', 'Referencia: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('ref_medicamento', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('nombre_medicamento', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">	
						{!!Form::text('nombre_medicamento',null, ['class'=>'form-control', 'placeholder' => '...'])!!}
					</div> 
				</div>
				<div class="form-group">
					{!!Form::label('tipo_medicamento', 'Tipo: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('tipo_medicamento', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('precio_medicamento', 'Precio: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('precio_medicamento', null, ['class'=>'form-control'])!!}
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
				<div class="form-group"> 
					{!!Form::label('p_4', 'Proveedor #4: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('proveedor_4', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md" style="margin-bottom: 1em;">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Medicamento', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection