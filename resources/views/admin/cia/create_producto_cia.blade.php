@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Registrar Producto Cia | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Producto</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.productoCia.store', 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					{!!Form::label('ref_producto_cia', 'Referencia: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('ref_producto_cia', null, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('nombre_producto_cia', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">	
						{!!Form::textarea('nombre_producto_cia',null, ['class'=>'form-control', 'placeholder' => '...', 'cols' => '30', 'rows' => '10'])!!}
					</div> 
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md" style="margin-bottom: 1em;">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Producto', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection