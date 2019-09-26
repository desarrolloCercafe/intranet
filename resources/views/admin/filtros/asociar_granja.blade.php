@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Asignar Granja | Cercafe</title> 
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus" aria-hidden="true"></i> Asignar Granja</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.asociacionGranjas.store', 'class'=>'form-horizontal', 'method'=>'POST'])!!}
				<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
				<div class="form-group">
					{!!Form::label('granja', 'Granja: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						<datalist id="pro_list2">
                            @foreach($granjas as $granja)
                                <option value="{{$granja->nombre_granja}}">{{$granja->id}}</option>
                            @endforeach
                        </datalist>
                       	<input list="pro_list2" type="search" class="form-control" id="granja" name="granja" placeholder="Seleccione una Granja"></input>
					</div>
				</div>
				<div class="form-group">
					{!!Form::label('perfil', 'Nombre: ', ['class'=>'col-lg-4 control-label'])!!}
					<div class="col-lg-4">
						<datalist id="pro_list">
                            @foreach($usuarios as $usuario)
                                <option value="{{$usuario->nombre_completo}}">{{$usuario->id}}</option>
                            @endforeach
                        </datalist>
                        <input list="pro_list" type="search" class="form-control" id="perfil" name="perfil" placeholder="Seleccione un Usuario"></input>
           			</div>
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" type="button" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Permiso', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!! Form::close() !!}
		</div>
	</div> 
@endsection