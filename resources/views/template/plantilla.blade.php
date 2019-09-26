<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="http://static.wixstatic.com/media/c0bb3a_2d53d84381db411eb54649237b3598db%7Emv2.jpg/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/c0bb3a_2d53d84381db411eb54649237b3598db%7Emv2.jpg" type="image/jpeg"/>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="csrf-token" content="{{csrf_token()}}">

	{!!Html::style('media/css/bootstrap.css')!!}
	{!!Html::style('https://use.fontawesome.com/releases/v5.0.6/css/all.css')!!}
	{!!Html::style('media/css/font-awesome.min.css')!!}
	{!!Html::style('media/css/highcharts.css')!!}
	{!!Html::style('media/css/jquery-ui.min.css')!!}
	{!!Html::style('media/css/jquery-ui-timepicker-addon.min.css')!!}
	{!!Html::style('media/css/dataTables.foundation.min.css')!!}
	{!!Html::style('media/css/buttons.bootstrap.min.css')!!}
	{!!Html::style('media/css/buttons.foundation.min.css')!!}

	{!!Html::style('media/css/select2.css')!!}
	{!!Html::style('media/calendars/fullcalendar/fullcalendar.css') !!}
    {!!Html::style('media/calendars/MDpickertimer/mdtimepicker.css') !!}
	{!!Html::style('media/css/css.css')!!}
	{!!Html::style('media/css/style.css')!!}
	{!!Html::style('media/css/tabla_vertical.css')!!}

    {!!Html::script('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js')!!}
    {!!Html::script('js/moment-with-locales.min.js')!!}
  	{!!Html::script('js/jquery-ui.min.js')!!}
  	{!!Html::script('js/jquery-ui-timepicker-addon.min.js')!!}
  	{!!Html::script('js/jquery-ui-timepicker-es.js')!!}
	{!!Html::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js')!!}
    {!!Html::script('js/highcharts.js') !!}
    {!!Html::script('js/exporting.js') !!}
    {!!Html::script('js/export-csv.js') !!}
  	{!!Html::script('js/date_picker_es.js')!!}
  	{{-- Libreria JQuery datatables --}}
  	{!!Html::script('js/jquery.dataTables.js')!!}
  	{!!Html::script('js/dataTables.bootstrap.min.js')!!}
  	{!!Html::script('js/dataTables.buttons.min.js')!!}
  	{!!Html::script('js/buttons.bootstrap.min.js')!!}
  	{!!Html::script('js/pdfmake.min.js')!!}
  	{!!Html::script('js/buttons.flash.min.js')!!}
  	{!!Html::script('js/jszip.min.js')!!}
  	{!!Html::script('js/vfs_fonts.js')!!}
  	{!!Html::script('js/buttons.print.js')!!}
  	{!!Html::script('js/buttons.html5.min.js')!!}
  	{!!Html::script('js/select2.min.js')!!}
    {!!Html::script('media/calendars/fullcalendar/lib/moment.min.js') !!}
    {!!Html::script('media/calendars/fullcalendar/fullcalendar.js') !!}
    {!!Html::script('media/calendars/MDpickertimer/mdtimepicker.js') !!}
    {!!Html::script('media/calendars/fullcalendar/es.js') !!}
  	{!!Html::script('js/codigo.js')!!}
  	{!!Html::script('js/accion.js')!!}
  	{!!Html::script('js/fixed.js')!!}
  	{!!Html::script('js/generar_informes.js')!!}
  	{!!Html::script('js/granjas.js')!!}
	  {!!Html::script('js/sweetalert2.all.js')!!}

	  {{--Script para los pedidos adicionales en consultaConcentrados--}}
	  {!!Html::script('js/consultaConcentradosDecision.js')!!}
	<style>
		.dropdown-submenu {
		    position: relative;
		}

		.dropdown-submenu .dropdown-menu {
		    top: 0;
		    left: 100%;
		    margin-top: -1px;
		}

		canvas {
  		position: absolute;
  		top: 0;
  		left: 0;
 	 	z-index: 0;
		}

		body{
			overflow-x: hidden;
		}


		@media (max-width: 750px) {
		.navbar-default .navbar-nav .open .dropdown-menu > li > a {
			color: white !important;
			}
		}
	</style>
</head>
<body>
	<nav class=" navbar navbar-default nav_inicio">

		<div class="container-fluid">
			<div class="navbar-header">
				<a href="/intranetcercafe/public/admin/intranet" style="cursor: pointer;">{{Html::image('media/img/logocercafe.png', 'logo', array('class' => 'lo', 'width' => '100px', 'style' => 'margin-left: 10px; margin-top: 5px;'))}}</a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="sr-only"></span>
					<span class="icon-bar" style="background: white; "></span>
					<span class="icon-bar" style="background: white;"></span>
					<span class="icon-bar" style="background: white;"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					@if(Auth::User()->rol_id != 5 && Auth::User()->rol_id != 6)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-info-circle"></i><strong> PQRs </strong><span class="caret"></span></a>
							<ul class="dropdown-menu">
								@if(Auth::user()->agente == '1')
									<li><a href="{{route('admin.solicitudes.create')}}" id="menus"><i class="fa fa-at"></i><strong> Realizar Solicitudes</strong></a></li>
								@endif
								<li><a href="{{route('admin.solicitudes.index')}}" id="menus"><i class="fa fa-bars"></i> Listar Solicitudes</a></li>

								<li><a href="/intranetcercafe/public/admin/realizadas" id="menus"><i class="fa fa-clock" ></i> Solicitudes Enviadas</a></li>
								@if(Auth::user()->rol_id == 12 || Auth::User()->rol_id == 1 || Auth::user()->id == 18  || Auth::User()->id == 36 || Auth::User()->id == 32 || Auth::User()->id == 3 || Auth::User()->id == 60)
									<li>
										<a href="#" class="trigger right-caret" id="menus"><strong>PQRs Comercial</strong></a>
										<ul class="dropdown-menu sub-menu">
											<li><a href="{{route('admin.solicitudComercio.create')}} " id="menus"><i class="fa fa-at"></i> Reportar PQR</a></li>
											<li><a href="{{route('admin.solicitudComercio.index')}} " id="menus"><i class="fa fa-bars"></i> Listar Peticiones</a></li>
										</ul>
									</li>
								@endif
							</ul>
						</li>
					@endif
					<li class="dropdown">
						@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 3 || Auth::User()->rol_id == 9)
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-calendar-o"></i><strong> Bitacora </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li><a href="{{route('admin.bitacora.create')}}" id="menus"><i class="fa fa-cloud-upload" ></i> Subir Archivo</a></li>
								<li><a href="{{route('admin.bitacora.index')}}" id="menus"><i class="fa fa-cloud" ></i> Mi Bitácora</a></li>
							</ul>
						@endif
					</li>
					{{-- <li class="dropdown">
						@if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 6)
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-pie-chart" ></i><strong> PigWin </strong><span class="caret"></span></a>

							<ul class="dropdown-menu submenus">
								<li><a href="{{route('admin.copiaPigWin.create')}}" id="menus"><i class="fa fa-calendar-check-o" ></i> Subir Copia</a></li>
								<li><a href="{{route('admin.copiaPigWin.index')}}" id="menus"><i class="fa fa-database" ></i> BackUps</a></li>
							</ul>
						@endif
					</li> --}}
					<li class="dropdown">
						@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 9 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 8)
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-copy"></i><strong> Registros </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 9)
									<li><a href="{{ route('admin.concentrados.index') }}" id="menus"><i class="fa fa-filter"></i> Concentrados</a></li>
								@endif
									<li><a href="{{route('admin.granja.index')}}" id="menus"><i class="fa fa-industry" aria-hidden="true"></i> Granjas</a></li>
									<li><a href="{{ route('admin.vehiculos.index') }}" id="menus"><i class="fa fa-truck"></i> Vehiculos de Despacho</a></li>
									<li><a href="{{ route('admin.conductores.index') }}" id="menus"><i class="fa fa-user"></i> Conductores</a></li>
								@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 9)
									<li><a href="{{ route('admin.productoCia.index') }}" id="menus"><i class="fa fa-eye-dropper"></i> Productos CIA</a></li>
								@endif
								@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7 || Auth::User()->id == 23)
									<li><a href="{{ route('admin.medicamentos.index') }}" id="menus"><i class="fa fa-medkit"></i> Medicamentos</a></li>
									<li><a href="{{ route('admin.insumosServicios.index') }}" id="menus"><i class="fa fa-archive"></i> Insumos y Servicios</a></li>
								@endif
							</ul>
						@endif
					</li>
					@if(Auth::User()->rol_id == 1 ||  Auth::User()->rol_id == 6 || Auth::User()->rol_id == 5 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 11)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-industry"></i><strong> Granjas </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li><a href="{{route('admin.granjas.index')}}" id="menus"><i class="fa fa-folder-open"></i> Consultar</a></li>
								@if(Auth::User()->rol_id == 1 ||  Auth::User()->rol_id == 6 || Auth::User()->rol_id == 5 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10)
									<li><a href="{{ route('admin.granjas.create') }}" id="menus"><i class="fa fa-hdd"></i> Ingresar</a></li>
								@endif
							</ul>
						</li>
					@endif
					{{-- @if(Auth::User()->rol_id == 6 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 7 || Auth::User()->id == 36)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <strong>Disponibilidad</strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								@if(Auth::User()->rol_id == 6 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 7)
									<li><a href="{{route('admin.disponibilidad.create')}} " id="menus"><i class="fa fa-upload" aria-hidden="true"></i> Registrar Disponibilidad de Granjas</a></li>
								@endif
								@if(Auth::User()->rol_id == 7 || Auth::User()->id == 85 || Auth::User()->id == 36)
									<li><a href="{{route('admin.disponibilidad.index')}} " id="menus"><i class="fa fa-list" aria-hidden="true"></i> Listar Disponibilidad</a></li>
								@endif
							</ul>
						</li>
					@endif --}}
					<li class="dropdown">
						@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 5 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 6)
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <strong>Cercafé BI</strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li><a href="/intranetcercafe/public/admin/graficasgenerales" id="menus"><i class="fa fa-list" aria-hidden="true"></i> Informes</a></li>
								<!--<li><a href="/intranetcercafe/public/admin/graficasgranja" id="menus"><i class="fa fa-list" aria-hidden="true"></i> Granjas</a></li>-->
							</ul>
						@endif
					</li>
					@if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 5 || Auth::User()->rol_id == 10)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="far fa-newspaper"></i><strong> Informes </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li><a href="/intranetcercafe/public/admin/tabla_dinamica" id="menus">Precebo</a></li>
								<li><a href="/intranetcercafe/public/admin/tabla_dinamica_Ceba" id="menus">Ceba</a></li>
								<li><a href="/intranetcercafe/public/admin/GenerarInforme" id="menus">Informes Generales</a></li>
								<li><a href="/intranetcercafe/public/admin/ConsolidadoVista" id="menus">Consolidados</a></li>
							</ul>
						</li>
					@endif

					@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7)
						<!--<li class="dropdown">
							<a href="/intranetcercafe/public/admin/inventario"  id="menus"><i class="fa fa-file-excel"></i><strong> Archivos Planos </strong></a>
						</li>-->
					@elseif(Auth::User()->area_id == 2)
						<!--<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-shopping-cart"></i><strong> M. Continuo </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li>
									<ul class="dropdown-menu sub-menu">
										<li><a href="#" id="menus"> Existencia Medicamentos</a></li>
									</ul>
								</li>
								<li><a href="/intranetcercafe/public/admin/inventario" id="menus"><i class="fa fa-hdd"></i> Subir Datos</a></li>
							</ul>
						</li>-->
					@elseif(Auth::User()->area_id == 7)
						<!--<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-shopping-cart"></i><strong> Compras </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li>
									<ul class="dropdown-menu sub-menu">
										<li><a href="#" id="menus"> Existencia Medicamentos</a></li>
									</ul>
								</li>
								<li><a href="/intranetcercafe/public/admin/inventario" id="menus"><i class="fa fa-hdd"></i> Subir Datos</a></li>
							</ul>
						</li>-->
					@elseif(Auth::User()->area_id == 10)
						<!--<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fas fa-file-archive"></i><strong> T. Humano </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li>

									<ul class="dropdown-menu sub-menu">
										<li><a href="#" id="menus"> Colaboradores</a></li>
									</ul>
								</li>
								<li><a href="/intranetcercafe/public/admin/inventario" id="menus"><i class="fa fa-hdd"></i> Subir Datos</a></li>
							</ul>
						</li>-->

						@elseif(Auth::User()->rol_id == 11 || Auth::User()->area_id == 9)
							<!--<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fas fa-file-archive"></i><strong> Planta De Concentrados </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li>

									<ul class="dropdown-menu sub-menu">
										<li><a href="#" id="menus"> Valor Final Inventario</a></li>
									</ul>
								</li>
								<li><a href="/intranetcercafe/public/admin/inventario" id="menus"><i class="fa fa-hdd"></i> Subir Datos</a></li>
							</ul>
						</li>-->

					@endif
					@if(Auth::User()->rol_id == 7)
						<li class="dropdown" style="background: #A4A4A4;">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-exclamation"></i><strong> Sin Conexión </strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li><a href="http://201.236.212.130:82/ceba/public" id="menus" target="_black"><i class="fa fa-arrow-right"></i><strong> Ceba</strong></a></li>
								<li><a href="http://201.236.212.130:82/precebo/public" id="menus" target="_black"><i class="fa fa-arrow-right"></i><strong> Precebo</strong></a></li>
								<li><a href="http://201.236.212.130:82/finalizacion/public" id="menus" target="_black"><i class="fa fa-arrow-right"></i><strong> Destete Finalización</strong></a></li>
								<li><a href="http://201.236.212.130:82/mortalidad/public" id="menus" target="_black"><i class="fa fa-arrow-right"></i><strong> Mortalidad</strong></a></li>
								<li><a href="http://201.236.212.130:82/destetes/public" id="menus" target="_black"><i class="fa fa-arrow-right"></i><strong> Destetos Semana</strong></a></li>
							</ul>
						</li>
					@endif
					<li class="dropdown">
						@if(Auth::User()->rol_id == 6 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 8 || Auth::User()->rol_id == 9 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 13)
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-shopping-cart"></i><strong> Pedidos</strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								@if(Auth::User()->rol_id == 6 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 13)
									@if(Auth::User()->rol_id == 6 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10)
										<li><a href="{{route('admin.pedidoMedicamentos.create')}}" id="menus"><i class="fa fa-medkit" ></i> <strong>Solicitar Medicamentos</strong></a></li>
										<li><a href="{{route('admin.pedidoInsumosServicios.create')}}" id="menus"><i class="fa fa-archive" ></i> <strong>Solicitar Insumos</strong></a></li>
									@endif
									@if(Auth::User()->rol_id == 6 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 13)
										<li><a href="{{route('admin.pedidoConcentrados.create')}}" id="menus"><i class="fa fa-filter" ></i> <strong>Solicitar Concentrados</strong></a></li>
									@endif
									@if(Auth::User()->rol_id == 6 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10)
										<li><a href="{{route('admin.pedidoProductosCia.create')}}" id="menus"><i class="fa fa-eye-dropper"></i> <strong>Solicitar Semen</strong></a></li>
									@endif
								@endif

								@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 8 || Auth::User()->rol_id == 9 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 6 || Auth::User()->rol_id == 13)
									@if(Auth::User()->rol_id == 8 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 6)
										<li><a href="{{route('admin.pedidoMedicamentos.index')}}" id="menus"><i class="fa fa-file"></i> Consultar Pedidos de Medicamentos</a></li>
									@endif
									@if(Auth::User()->rol_id == 9 || Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10 || Auth::User()->rol_id == 6 || Auth::User()->rol_id == 13)
										@if(Auth::User()->id == 47)
										@else
											<li onclick="guardarIdEnLocalStorage()"><a href="{{route('admin.pedidoConcentrados.index')}}" id="menus" class="table_consec"><i class="fa fa-file" onclick="guardarIdEnLocalStorage()"></i> Consultar Pedidos de Concentrado</a></li>
										@endif
									@endif
									@if(Auth::User()->id == 47 || Auth::User()->rol_id == 7)
										<li><a href="{{route('admin.pedidoProductosCia.index')}}" id="menus"><i class="fa fa-file"></i> Consultar Pedidos de Semen</a></li>
									@endif
								@endif
							</ul>
						@endif

						@if(Auth::User()->rol_id == 10)
							<li class="dropdown">
								<a href="{{ route('admin.entregaconcentrados.index')}}"  id="menus"><i class="fa fa-calendar"></i><strong> Ver Turnos </strong></a>
							</li>
						@endif

						@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7)
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><i class="fa fa-key"></i><strong> Administración </strong><span class="caret"></span></a>
								<ul class="dropdown-menu submenus">
									@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7)
										<li><a href="{{route('admin.users.index')}}" id="menus"><i class="fa fa-users"></i> Usuarios</a></li>
									@endif
									@if(Auth::User()->rol_id == 1)
										<li><a href="{{route('admin.sedes.index')}}" id="menus"><i class="fa fa-building"></i> Sedes</a></li>
										<li><a href="{{route('admin.cargos.index')}}" id="menus"><i class="fa fa-briefcase"></i> Cargos</a></li>
										<li><a href="{{route('admin.areas.index')}}" id="menus"><i class="fa fa-inbox"></i> Areas</a></li>
										<li><a href="{{route('admin.roles.index')}}" id="menus"><i class="fa fa-address-card"></i> Roles</a></li>
									@endif
									<li><a href="{{route('admin.asociacionGranjas.index')}}" id="menus"><i class="fa fa-address-book"></i> Admon Granjas</a></li>
								</ul>
							</li>
						@endif

					</li>
					@if(Auth::User()->rol_id !== 13)
						<li class="dropdown" style="background: #651410;">
						<a href="/intranetcercafe/public/admin/enketoformscategories" id="menus"><i class="fa fa-align-justify"></i><strong> Forms </strong></span></a>
						</li>
					@endif

						<!--Módulo de desposte para implementar-->
{{-- 					@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7)
						<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><strong>Desposte</strong><span class="caret"></span></a>
							<ul class="dropdown-menu submenus">
								<li><a href="http://201.236.212.130:82/fdesposte/public/solicitud" id="solicitudDesposte"></i>Solicitud</a></li>
								<li><a href="#" id="consultaDesposte">Consulta</a></li>
							</ul>
						</li>
					@endif --}}

				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menus"><strong> {{Auth::User()->nombre_completo}} </strong><span class="caret"></span></a>
						<ul class="dropdown-menu submenus">
							<li><a href="{{ route('admin.users.show', Auth::User()->id) }}" id="menus"><i class="fa fa-user-circle"></i> Perfil</a></li>
							<li><a href="/intranetcercafe/public/logout" id="menus"><i class="fa fa-sign-out"></i> Salir</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>

	</nav>

	<div class="container-fluid">
		@yield('content')
	</div>
	<script>

		document.getElementById('solicitudDesposte').addEventListener('click', function(){
			var id = '<?php echo Auth::User()->id ?>';
			localStorage.setItem("usuario", id);
		})

		$(document).ready(function(){
		  $('.dropdown-submenu a.test').on("click", function(e){
		    $(this).next('ul').toggle();
		    e.stopPropagation();
		    e.preventDefault();
		  });

		  var canvas = document.getElementById('snow');
		  var ctx = canvas.getContext('2d');

			var w = canvas.width = window.innerWidth;
			var h = canvas.height = 150;

			var num = 30;
			var tamaño = 40;
			var elementos = [];

			inicio();
			nevada();

			window.addEventListener("resize", function() {
			  w = canvas.width = window.innerWidth;
			  h = canvas.height = 150;
			});

			function inicio() {
			  for (var i = 0; i < num; i++) {
			    elementos[i] = {
			      x: Math.ceil(Math.random() * w),
			      y: Math.ceil(Math.random() * h),
			      toX: Math.random() * 10 - 5,
			      toY: Math.random() * 5 + 1,
			      tamaño: Math.random() * tamaño
			    }
			  }
			}

			function nevada() {
			  ctx.clearRect(0, 0, w, h);
			  for (var i = 0; i < num; i++) {
			    var e = elementos[i];
			    ctx.beginPath();
			    cristal(e.x, e.y, e.tamaño);
			    ctx.fill();
			    ctx.stroke();
			    e.x = e.x + e.toX;
			    e.y = e.y + e.toY;
			    if (e.x > w) { e.x = 0;}
			    if (e.x < 0) { e.x = w;}
			    if (e.y > h) { e.y = 0;}
			  }
			  timer = setTimeout(nevada,20);
			}

			function cristal(cx, cy, long) {
			  ctx.fillStyle = "white";
			  ctx.lineWidth = long / 20;
			  ctx.arc(cx, cy, long / 15, 0, 2 * Math.PI);
			  for (i = 0; i < 6; i++) {
			    ctx.strokeStyle = "white";
			    ctx.moveTo(cx, cy);
			    ctx.lineTo(cx + long / 2 * Math.sin(i * 60 / 180 * Math.PI),
			               cy + long / 2 * Math.cos(i * 60 / 180 * Math.PI));
			  }
			}
		});

		$(function(){
		    $(".dropdown-menu > li > a.trigger").on("click",function(e){
		        var current=$(this).next();
		        var grandparent=$(this).parent().parent();
		        if($(this).hasClass('left-caret')||$(this).hasClass('right-caret'))
		            $(this).toggleClass('right-caret left-caret');
		        grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
		        grandparent.find(".sub-menu:visible").not(current).hide();
		        current.toggle();
		        e.stopPropagation();
		    });
		    $(".dropdown-menu > li > a:not(.trigger)").on("click",function(){
		        var root=$(this).closest('.dropdown');
		        root.find('.left-caret').toggleClass('right-caret left-caret');
		        root.find('.sub-menu:visible').hide();
		    });
		});
	</script>

<script>
	function guardarIdEnLocalStorage(){
		localStorage.setItem("usuario", {{Auth::User()->id}});
	}
</script>


</body>
</html>