@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registrar Concentrado | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Concentrado</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.concentrados.store', 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('ref_concentrado', 'Referencia: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('ref_concentrado', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('nombre_concentrado', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">	
						{!!Form::text('nombre_concentrado',null, ['class'=>'form-control', 'placeholder' => '...'])!!}
					</div> 
				</div>
				<div class="form-group">
					{!!Form::label('tipo_concentrado', 'Proveedor: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('tipo_concentrado', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('precio_concentrado', 'Precio X Kg: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('precio_concentrado', null, ['class'=>'form-control'])!!}
					</div>
				</div> 
				<div class="form-group">
					{!!Form::label('kg', 'Kilogramos: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('kg', null, ['class'=>'form-control'])!!}
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
					{!!Form::label('medida', 'Unidad de medida: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						<select name="medida" class="form-control">
							<option value="">Seleccione...</option>
							<option value="1">Bultos</option>
							<option value="2">Granel</option>
						</select>
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md" style="margin-bottom: 1em;">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Concentrado', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection