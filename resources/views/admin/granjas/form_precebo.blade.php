@extends('template.plantilla')
@section('content')
	<title>Precebo | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 30px;" align="center"><i class="fa fa-plus-square" aria-hidden="true"></i><strong> Formulario Precebo</strong></h4>
		</div> 
		<div class="panel-body">
			{!!Html::script('js/operandos-precebo.js')!!}   
			{!!Form::open(['route'=> 'admin.precebos.store', 'id'=>'fechas', 'method'=>'POST', 'name'=>'formularioPrece'])!!}
				<div class="row"> 
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('lote', 'Lote: ', ['class'=>'control-label'])!!}
						{!!Form::text('lote', null, ['class'=>'form-control', 'id'=>'loteId' , 'placeholder' => '###', 'required'])!!} 
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('granja', 'Granja: ', ['class'=>'control-label'])!!}
						<select name="granja" class="form-control" id="gr" onchange="pesoConsumo();" required>
							<option>Seleccione... </option>
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
						{!!Form::label('granja_cria', 'Granja de Cría: ', ['class'=>'control-label'])!!}
						<select  name="granja_cria" class="form-control" id="gr" required>
							<option value="">Seleccione... </option>
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
						{!!Form::label('f_destete', 'Fecha de Destete: ', ['class'=>'control-label'])!!}
						{!!Form::text('f_destete',null, ['id'=>'fecha_destete','class'=>'form-control', 'required','onChange'=>'fechasDeAccion();', 'style' => 'cursor: pointer !important;', 'readonly', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('f_traslado', 'Fecha de Traslado: ', ['class'=>'control-label'])!!}
						{!!Form::text('f_traslado',null, ['id'=>'fecha_traslado','class'=>'form-control', 'required','onChange'=>'fechasDeAccion();', 'style' => 'cursor: pointer !important;', 'readonly', 'required'])!!}
					</div>

					{!!Form::hidden('semana_destete', null, ['id'=>'s_destete','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('semana_traslado', null, ['id'=>'s_traslado','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('año_destete', null, ['id'=>'año_destete','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('año_traslado', null, ['id'=>'año_trlado','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('mes_traslado', null, ['id'=>'mes_trlado','class'=>'form-control', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('no_inicial', '# Inicial: ', ['class'=>'control-label'])!!}
						{!!Form::number('no_inicial',null, ['id'=>'numero_inicial','class'=>'form-control', 'placeholder' => '# inicial', 'required','onChange'=>'edadesCalculo(); porcentajeForm(); pesoConsumo();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('edad_destete', 'Edad de Destete: ', ['class'=>'control-label'])!!}
						<i class="advertencia fa fa-exclamation-circle btn-sm pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Este campo generalmente es decimal, ingresar la Información con '.'(punto) y EVITANDO la ','(coma). "></i>
						{!!Form::text('edad_destete',null, ['id'=>'ed_destete','class'=>'form-control', 'placeholder' => 'edad', 'required','onChange'=>'edadesCalculo();'])!!}

					</div>
					{!!Form::hidden('edad_inicial_total',null, ['id'=>'ed_total','class'=>'form-control', 'readonly'])!!}
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('dias_jaulon', 'Dias Jaulon: ', ['class'=>'control-label'])!!}
						<i class="advertencia fa fa-exclamation-circle btn-sm pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Este campo generalmente es decimal, ingresar la Información con '.'(punto) y EVITANDO la ','(coma). "></i>
						{!!Form::text('dias_jaulon',null, ['id'=>'dias_jlon','class'=>'form-control', 'placeholder' => 'dias', 'required', 'onChange'=>'edadesCalculo(); pesoConsumo();'])!!}
					</div>
 
					{!!Form::hidden('dias_totales',null, ['id'=>'dias_perm','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('edad_final',null, ['id'=>'ed_final','class'=>'form-control', 'onChange'=>'pesoConsumo();', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('numero_muertes', '# Muertes: ', ['class'=>'control-label'])!!}
						{!!Form::number('numero_muertes',null, ['id'=>'n_muertes','class'=>'form-control', 'placeholder' => '#', 'required','onChange'=>'porcentajeForm();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('numero_descartes', '# Descartes: ', ['class'=>'control-label'])!!}
						{!!Form::number('numero_descartes',null, ['id'=>'n_descartes','class'=>'form-control', 'placeholder' => '#', 'required','onChange'=>'porcentajeForm();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('numero_livianos', '# Livianos: ', ['class'=>'control-label'])!!}
						{!!Form::number('numero_livianos',null, ['id'=>'n_livianos','class'=>'form-control', 'placeholder' => '#', 'required','onChange'=>'porcentajeForm();'])!!}
					</div>

					{!!Form::hidden('numero_final',null, ['id'=>'nu_final','class'=>'form-control', 'readonly','onChange'=>'pesoConsumo();'])!!}
                    {!!Form::hidden('por_mortalidad',null, ['id'=>'mortalidad','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('por_descartes',null, ['id'=>'descartes','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('por_livianos',null, ['id'=>'livianos','class'=>'form-control', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('peso_ini', 'Peso TOTAL Inicial: ', ['class'=>'control-label'])!!}
						{!!Form::text('peso_ini',null, ['id'=>'p_inicial','class'=>'form-control', 'placeholder' => 'kg', 'required','onChange'=>'pesoConsumo();'])!!}
					</div>

					{!!Form::hidden('peso_promedio_ini',null, ['id'=>'p_promedio_ini','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('peso_ponderado_ini',null, ['id'=>'p_ponderado_ini','class'=>'form-control', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('peso_fin', 'Peso TOTAL Final: ', ['class'=>'control-label'])!!}
						{!!Form::text('peso_fin',null, ['id'=>'p_final','class'=>'form-control', 'placeholder' => 'kg', 'required','onChange'=>'pesoConsumo();'])!!}
					</div>

					{!!Form::hidden('peso_promedio_fin',null, ['id'=>'p_promedio_fin','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('peso_ponderado_fin',null, ['id'=>'p_ponderado_fin','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('ind_peso_final',null, ['id'=>'ind_p_f','class'=>'form-control', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('cons_total', 'Consumo Total: ', ['class'=>'control-label'])!!}
						{!!Form::number('cons_total',null, ['id'=>'consumo_total','class'=>'form-control', 'placeholder' => 'consumo', 'required','onChange'=>'pesoConsumo();'])!!}
					</div>

					{!!Form::hidden('cons_promedio',null, ['id'=>'consumo_promedio','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('cons_ponderado',null, ['id'=>'consumo_ponderado','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('cons_promedio_dia',null, ['id'=>'consumo_promedio_dia','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('cons_promedio_ini',null, ['id'=>'consumo_promedio_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('cons_ponderado_ini',null, ['id'=>'consumo_ponderado_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('cons_promedio_dia_ini',null, ['id'=>'consumo_promedio_dia_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('cons_ajustado_ini',null, ['id'=>'consumo_ajustado_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('ato_promedio_ini',null, ['id'=>'ato_promedio_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('ato_promedio_dia_ini',null, ['id'=>'ato_promedio_dia_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('conversion_ini',null, ['id'=>'conversion_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('conversion_ajust_ini',null, ['id'=>'conversion_ajustada_inicial','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('cons_ajustado_fin',null, ['id'=>'cons_ajustado_final','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('ato_promedio_fin',null, ['id'=>'ato_promedio_final','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('ato_promedio_dia_fin',null, ['id'=>'ato_promedio_dia_final','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('conversion_fin',null, ['id'=>'conversion_final','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('conversion_ajust_fin',null, ['id'=>'conversion_ajustada_final','class'=>'form-control', 'readonly'])!!}

					<div class="form-group col-lg-12 col-xs-12">
						<ul class="list-inline" align="center">
							<li><a href="javascript:history.go(-1);" class="btn btn-danger btn-md">Cancelar</a></li>
							<li>{!!Form::submit('Registrar Información', array('class'=>'btn btn-success btn-md', 'id'=>'btnSend'))!!}</li>
						</ul>
					</div>
				</div>
			{!! Form::close() !!} 
		</div>
	</div>


<script type="text/javascript">
	$(document).ready(function() {
		var formulario = document.getElementById('fechas');
		formulario.addEventListener('submit', e=> 
		{
			e.preventDefault();
			var semana_destete = document.getElementById('s_destete').value;
			var lote = document.getElementById('loteId').value;
			var fecha_destete = document.getElementById('fecha_destete').value;
			var fecha_traslado = document.getElementById('fecha_traslado').value;
			var semana_traslado = document.getElementById('s_traslado').value;
			var year_destete = document.getElementById('año_destete').value;
			var year_traslado = document.getElementById('año_trlado').value;
			var mes_traslado = document.getElementById('mes_trlado').value;
			var numero_inicial = document.getElementById('numero_inicial').value;
			var edad_destete = document.getElementById('ed_destete').value;
			var edad_inicial_total = document.getElementById('ed_total').value;
			var dias_jaulon = document.getElementById('dias_jlon').value;
			var dias_totales_permanencia = document.getElementById('dias_perm').value;
			var edad_final = document.getElementById('ed_final').value;
			var numero_muertes = document.getElementById('n_muertes').value;
			var numero_descartes = document.getElementById('n_descartes').value;
			var numero_livianos = document.getElementById('n_livianos').value;
			var numero_final = document.getElementById('nu_final').value;
			var porciento_mortalidad = document.getElementById('mortalidad').value;
			var porciento_descartes = document.getElementById('descartes').value;
			var porciento_livianos = document.getElementById('livianos').value;
			var peso_inicial = document.getElementById('p_inicial').value;
			var peso_promedio_inicial = document.getElementById('p_promedio_ini').value;
			var peso_ponderado_ini = document.getElementById('p_ponderado_ini').value;
			var peso_fin = document.getElementById('p_final').value;
			var peso_promedio_fin = document.getElementById('p_promedio_fin').value;
			var peso_ponderado_fin = document.getElementById('p_ponderado_fin').value;
			var ind_peso_final = document.getElementById('ind_p_f').value;
			var consumo_total = document.getElementById('consumo_total').value;
			var consumo_promedio = document.getElementById('consumo_promedio').value;
			var consumo_ponderado = document.getElementById('consumo_ponderado').value;
			var consumo_promedio_dia = document.getElementById('consumo_promedio_dia').value;
			var consumo_promedio_inicial = document.getElementById('consumo_promedio_inicial').value;
			var consumo_ponderado_inicial = document.getElementById('consumo_ponderado_inicial').value;
			var consumo_promedio_dia_inicial = document.getElementById('consumo_promedio_dia_inicial').value;
			var consumo_ajustado_inicial = document.getElementById('consumo_ajustado_inicial').value;
			var aumento_promedio_inicial = document.getElementById('ato_promedio_inicial').value;
			var aumento_promedio_dia_inicial = document.getElementById('ato_promedio_dia_inicial').value;
			var conversion_inicial = document.getElementById('conversion_inicial').value;
			var conversion_ajustada_inicial = document.getElementById('conversion_ajustada_inicial').value;
			var consumo_ajustado_fin = document.getElementById('cons_ajustado_final').value;
			var aumento_promedio_fin = document.getElementById('ato_promedio_final').value;
			var aumento_promedio_dia_fin = document.getElementById('ato_promedio_dia_final').value;
			var conversion_fin = document.getElementById('conversion_final').value;
			var conversion_ajustada_fin = document.getElementById('conversion_ajustada_final').value;
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
					          	<th>Semana Destete</th>
					            <td>${semana_destete}</td>
					        </tr>
					        <tr>
					          	<th>Fecha Destete</th>
					            <td>${fecha_destete}</td>
					        </tr>
					        <tr>
					          	<th>Fecha Traslado</th>
					            <td>${fecha_traslado}</td>
					        </tr>
					        <tr>
					          	<th>Semana Traslado</th>
					            <td>${semana_traslado}</td>
					        </tr>
					        <tr>
					          	<th>Año Destete</th>
					            <td>${year_destete}</td>
					        </tr>
					        <tr>
					          	<th>Año Traslado</th>
					            <td>${year_traslado}</td>
					        </tr>
					        <tr>
					          	<th>Mes Traslado</th>
					            <td>${mes_traslado}</td>
					        </tr>
					        <tr>
					            <th># Inicial</th>
					            <td>${numero_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Edad Destete</th>
					            <td>${edad_destete}</td>
					        </tr>
					        <tr>
					          	<th>Dias Jaulon</th>
					            <td>${dias_jaulon}</td>
					        </tr>
					        <tr>
					          	<th>Dias permanencia</th>
					            <td>${dias_totales_permanencia}</td>
					        </tr>
					        <tr>
					          	<th>Edad Final</th>
					            <td>${edad_final}</td>
					        </tr>
					        <tr>
					          	<th># Muertes</th>
					            <td>${numero_muertes}</td>
					        </tr>
					        <tr>
					          	<th># Descartes</th>
					            <td>${numero_descartes}</td>
					        </tr>
					        <tr>
					          	<th># Livianos</th>
					            <td>${numero_livianos}</td>
					        </tr>
					        <tr>
					          	<th># Final</th>
					            <td>${numero_final}</td>
					        </tr>
					        <tr>
					          	<th>% Mortalidad</th>
					            <td>${porciento_mortalidad}</td>
					        </tr>
					        <tr>
					          	<th>% Descartes</th>
					            <td>${porciento_descartes}</td>
					        </tr>
					        <tr>
					          	<th>% Livianos</th>
					            <td>${porciento_livianos}</td>
					        </tr>
					        <tr>
					          	<th>Peso inicial</th>
					            <td>${peso_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Peso Promedio Inicial</th>
					            <td>${peso_promedio_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Peso Fin</th>
					            <td>${peso_fin}</td>
					        </tr>
					        <tr>
					          	<th>Peso Promedio Fin</th>
					            <td>${peso_promedio_fin}</td>
					        </tr>
					        <tr>
					          	<th>Ind Peso Final</th>
					            <td>${ind_peso_final}</td>
					        </tr>
					         <tr>
					          	<th>Consumo Total</th>
					            <td>${consumo_total}</td>
					        </tr>
					        <tr>
					          	<th>Cons Promedio</th>
					            <td>${consumo_promedio}</td>
					        </tr>
					        <tr>
					          	<th>Cons Ponderado</th>
					            <td>${consumo_ponderado}</td>
					        </tr>
					        <tr>
					          	<th>Cons Promedio Día</th>
					            <td>${consumo_promedio_dia}</td>
					        </tr>
					        <tr>
					          	<th>Cons Promedio Inicial</th>
					            <td>${consumo_promedio_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Cons Promedio Día Inicial</th>
					            <td>${consumo_promedio_dia_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Cons Ajustado Inicial</th>
					            <td>${consumo_ajustado_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Ato Promedio Inicial</th>
					            <td>${aumento_promedio_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Ato Promedio Día Inicial</th>
					            <td>${aumento_promedio_dia_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Conv Inicial</th>
					            <td>${conversion_inicial}</td>
					        </tr>
					        <tr>
					          	<th>Conv Ajustada Inicial</th>
					            <td>${conversion_ajustada_inicial}</td>
					        </tr>
					         <tr>
					          	<th>Cons Ajustado Fin</th>
					            <td>${consumo_ajustado_fin}</td>
					        </tr>
					         <tr>
					          	<th>Ato Promedio Fin Mortalidad</th>
					            <td>${aumento_promedio_fin}</td>
					        </tr>
					         <tr>
					          	<th>Ato Promedio Día Fin Mortalidad</th>
					            <td>${aumento_promedio_dia_fin}</td>
					        </tr>
					        <tr>
					          	<th>Conv Fin</th>
					            <td>${conversion_fin}</td>
					        </tr>
					         <tr>
					          	<th>Conv Ajustada Fin</th>
					            <td>${conversion_ajustada_final.value}</td>
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
			   	var url = "http://201.236.212.130:82/intranetcercafe/public/admin/precebos";
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
							$('#gr').append('<option value="" selected="selected">Seleccione... </option>');
							$("#fechas")[0].reset();        
							// 	Swal({
							//   type: 'warning',
							//   title: 'Oops... Proceso de mantenimiento',
							//   text: 'Ocurrió un error!',
							// })
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