@extends('template.plantilla')
@section('content')
	{!!Html::script('js/operandos-destete-finalizacion.js')!!}
	<title>Destetes Semana | Cercafe</title>  
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus-square" aria-hidden="true"></i><strong> Formulario Destetes por Semana</strong></h4>
		</div>
		<div class="panel-body">
			{!!Html::script('js/operaciones-reporte-destetos-semana.js')!!} 
			{!!Form::open(['route'=> 'admin.destetosSemana.store', 'id'=>'fechas', 'method'=>'POST'])!!}
				<div class="row">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('granja', 'Granja: ', ['class'=>'control-label'])!!}
						<select name="granja" class="form-control" id="granjas" style="cursor: pointer;">
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
						{!!Form::label('numero_lote', '# Lote: ', ['class'=>'control-label'])!!}
						{!!Form::number('numero_lote',null, ['id'=>'n_lote','class'=>'form-control', 'placeholder' => '#'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('año_destete', 'Año de Destete: ', ['class'=>'control-label'])!!}
						{!!Form::number('año_destete',null, ['id'=>'a_destete','class'=>'form-control', 'placeholder' => '#', 'required','onChange'=>'cebaDates();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('semana_destete', 'Semana de Destete: ', ['class'=>'control-label'])!!}
						{!!Form::number('semana_destete',null, ['id'=>'s_destete','class'=>'form-control', 'placeholder' => '#', 'required','onChange'=>'cebaDates();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('cant_destetos', '# Destetos: ', ['class'=>'control-label'])!!}
						{!!Form::number('cant_destetos',null, ['id'=>'n_destetos','class'=>'form-control', 'placeholder' => '#', 'required','onChange'=>'cebaDates();'])!!}
					</div>

					{!!Form::hidden('traslado_ceba',null, ['id'=>'t_ceba','class'=>'form-control', 'placeholder' => 'Traslado Ceba', 'readonly'])!!}

                    {!!Form::hidden('semana_venta',null, ['id'=>'s_venta','class'=>'form-control', 'placeholder' => 'Semana de Venta', 'readonly','onChange'=>'totalCerdos();'])!!}

                    {!!Form::hidden('año_venta',null, ['id'=>'a_venta','class'=>'form-control', 'placeholder' => 'Año Venta final', 'readonly'])!!}

                    {!!Form::hidden('semana_1_fase_1',null, ['id'=>'sem_1_f_1','class'=>'form-control', 'placeholder' => 'Semana 1 Fase 1', 'readonly'])!!}

                    {!!Form::hidden('consumo_sem1_fase_1',null, ['id'=>'cons_s_1_f_1','class'=>'form-control', 'placeholder' => 'Consumo Semana 1 Fase 1', 'readonly'])!!}

                    {!!Form::hidden('semana_2_fase_1',null, ['id'=>'sem_2_f_1','class'=>'form-control', 'placeholder' => 'Semana 2 Fase 1', 'readonly'])!!}

                    {!!Form::hidden('consumo_sem2_fase_1',null, ['id'=>'cons_s_2_f_1','class'=>'form-control', 'placeholder' => 'Consumo Semana 2 Fase 1', 'readonly'])!!}

                    {!!Form::hidden('semana_1_fase_2',null, ['id'=>'sem_1_f_2','class'=>'form-control', 'placeholder' => 'Semana 1 Fase 2', 'readonly'])!!}

                    {!!Form::hidden('consumo_sem1_fase_2',null, ['id'=>'cons_s_1_f_2','class'=>'form-control', 'placeholder' => 'Consumo Semana 1 Fase 2', 'readonly','onChange'=>'diasPermanencia();'])!!}

                    {!!Form::hidden('semana_2_fase_2',null, ['id'=>'sem_2_f_2','class'=>'form-control', 'placeholder' => 'Semana 2 Fase 2', 'readonly'])!!}
            
                    {!!Form::hidden('consumo_sem2_fase_2',null, ['id'=>'cons_s_2_f_2','class'=>'form-control', 'placeholder' => 'Consumo Semana 2 Fase 2', 'readonly','onChange'=>'diasPermanencia();'])!!}
                
                    {!!Form::hidden('semana_1_fase_3',null, ['id'=>'sem_1_f_3','class'=>'form-control', 'placeholder' => 'Semana 1 Fase 3', 'readonly'])!!}
                    
                    {!!Form::hidden('consumo_sem1_fase_3',null, ['id'=>'cons_s_1_f_3','class'=>'form-control', 'placeholder' => 'Consumo Semana 1 Fase 3', 'readonly','onChange'=>'diasPermanencia();'])!!}
                
                    {!!Form::hidden('semana_2_fase_3',null, ['id'=>'sem_2_f_3','class'=>'form-control', 'placeholder' => 'Semana 2 Fase 3', 'readonly'])!!}
                    
                    {!!Form::hidden('consumo_sem2_fase_3',null, ['id'=>'cons_s_2_f_3','class'=>'form-control', 'placeholder' => 'Consumo Semana 2 Fase 3', 'readonly','onChange'=>'diasPermanencia();'])!!}
                    
                    {!!Form::hidden('semana_3_fase_3',null, ['id'=>'sem_3_f_3','class'=>'form-control', 'placeholder' => 'Semana 3 Fase 3', 'readonly'])!!}
                    
                    {!!Form::hidden('consumo_sem3_fase_3',null, ['id'=>'cons_s_3_f_3','class'=>'form-control', 'placeholder' => 'Consumo Semana 3 Fase 3', 'readonly','onChange'=>'diasPermanencia();'])!!}

					<div class="form-group col-lg-12 col-xs-12">
						<ul class="list-inline" align="center">
							<li><a href="javascript:history.go(-1);" class="btn btn-danger btn-md">Cancelar</a></li>
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
			var lote = document.getElementById('n_lote').value;
			var year_destete = document.getElementById('a_destete').value;
			var semana_destete = document.getElementById('s_destete').value;
			var cant_destetos = document.getElementById('n_destetos').value;
			var traslado_ceba = document.getElementById('t_ceba').value;
			var s_venta = document.getElementById('s_venta').value;
			var year_venta = document.getElementById('a_venta').value;
			var sem_1_f_1 = document.getElementById('sem_1_f_1').value;
			var cons_s_1_f_1 = document.getElementById('cons_s_1_f_1').value;
			var sem_2_f_1 = document.getElementById('sem_2_f_1').value;
			var cons_s_2_f_1 = document.getElementById('cons_s_2_f_1').value;
			var sem_1_f_2 = document.getElementById('sem_1_f_2').value;
			var cons_s_1_f_2 = document.getElementById('cons_s_1_f_2').value;
			var sem_2_f_2 = document.getElementById('sem_2_f_2').value;
			var cons_s_2_f_2 = document.getElementById('cons_s_2_f_2').value;
			var sem_1_f_3 = document.getElementById('sem_1_f_3').value;
			var cons_s_1_f_3 = document.getElementById('cons_s_1_f_3').value;
			var sem_2_f_3 = document.getElementById('sem_2_f_3').value;
			var cons_s_2_f_3 = document.getElementById('cons_s_2_f_3').value;
			var sem_3_f_3 = document.getElementById('sem_3_f_3').value;
			var cons_s_3_f_3 = document.getElementById('cons_s_3_f_3').value;
			
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
		          <th>Año destete</th>
		            <td>${year_destete}</td>
		        </tr>
		        <tr>
		          <th>Semana Destete</th>
		            <td>${semana_destete}</td>
		        </tr>
		        <tr>
		          <th>Cant Destetos</th>
		            <td>${cant_destetos}</td>
		        </tr>
		        <tr>
		          <th>Traslado Ceba</th>
		            <td>${traslado_ceba}</td>
		        </tr>
		        <tr>
		          <th>Año Venta</th>
		            <td>${a_venta.value}</td>
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
			  var url = "http://201.236.212.130:82/intranetcercafe/public/admin/destetosSemana";
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