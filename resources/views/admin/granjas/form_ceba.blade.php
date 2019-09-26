@extends('template.plantilla')
@section('content')
	<title>Ceba | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;" align="center"><i class="fa fa-plus-square" aria-hidden="true"></i><strong> Formulario Ceba</strong></h4>
		</div>
		<div class="panel-body">
			{!!Html::script('js/operandos.js')!!}
			{!!Form::open(['route'=> 'admin.cebas.store','id'=>'fechas', 'method'=>'POST', 'name'=>'formularioPrece'])!!}
				<div class="row">
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('lote', 'Lote: ', ['class'=>'control-label'])!!}
						{!!Form::text('lote', null, ['class'=>'form-control', 'id'=>'loteId', 'placeholder' => '###', 'required'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('gran', 'Granja: ', ['class'=>'control-label'])!!}
						<select name="granja" class="form-control" id="gr" onchange="totalCerdos();" required>
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
						{!!Form::label('granja_cria', 'Granja de Cria: ', ['class'=>'control-label'])!!}
						<select name="granja_cria" class="form-control" id="gr" required>
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
						{!!Form::label('granja_precebo', 'Granja de Precebo: ', ['class'=>'control-label'])!!}
						<select name="granja_precebo" class="form-control" id="gr" required>
							<option>Seleccione...</option>
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
						{!!Form::label('fecha_ingreso_granja', 'Fecha de Ingreso: ', ['class'=>'control-label'])!!}
						{!!Form::text('fecha_ingreso_granja',null, ['id'=>'fecha_ingreso','class'=>'form-control', 'required','onChange'=>'calcularFechas();', 'style' => 'cursor: pointer !important;', 'readonly'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('fecha_salida_granja', 'Fecha de Salida: ', ['class'=>' control-label'])!!}
						{!!Form::text('fecha_salida_granja',null, ['id'=>'fecha_salida','class'=>'form-control', 'required','onChange'=>'calcularFechas();', 'style' => 'cursor: pointer !important;', 'readonly'])!!}
					</div>

					{!!Form::hidden('año', null, ['id'=>'año','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('mes', null, ['id'=>'mes','class'=>'form-control', 'readonly'])!!}
                    {!!Form::hidden('semana', null, ['id'=>'semana','class'=>'form-control', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('cant_cerdos_lote', '# INIC: ', ['class'=>'control-label'])!!}
						{!!Form::number('cant_cerdos_lote',null, ['id'=>'cerdos_ingresados','class'=>'form-control', 'placeholder' => 'cantidad', 'required','onChange'=>'totalCerdos(); diasPermanencia();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('cant_cerdos_descartados', 'Cerdos descartados: ', ['class'=>'control-label'])!!}
						{!!Form::number('cant_cerdos_descartados',null, ['id'=>'cerdos_descartados','class'=>'form-control', 'placeholder' => 'cantidad', 'required','onChange'=>'totalCerdos();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('cant_cerdos_livianos', 'Cerdos livianos: ', ['class'=>'control-label'])!!}
						{!!Form::number('cant_cerdos_livianos',null, ['id'=>'cerdos_livianos','class'=>'form-control', 'placeholder' => 'cantidad', 'required','onChange'=>'totalCerdos();'])!!}
					</div>
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('cant_cerdos_muertos', 'Muertes: ', ['class'=>'control-label'])!!}
						{!!Form::number('cant_cerdos_muertos',null, ['id'=>'muertes','class'=>'form-control', 'placeholder' => 'cantidad', 'required','onChange'=>'totalCerdos();'])!!}
					</div>

					{!!Form::hidden('cant_cerdos_finales',null, ['id'=>'cerdos_finales','class'=>'form-control', 'placeholder' => 'cantidad final', 'readonly', 'onChange'=>'diasPermanencia();'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('edad_inicial', 'Edad inicial: ', ['class'=>'control-label'])!!}
						<i class="advertencia fa fa-exclamation-circle btn-sm pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Este campo generalmente es decimal, ingresar la Información con '.'(punto) y EVITANDO la ','(coma)."></i>
						{!!Form::text('edad_inicial',null, ['id'=>'edad_inicial_c','class'=>'form-control', 'placeholder' => 'Edad', 'required','onChange'=>'diasPermanencia();'])!!}
					</div>

					 {!!Form::hidden('edad_inicial_total',null, ['id'=>'edad_total_inicial','class'=>'form-control', 'placeholder' => 'days', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('dias_granja', 'Dias de Permanencia Etapa: ', ['class'=>'control-label'])!!}
						<i class="advertencia fa fa-exclamation-circle btn-sm pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Este campo generalmente es decimal, ingresar la Información con '.'(punto) y EVITANDO la ','(coma)."></i>
						{!!Form::text('dias_granja',null, ['id'=>'dias','class'=>'form-control', 'placeholder' => 'Dias', 'required','onChange'=>'diasPermanencia();'])!!}
					</div>

					{!!Form::hidden('dias_permanencia_total',null, ['id'=>'dias_perm_granja','class'=>'form-control', 'placeholder' => 'permanent days', 'readonly','onChange'=>'totalCerdos();'])!!}
                    {!!Form::hidden('edad_final',null, ['id'=>'edad_final_cerdos','class'=>'form-control', 'placeholder' => 'final days', 'readonly'])!!}
                    {!!Form::hidden('edad_final_total',null, ['id'=>'edad_final_cerdos_total','class'=>'form-control', 'placeholder' => 'final days', 'readonly'])!!}

					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('conf_edad_final', 'Conf edad final: ', ['class'=>'control-label'])!!}
						<select name="conf_edad_final" class='form-control' required="required">
                            <option value="si" >SI</option>
                            <option value="no" >NO</option>
                        </select>
					</div>

					{!!Form::hidden('mortalidad',null, ['id'=>'por_mortalidad','class'=>'form-control', 'placeholder' => '%', 'readonly'])!!}
                    {!!Form::hidden('descartados',null, ['id'=>'por_descarte','class'=>'form-control', 'placeholder' => '%', 'readonly'])!!}
                    {!!Form::hidden('livianos',null, ['id'=>'por_livianos','class'=>'form-control', 'placeholder' => '%', 'readonly'])!!}
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('peso_cerdos_ingresados', 'Peso Total de Cerdos Ingresados: ', ['class'=>'control-label'])!!}
						{!!Form::text('peso_cerdos_ingresados',null, ['id'=>'peso_ingresado','class'=>'form-control', 'placeholder' => 'Kg', 'required', 'onChange'=>'totalCerdos();'])!!}
					</div>
					{!!Form::hidden('peso_promedio_cerdos_ingresados',null, ['id'=>'peso_promedio_ingresado','class'=>'form-control', 'placeholder' => 'X', 'readonly'])!!}
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('peso_cerdos_vendidos', 'Peso Total de Cerdos Vendidos: ', ['class'=>'control-label'])!!}
						{!!Form::text('peso_cerdos_vendidos',null, ['id'=>'peso_vendido','class'=>'form-control', 'placeholder' => 'Kg', 'required', 'onChange'=>'totalCerdos();'])!!}
					</div>
					{!!Form::hidden('peso_promedio_cerdos_vendidos',null, ['id'=>'peso_promedio_vendido','class'=>'form-control', 'placeholder' => 'X', 'readonly'])!!}
					<div class="form-group col-lg-6 col-xs-12">
						{!!Form::label('consumo_lote', 'Consumo Lote: ', ['class'=>'control-label'])!!}
						{!!Form::number('consumo_lote',null, ['id'=>'lote_consumo','class'=>'form-control', 'placeholder' => 'Kg', 'required', 'onChange'=>'totalCerdos();'])!!}
					</div>

					{!!Form::hidden('consumo_promedio',null, ['id'=>'promedio_consumo','class'=>'form-control', 'placeholder' => 'X', 'readonly'])!!}
                    {!!Form::hidden('consumo_promedio_dias',null, ['id'=>'dias_promedio_consumo','class'=>'form-control', 'placeholder' => 'X', 'readonly'])!!}
                    {!!Form::hidden('cons_promedio_ini',null, ['id'=>'consumo_promedio_inicial','class'=>'form-control', 'readonly'])!!}
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
							<li><a href="javascript:history.go(-1);" class="btn btn-danger">Cancelar</a></li>
							<li> {!!Form::submit('Registrar Información', array('class'=>'btn btn-success btn-md'))!!}</li>
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

			if(document.getElementById('fecha_ingreso').value.length > 0 && document.getElementById('fecha_salida').value.length > 0){
				var fecha_ingreso = document.getElementById('fecha_ingreso').value;
				var fecha_salida = document.getElementById('fecha_salida').value;
			}else{
				Swal({
					type: 'error',
					title: 'Oops...',
					text: 'No haz especificado un rango de fechas!',
				})
				
				e.preventDefault();
				return false;
			}
			var year = document.getElementById('año').value;
			var mes = document.getElementById('mes').value;
			var semana = document.getElementById('semana').value;
			var inic = document.getElementById('cerdos_ingresados').value;
			var cerdos_descartados = document.getElementById('cerdos_descartados').value;
			var cerdos_livianos = document.getElementById('cerdos_livianos').value;
			var muertes = document.getElementById('muertes').value;
			var cantidad_final_cerdos = document.getElementById('cerdos_finales').value;
			var edad_inicial = document.getElementById('edad_inicial_c').value;
			var edad_inicial_total = document.getElementById('edad_total_inicial').value;
			var dias = document.getElementById('dias').value;
			var dias_permanencia = document.getElementById('dias_perm_granja').value;
			var edad_final = document.getElementById('edad_final_cerdos').value;
			var edad_final_total = document.getElementById('edad_final_cerdos_total').value;
			var porciento_mortalidad = document.getElementById('por_mortalidad').value;
			var porciento_descartes = document.getElementById('por_descarte').value;
			var porciento_livianos = document.getElementById('por_livianos').value;
			var peso_ingresado = document.getElementById('peso_ingresado').value;
			var peso_promedio_ingresado = document.getElementById('peso_promedio_ingresado').value;
			var peso_cerdo_vendidos = document.getElementById('peso_vendido').value;
			var peso_promedio_vendido = document.getElementById('peso_promedio_vendido').value;
			var consumo_lote = document.getElementById('lote_consumo').value;
			var consumo_promedio_lote = document.getElementById('promedio_consumo').value;
			var consumo_promedio_lote_dia = document.getElementById('dias_promedio_consumo').value;
			var cons_promedio_ini = document.getElementById('consumo_promedio_inicial').value;
			var cons_promedio_dia_ini = document.getElementById('consumo_promedio_dia_inicial').value;
			var cons_ajustado_ini = document.getElementById('consumo_ajustado_inicial').value;
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
		          <th>F. Ingreso</th>
		            <td>${fecha_ingreso}</td>
		        </tr>
		        <tr>
		          <th>F. Salida</th>
		            <td>${fecha_salida}</td>
		        </tr>
		        <tr>
		          <th>Año</th>
		            <td>${year}</td>
		        </tr>
		         <tr>
		          <th>Mes</th>
		            <td>${mes}</td>
		        </tr>
		         <tr>
		          <th>Semana</th>
		            <td>${semana}</td>
		        </tr>
		         <tr>
		          <th># Inicial</th>
		            <td>${inic}</td>
		        </tr>
		         <tr>
		          <th>C. Descartados</th>
		            <td>${cerdos_descartados}</td>
		        </tr>
		         <tr>
		          <th>C. Livianos</th>
		            <td>${cerdos_livianos}</td>
		        </tr>
		         <tr>
		          <th>Muertes</th>
		            <td>${muertes}</td>
		        </tr>
		         <tr>
		          <th>C. Final Cerdos</th>
		            <td>${cantidad_final_cerdos}</td>
		        </tr>
		         <tr>
		          <th>Edad Inicial</th>
		            <td>${edad_inicial}</td>
		        </tr>
		         <tr>
		          <th>Dias Jaulon</th>
		            <td>${dias}</td>
		        </tr>
		         <tr>
		          <th>Dias Permanencia</th>
		            <td>${dias_permanencia}</td>
		        </tr>
		         <tr>
		          <th>Edad Final</th>
		            <td>${edad_final}</td>
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
		          <th>Peso Total Ingresado</th>
		            <td>${peso_ingresado}</td>
		        </tr>
		         <tr>
		          <th>Peso Promedio Ingresado</th>
		            <td>${peso_promedio_ingresado}</td>
		        </tr>
		         <tr>
		          <th>Peso Total Vendido</th>
		            <td>${peso_vendido.value}</td>
		        </tr>
		         <tr>
		          <th>Peso Promedio Vendido</th>
		            <td>${peso_promedio_vendido}</td>
		        </tr>
		         <tr>
		          <th>Consumo Lote</th>
		            <td>${consumo_lote}</td>
		        </tr>
		         <tr>
		          <th>Consumo Prom Lote Fin</th>
		            <td>${consumo_promedio_lote}</td>
		        </tr>
		         <tr>
		          <th>Consumo Prom Lote * Dia</th>
		            <td>${consumo_promedio_lote_dia}</td>
		        </tr>
		         <tr>
		          <th>Consumo Prom Ini</th>
		            <td>${cons_promedio_ini}</td>
		        </tr>
		         <tr>
		          <th>Consumo Prom Dia</th>
		            <td>${cons_promedio_dia_ini}</td>
		        </tr>
		         <tr>
		          <th>Consumo Ajustado</th>
		            <td>${cons_ajustado_ini}</td>
		        </tr>
		           <tr>
		          <th>Aumento Prom Ini</th>
		            <td>${aumento_promedio_inicial}</td>
		        </tr>
		           <tr>
		          <th>Aumento Prom Dia</th>
		            <td>${aumento_promedio_dia_inicial}</td>
		        </tr>
		         <tr>
		          <th>Conversion Ini</th>
		            <td>${conversion_inicial}</td>
		        </tr>
		         <tr>
		          <th>Conversion Ajustada</th>
		            <td>${conversion_ajustada_inicial}</td>
		        </tr>
		         <tr>
		          <th>Conversion Ajust Fin</th>
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
		}).then((result) => {
		  if (result.value) {
		   	 	var url = "http://201.236.212.130:82/intranetcercafe/public/admin/cebas";
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
							$("#fechas")[0].reset();
			           },
			           error: function(err){
						   var response = err.responseText;
						   var value = response.substring(0,19);

						   if(value == "Ya existe uno Igual"){
			  					Swal({
									  type: 'error',
									  title: 'Lote ya creado',
									  text: 'Ya existe este lote en esta fecha',
									})
						   }else{
								Swal({
							  		type: 'error',
							  		title: 'Oops...',
							  		text: 'Ocurrió un error!',
								})
						   }
						//console.log();

						//if(result.value )
						  //console.log(result.value);

			           }

			   	});
		  }
		})
		});
	})
</script>



@endsection