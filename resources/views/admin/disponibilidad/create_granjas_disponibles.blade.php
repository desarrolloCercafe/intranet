@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Crear Granjas Disponibles</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h2><i class="fa fa-plus-square-o" aria-hidden="true"></i> Crear Granja Disponible</h2>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=>'admin.disponibilidad.store','method'=>'POST'])!!}
				{{-- <input type="hidden" name="_token" value="{{csrf_token()}} "> --}}
				<div class="form-group col-lg-6 col-xs-12">
					<label>Granja:</label>
					<select name="granja" id="" class="form-control">
						<option></option>
						@if(Auth::User()->rol_id != 7)
							@foreach($g_as as $g)
								@if($g->user_id == Auth::User()->id)
									@foreach($granjas as $granja)
										@if($g->granja_id == $granja->id)
											<option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>
										@endif
									@endforeach	
								@endif	
							@endforeach
						@else
							@foreach($granjas as $granja)
								<option value="{{$granja->id}} ">{{$granja->nombre_granja}}</option>
							@endforeach
						@endif
					</select>	
				</div>
				<div class="form-group col-lg-6 col-xs-12">
					<label>Numero de Semana:</label>
					<input type="text" name="semana" readonly class="form-control">
				</div>
				<div class="form-group col-lg-6 col-xs-12">
					<label>Numero de Cerdos</label>
					<input type="text" name="numero_cerdos" class="form-control" placeholder="#">
				</div>
				<div class="form-group col-lg-6 col-xs-12">
					<label>Peso Promedio:</label>
					<input type="text" name="peso_promedio" class="form-control" placeholder="Peso">
				</div>
				<div class="form-group col-lg-12 col-xs-12">
					<ul class="list-inline" align="center">
						<li><a href="javascript:history.go(-1);" class="btn btn-danger btn-md">Cancelar</a></li>
						<li>{!!Form::submit('Registrar Información', array('class'=>'btn btn-success btn-md'))!!}</li>
					</ul>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$("[name='granja']").select2({
				placeholder: "Seleccione Granja",
			})
			var w = moment().week();
			// console.log(w);
			$("[name='semana']").val(w+1);
		})
	</script>
@endsection