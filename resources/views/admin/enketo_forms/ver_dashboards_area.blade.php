@extends('templates_enketo.enketo_base')
@section('contenedor')
	<style type="text/css">
		#container-main{
		    margin:40px auto;
		    width:95%;
		}

		#container-main2{
		    margin:40px auto;
		    width:95%;
		}

		@media (max-width: 767px) {
		    .accordion-content {
		        padding: 10px 0;
		    }
		}
	</style>
	<input type="hidden" id="area_seleccionada" value="{{$area}}">
	@foreach($areas as $ar)
		@if($ar->id == $area)
			<title>Dashboards {{$ar->nombre_area}}</title>
		@endif
	@endforeach

	<button id="show_hide_iframes_1" onclick="cambiarIframes_1()" style="background-color: red; color: white;">Baches</button>
	<button id="show_hide_iframes_2" onclick="cambiarIframes_2()" style="background-color: gray; color: white;">Promedios</button>

	@if (Auth::User()->rol_id == 7 || Auth::User()->rol_id == 9 || Auth::User()->rol_id == 11 || Auth::User()->rol_id == 3)
		<div id="container-main">
			@foreach($iframes_seleccionados as $iframe_selecionado)
				<div class="acordeon-container">
					<a class="accordion-titulo">{{$iframe_selecionado["descripcion"]}} Bache<span class="toggle-icon"></span></a>
					<div class="accordion-content embed-responsive embed-responsive-16by9">
						{!!$iframe_selecionado["iframe"]!!}
					</div>
				</div>
				<br/>
			@endforeach
		</div>
		<div id="container-main2" style="display: none;">
			@foreach($iframes_seleccionados as $iframe_selecionado)
				<div class="acordeon-container">
					<a class="accordion-titulo">{{$iframe_selecionado["descripcion"]}} Promedio<span class="toggle-icon"></span></a>
					<div class="accordion-content embed-responsive embed-responsive-16by9">
						{!!$iframe_selecionado["iframe2"]!!}
					</div>
				</div>
				<br/>
			@endforeach
		</div>
	@endif

	<script>

		function cambiarIframes_1(){
			var framesViejos = document.getElementById("container-main2");
			var framesActuales = document.getElementById("container-main");
			var boton1 = document.getElementById("show_hide_iframes_1");
			var boton2 = document.getElementById("show_hide_iframes_2");

			framesViejos.style.display = "none";
			framesActuales.style.display = "block";

			boton1.style.backgroundColor = "red";
			boton2.style.backgroundColor = "gray";
		}

		function cambiarIframes_2(){
			var framesViejos = document.getElementById("container-main2");
			var framesActuales = document.getElementById("container-main");
			var boton1 = document.getElementById("show_hide_iframes_1");
			var boton2 = document.getElementById("show_hide_iframes_2");

			framesViejos.style.display = "block";
			framesActuales.style.display = "none";

			boton1.style.backgroundColor = "gray";
			boton2.style.backgroundColor = "red";
		}

	</script>

@endsection