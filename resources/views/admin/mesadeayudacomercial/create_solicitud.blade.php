@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Crear Solicitud</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-envelope" aria-hidden="true"></i> Reportar Queja o Reclamo</h4>
		</div>
		<div class="panel-body">
			{!!Form::open(['route'=> 'admin.solicitudComercio.store', 'method' => 'POST' ,'files' => true, 'enctype' => 'multipart/form-data','autocomplete'=>'on'])!!}
				@foreach($users as $user)
					@if(Auth::User()->id == $user->id)
						<fieldset>
							<div class="row">
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('agente', 'Correo a Enviar: ', ['class' => 'control-label']) !!}
									<select name="agente[]" id="agente" class="form-control" multiple>
										<option value=""></option>
										<option>desarrollotic@cercafe.com.co</option>
										<option>asenasistemas@cercafe.com.co</option>
										<option>auxsistemas@cercafe.com.co</option>
										<option>direccionmejoramiento@cercafe.com.co</option>
										<option>gerenciacomercial@cercafe.com.co</option>
										<option>comercial@cercafe.com.co</option>
										<option>admincomercial@cercafe.com.co</option>
										<option>direccioncomercial@cercafe.com.co</option>
										<option>controller@cercafe.com.co</option>
										<option>mercadeo@cercafe.com.co</option>
										<option>infolomus@cercafe.com.co</option>
										<option>coortecnica@cercafe.com.co</option>
										<option>puntodeventa1@cercafe.com.co</option>
										<option>servicioalcliente@cercafe.com.co</option>
									</select>
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('medio','Medio de Llegada:',['class'=>'control-label'])!!}
									<select name="medio" id="" class="form-control">
										<option>seleccione...</option>
										<option>WhatsApp</option>
										<option>Telefono</option>
										<option>Correo</option>
										<option>Verbal</option>
										<option>Pagina Web</option>
									</select>
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									<label for="">Categoria:</label>
									<select name="categoria" class="form-control" id="">
										<option>seleccione</option>
										<option>Hogar</option>
										<option>FoodService</option>
										<option>Mayoristas</option>
										<option>Canales</option>
									</select>
								</div>
		        				{{-- {!!Form::text('asunto', null, ['class'=>'form-control','placeholder'=>'...']) !!} --}}
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('nombre_completo','Nombre y Apellido o Razon del Cliente',['class'=>'control-label'])!!}
									{!!Form::text('nombre_completo',null,['class'=>'form-control','placeholder'=>'Nombre y Apellido','autocomplete'=>'name'])!!}
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('cedula','Cedula o Nit del Cliente:',['class'=>'control-label'])!!}
									{!!Form::text('cedula',null,['class'=>'form-control','placeholder'=>'Cedula', 'autocomplete'=>'on'])!!}
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('correo','Correo Electronico del Cliente:',['class'=>'control-label'])!!}
									{!!Form::text('correo',null,['class'=>'form-control','placeholder'=>'Correo Electronico' ,'autocomplete'=>'email', 'required' => 'required'])!!}
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('direccion','Dirección del Cliente:',['class'=>'control-label'])!!}
									{!!Form::text('direccion',null,['class' => 'form-control','placeholder'=>'Dirección', 'autocomplete'=>'address-line1'])!!}
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									<label class="control-label">Motivo de la Peticion,Queja,Reclamo o Sugerencia:</label>
									<select id="motivo" name="motivo" class="form-control">
										<option>Seleccione...</option>
										<option>Calidad del Producto</option>
										<option>Empaque</option>
										<option>Logistica de Despacho</option>
										<option>Atencion Personal</option>
										<option>Temperatura del Producto</option>
										<option>Falta de Inventario</option>
										<option>Tiempo de Entrega</option>
										<option>Incumplimiento Ficha Tecnica del Producto</option>
										<option>Otro</option>
									</select>
								</div>
								<div class="form-group col-lg-6 col-xs-12">
									{!!Form::label('telefono','Telefono del Cliente:',['class'=>'control-label'])!!}
									{!!Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Telefono', 'autocomplete'=>'tel-national','required'])!!}
								</div>
								<div class="form-group col-lg-6 col-xs-12" id="adicional">
									{!!Form::label('adicion','Digite el Otro Motivo:',['class'=>'control-label'])!!}
									{!!Form::text('adicion',null,['class'=>'form-control'])!!}
								</div>
								<div class="form-group col-lg-12 col-xs-12" id="descripcion">
									{!!Form::label('descripcion_solicitud', 'Descripción del Cliente: ', ['class'=>'control-label'])!!}
									{!!Form::textarea('descripcion_solicitud', null, ['class'=>'form-control', 'placeholder' => '...' , 'cols' => '10' , 'rows' => '10'])!!}
								</div>	
								<div class="form-group col-lg-12 col-xs-12 checkbox">
									<label><input type="checkbox" name=>Acepto <a href="#" data-toggle="modal" data-target="#myModal">Terminos y Condiciones</a></label>
								</div>	
								{!!Form::hidden('emisor_id',$user->id)!!}
								<input type="hidden" name="estado" class="form-control" value="1">
								<div class="form-group col-lg-12 col-xs-12">
									<div class="form-div">
										<label for="file" class="input-label control-label btn">
											<span id="label_span" data-toggle="tooltip" data-placement="right" title="Si Vas a Enviar Mas de dos Archivos Recomendamos Comprimirlo en un Archivo RAR,ZIP,etc..">Seleccione Archivo</span>
										</label>
										{!!Form::file('path',['id'=>'file','multiple'=>'true'])!!}
									</div>
								</div>	
								<input type="hidden" name="fecha_hora" readonly class="form-control">
								<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
								<input type="hidden" name="moderador" value="{{Auth::User()->nombre_completo}}">
								<input type="hidden" name="servicio" value="servicioalcliente@cercafe.com.co"> 
								<div class="form-group col-lg-7 col-xs-12">
									<ul class="list-inline pull-left">
										<a href="javascript:history.go(-1);" class="btn btn-danger">Cancelar</a>
										{!!Form::submit('Solicitar', array('id' => 'enviar_solicitud','class'=>'btn btn-success'))!!}
									</ul>
								</div>	
							</div>
						</fieldset>
					@endif
				@endforeach
			{!!Form::close()!!}
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" style="background: #DF0101;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<h4>De conformidad con lo definido por la Ley 1581 de 2012, el Decreto Reglamentario 1377 de 2013, la Circular Externa 002 de 2015 expedida por la Superintendencia de Industria y Comercio
					Autorizo de manera libre, voluntaria, previa, explícita,para que en los términos legalmente establecidos realice la recolección, almacenamiento, uso, circulación, supresión y en general, el tratamiento de los datos personales que he procedido a entregar o que entregaré, en virtud de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja, en desarrollo y ejecución de los fines descritos en el presente documento..</h4>
				</div>
				<div class="modal-footer" style="background: #DF0101;">
					<button type="button" class="btn btn-success" data-dismiss="modal">De Acuerdo</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$("#adicional").hide();

			$(document).on('change','#motivo',function (event) {
				if ($("#motivo option:selected").text() == 'Otro') {
					$("#adicional").show();
				}else{
					$("#adicional").hide();
				}
			})

			$("#file").on("change",function(e){
				var files = $ (this)[0].files;

				if(files.length >= 2){
					$("#label_span").text(files.length +" archivos selecionados ");

				}else{
					var filename =e.target.value.split('\\').pop();
					$("#label_span").text(filename);
				}
			});
			var d = new Date();
	        var m = d.getMonth() + 1;
	        var mes = (m < 10) ? '0' + m : m;
	        d = (d.getFullYear()+'-'+mes+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
	        // console.log(d);
	        $("[name='fecha_hora']").val(d);
	        $("#agente").select2({
	        	placeholder: "Agente/s",
        		allowClear: true
	        })
		})
	</script>
@endsection