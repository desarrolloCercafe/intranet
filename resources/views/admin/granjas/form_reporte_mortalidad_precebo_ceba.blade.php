@extends('template.plantilla')
@section('content')
	<title>Mortalidad | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus-square" aria-hidden="true"></i><strong> Formulario de Reporte de Mortalidad, Precebo y Ceba</strong></h4>
		</div>
		<div class="panel-body">
			{!!Html::script('js/operaciones-reportes-mortalidad.js')!!} 
			{!!Form::open(['route'=> 'admin.reporteMortalidad.store','id'=>'fechas','method'=>'POST'])!!}
				<div class="row">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('granja', 'Granja: ', ['class'=>'control-label'])!!}
						<select name="granja" class="form-control" id="granjas">
							<option value="">Seleccione...</option>
                            @if(Auth::User()->rol_id == 7)
                                @foreach($granjas as $granja)
                                    <option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>     
                                @endforeach
                            @else
                                @foreach($g_as as $g)
                                    @if($g->user_id == Auth::User()->id)
                                        @foreach($granjas as $granja)
                                            @if($g->granja_id == $granja->id)
                                                <option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </select>
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						 {!!Form::label('lote', 'Lote: ', ['class'=>'control-label'])!!}
						 {!!Form::text('lote', null, ['class'=>'form-control', 'placeholder' => '###', 'id'=>'loteId', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('sala', 'Sala: ', ['class'=>'control-label'])!!}
						{!!Form::text('sala', null, ['class'=>'form-control', 'placeholder' => '..', 'id'=>'sala', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						 {!!Form::label('numero_cerdos', 'Numero de Cerdos: ', ['class'=>'control-label'])!!}
						 {!!Form::number('numero_cerdos', null, ['class'=>'form-control', 'id'=>'numero_cerdos', 'placeholder' => '#', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('sexo_cerdo', 'Sexo del Porcino: ', ['class'=>' control-label'])!!}
						<select name="sexo_cerdo" id="sexo_cerdo" class='form-control' required="required" style="cursor: pointer;">
                            <option value="Macho" >M</option>
                            <option value="Hembra" >H</option>
                        </select>
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('peso_cerdo', 'Peso del Porcino: ', ['class'=>'control-label'])!!}
						<i class="advertencia fa fa-exclamation-circle btn-sm pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Este campo generalmente es decimal, ingresar la Información con '.' y evitando la ',' "></i>
						{!!Form::text('peso_cerdo', null, ['class'=>'form-control', 'placeholder' => 'Kg', 'id'=>'peso_cerdo', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						 {!!Form::label('fecha_muerte', 'Fecha de Muerte: ', ['class'=>'control-label'])!!}
						{!!Form::text('fecha_muerte',null, ['id'=>'fecha_m','class'=>'form-control', 'required','onChange'=>'fechasMuerte();', 'style' => 'cursor: pointer !important;', 'readonly'])!!}
					</div>

					{!!Form::hidden('dia_muerte', null, ['id'=>'dia_m','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('año_muerte', null, ['id'=>'año_m','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('mes_muerte', null, ['id'=>'mes_m','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('semana_muerte', null, ['id'=>'semana_m','class'=>'form-control', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('edad_cerdo', 'Edad del Porcino: ', ['class'=>'control-label'])!!}
						<i class="advertencia fa fa-exclamation-circle btn-sm pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Este campo generalmente es decimal, ingresar la Información con '.' y evitando la ',' "></i>
						{!!Form::text('edad_cerdo', null, ['id'=>'semana','class'=>'form-control', 'placeholder' => 'edad', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('causa', 'Causas: ', ['class'=>'control-label'])!!}
						{!!Form::select('causa', $causas, [""], ['class'=>'form-control','required' => 'required', 'style' => 'cursor: pointer;', 'placeholder' => 'Seleccione...', 'id'=>'causa_m'])!!}
					</div> 
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('alimento', 'Alimentos: ', ['class'=>'control-label'])!!}
						 {!!Form::select('alimento', $alimentos,[""], ['class'=>'form-control','required' => 'required', 'style' => 'cursor: pointer !important;', 'placeholder' => 'Seleccione...', 'id'=>'alimento'])!!}
					</div>
					<div class="form-group col-lg-12 col-xs-12">
						<ul class="list-inline" align="center">
							<li><a href="javascript:history.go(-1);" class="btn btn-danger">Cancelar</a></li>
							<li>{!!Form::submit('Registrar Información', array('class'=>'btn btn-success btn-md'))!!}</li>	
						</ul>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>


<script type="text/javascript">
	$(document).ready(function() {
		var formulario = document.getElementById('fechas');
		formulario.addEventListener('submit', e=> {
			e.preventDefault();
			var lote = document.getElementById('loteId').value;
			var sala = document.getElementById('sala').value;
			var numero_cerdos = document.getElementById('numero_cerdos').value;
			var sexo_cerdo = document.getElementById('sexo_cerdo').value;
			var peso_cerdo = document.getElementById('peso_cerdo').value;
			var fecha_muerte = document.getElementById('fecha_m').value;
			var dia_muerte = document.getElementById('dia_m').value;
			var year_muerte = document.getElementById('año_m').value;
			var mes_muerte = document.getElementById('mes_m').value;
			var semana_muerte = document.getElementById('semana_m').value;
			var edad_cerdo = document.getElementById('semana').value;
			var causa_muerte = document.getElementById('causa_m').value;
			var alimento = document.getElementById('alimento').value;
		Swal({
		  title: '¿Registrar Información?' + '<br><br>',
		  html: `
			 <div class="container-fluid">
			 <div class="table-responsive table-responsive-xl table-responsive-lg" style="witdh: 100%; height:430px; overflow-y: scroll">
			 	<table class="table table-hover table-bordered">
			    <tbody>
		        <tr>
		          <th>Lote</th>
		            <td>${lote}</td>
		        </tr>
		        <tr>
		          <th>Sala</th>
		            <td>${sala}</td>
		        </tr>
		        <tr>
		          <th># Cerdos</th>
		            <td>${numero_cerdos}</td>
		        </tr>
		        <tr>
		          <th>Sexo Cerdo</th>
		            <td>${sexo_cerdo}</td>
		        </tr>
		        <tr>
		          <th>Peso Cerdo</th>
		            <td>${peso_cerdo}</td>
		        </tr>
		        <tr>
		          <th>Fecha Muerte</th>
		            <td>${fecha_muerte}</td>
		        </tr>
		        <tr>
		          <th>Dia Muerte</th>
		            <td>${dia_muerte}</td>
		        </tr>
		        <tr>
		          <th>Año Muerte</th>
		            <td>${year_muerte}</td>
		        </tr>
		        <tr>
		          <th>Mes Muerte</th>
		            <td>${mes_muerte}</td>
		        </tr>
		        <tr>
		          <th>Semana Muerte</th>
		            <td>${semana_muerte}</td>
		        </tr>
		        <tr>
		          <th>Edad Cerdo</th>
		            <td>${edad_cerdo}</td>
		        </tr>
		        <tr>
		          <th>Causa Muerte</th>
		            <td>${causa_muerte}</td>
		        </tr>
		        <tr>
		          <th>Alimento</th>
		            <td>${alimento}</td>
		        </tr>
		         
		    </tbody>
			   </table>
			 </div>
			 
			 </div>
			`,
			  showCancelButton: true,
			  confirmButtonColor: '#5cb85c',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Registrar'
			}).then((result) => 
			{
			  if (result.value) 
			  {
			  var url = "http://201.236.212.130:82/intranetcercafe/public/admin/reporteMortalidad";
			   	$.ajax({
			   		type: "POST",
				   	url: url,                     
			        data: $("#fechas").serialize(), 
			           		success: function(data){
			            	Swal(
							  'Correcto!',
							  'Datos Registrados!!',
							  'success'
							)
							$('#granjas').append('<option value="" selected="selected">Seleccione... </option>');
							$("#fechas")[0].reset();        
			           },
			           error: function(err){
			           	Swal({
							  type: 'error',
							  title: 'Oops...',
							  text: 'Ocurrió un error!',
							})
			           }

			   	});
			  }
			})
		});
	
  
	})
</script>
 


@endsection