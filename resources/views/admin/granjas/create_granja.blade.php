@extends('template.plantilla')
@section('content')
	<title>Nueva Granja | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 24px;" align="center"><i class="fa fa-plus-square"></i><strong> Registrar Granja</strong></h4>
		</div>
		<div class="panel-body">
			{!!Form::open(array('route'=>'admin.granja.store','method'=>'POST','autocomplete'=>'off'))!!}
				{{Form::token()}}
				<div class="row">
					<div class="form-group col-lg-6 col-md-6 col-xs-12">
						<label for="nombre_granja">Granja</label>
						<input type="text" name="nombre_granja" class="form-control" placeholder="Nombre Granja">
					</div>
					<div class="form-group col-lg-6 col-md-6 col-xs-12">
						<label for="descripcion_granja">descripcion granja</label>
						<input type="text" name="descripcion_granja" class="form-control" placeholder="Descripcion">
					</div>
					<div class="form-group col-lg-6 col-md-6 col-xs-12">
						<label for="direccion_granja">Direccion granja</label>
						<input type="text" name="direccion_granja" class="form-control" placeholder="Direccion">
					</div>
					<div class="form-group col-lg-6 col-md-6 col-xs-12">
						<label for="numero_contacto_granja">Telefono</label>
						<input type="number" name="numero_contacto_granja" class="form-control" placeholder="00000">
					</div>
					<div class="form-group col-lg-6 col-md-6 col-xs-12">
						<label for="porcentaje_precebo">Porcentaje Precebo</label>
						<input type="text" name="porcentaje_precebo" class="form-control" placeholder="000000">
					</div>
					<div class="form-group col-lg-6 col-md-6 col-xs-12">
						<label for="porcentaje_ceba">Porcentaje Ceba</label>
						<input type="text" name="porcentaje_ceba" class="form-control" placeholder="00000">
					</div>
					
					<div class="form-group col-lg-12 col-md-12 col-xs-12">
						<ul class="list-inline" align="center">
							<button class="btn btn-success" type="submit" id="crear">Crear</button>
							<a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a>
						</ul>
					</div>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
@endsection