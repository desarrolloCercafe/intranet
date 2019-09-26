@extends('template.plantilla')
@section('content')
	<title>Editar Granja | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus-square"></i><strong> Editar Granja</strong></h4>
		</div> 
		<div class="panel-body">
			{!!Form::open(['route'=>['admin.granja.update',$granja],'method'=>'PUT'])!!}
				{{Form::token()}}
				<div class="form-group col-lg-6 col-md-6 col-xs-12">
					<label for="nombre_granja">Granja</label>
					<input type="text" name="nombre_granja" class="form-control" value="{{$granja->nombre_granja}}" placeholder="Nombre Granja">
				</div>
				<div class="form-group col-lg-6 col-md-6 col-xs-12">
					<label for="descripcion_granja">descripcion granja</label>
					<input type="text" name="descripcion_granja" class="form-control" value="{{$granja->descripcion_granja}}" placeholder="Descripcion">
				</div>
				<div class="form-group col-lg-6 col-md-6 col-xs-12">
					<label for="direccion_granja">Direccion granja</label>
					<input type="text" name="direccion_granja" class="form-control"value="{{$granja->direccion_granja}}" placeholder="Direccion">
				</div>
				<div class="form-group col-lg-6 col-md-6 col-xs-12">
					<label for="numero_contacto_granja">Telefono</label>
					<input type="number" name="numero_contacto_granja" class="form-control"  value="{{$granja->numero_contacto_granja}}"placeholder="00000">
				</div>
				<div class="form-group col-lg-6 col-md-6 col-xs-12">
					<label for="porcentaje_precebo">Porcentaje Precebo</label>
					<input type="number" name="porcentaje_precebo" class="form-control" value="{{$granja->porcentaje_precebo}}" placeholder="000000">
				</div>
				<div class="form-group col-lg-6 col-md-6 col-xs-12">
					<label for="porcentaje_ceba">Porcentaje Ceba</label>
					<input type="number" name="porcentaje_ceba" class="form-control" value="{{$granja->porcentaje_ceba}}" placeholder="00000">
				</div>
				<div class="form-group col-lg-12 col-xs-12">
						<ul class="list-inline" align="center">
							<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
							<li>{!!Form::submit('Editar Granja', array('class'=>'btn btn-info btn-md', 'id' => 'editar'))!!}</li>
						</ul>
					</div>
			{!!Form::close()!!}
		</div>
	</div>
@endsection