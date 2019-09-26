@extends('template.plantilla')
@section('content')
	<title>Editar Area | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Editar Area</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> ['admin.areas.update', $area->id], 'class'=>'form-horizontal', 'method'=>'PUT'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('nombre_area', 'Nombre: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::text('nombre_area', $area->nombre_area, ['class'=>'form-control'])!!}
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('descripcion_area', 'Descripción: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						{!!Form::textarea('descripcion_area', $area->descripcion_area, ['class'=>'form-control', 'cols' => '30', 'rows' => '10'])!!}
					</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Editar Area', array('class'=>'btn btn-info btn-md'))!!}</li>
					</ul>
				</div>
			{{Form::close()}}
		</div>
	</div>
	
@endsection