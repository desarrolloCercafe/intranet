<!DOCTYPE html>
<html>
	<head>
		<title>Cercafe - Forms</title>
		<meta charset="utf-8"/>
  		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  		{!!Html::style('frontend_enketo/css/bootstrap4.min.css')!!}
  		{!!Html::style('frontend_enketo/css/style.css')!!}
		{!!Html::style('frontend_enketo/color/default.css')!!}
		{!!Html::script('frontend_enketo/js/modernizr.custom.js')!!}
		{!!Html::script('frontend_enketo/js/jquery.js')!!}
		{!!Html::script('frontend_enketo/js/interactive.js')!!}


		<style type="text/css">
				canvas {
  				position: absolute;
  				top: 0;
  				left: 0;
  				right: 0;
 	 			z-index: 1;
 	 			height: 10em;
 	 			margin-top: 10em;
			}

		body {
			overflow-x: hidden;
		}

		#intro{
			height: 100vh;
		}



		</style>

	</head>
	<body>
		<div class="menu-area">
		    <div id="dl-menu" class="dl-menuwrapper">
		        <button class="dl-trigger">Open Menu</button>
		        <ul class="dl-menu">
			       <!-- <li><a href="/intranetcercafe/public/admin/enketoformscategories" id="scroll-aut">Areas</a></li>
			        <li><a href="{{ route('admin.enketoformscategories.create') }}">Agradecimientos</a></li>-->
			        <li>
			          	<a href="#">Cercafé BI</a>
			          	<ul class="dl-submenu">
				            <!--<li><a href="/intranetcercafe/public/admin/dash">Generales</a></li>-->
							@if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 1 || Auth::User()->id == 3)
						    	<li>
						    		<!--<a href="#">Area</a>
						    		<ul class="dl-submenu">
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{1}}">Sistemas</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{2}}">M. Continuo</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{3}}">Financiera</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{4}}">Comercial</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{6}}">Técnica</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{7}}">Compras</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{9}}">Planta de Concentrados</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{10}}">Talento Humano</a></li>
						    			<li>--><a href="/intranetcercafe/public/admin/dasharea/{{11}}">Calidad</a></li>
						    		<!--</ul>
						    	</li>-->
						    @elseif(Auth::User()->area_id == 6 || Auth::User()->area_id == 9|| Auth::User()->area_id == 11)
						    	<li>
						    		<a href="#">Area</a>
						    		<ul class="dl-submenu">
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{9}}">Concentrados</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{11}}">Calidad</a></li>
						    			<li><a href="/intranetcercafe/public/admin/dasharea/{{6}}">Técnica</a></li>
									</ul>
						    	</li>
						    @else
						    	<li><a href="/intranetcercafe/public/admin/dasharea/{{Auth::User()->area_id}}">Area</a></li>
						    @endif
			          	</ul>
			        </li>
			        <li><a href="/intranetcercafe/public/admin/intranet"><i class="fa fa-chevron-left"></i> Intranet</a></li>
		        </ul>
		    </div>
		</div>
		<div id="intro" style="overflow-x: hidden;">

		    <div class="intro-text">
		      	<div class="container">
			        <div class="row">
			          	<div class="col-md-12">
				            <div class="brand">
				            	{{Html::image('frontend_enketo/img/logocercafe.png', 'logo', array('class' => 'logotip', 'width' => '100px', 'style' => 'margin-left: 10px; margin-top: 5px;'))}}
				            	<br/>
				                <h1><a href="#" id="titulo">Forms</a></h1>
				              	<div class="line-spacer"></div>
				              	<p><span id="subtitulo">¡Adios al Papel!</span></p>
				              	 	<!-- <i class="fa fa-arrow-down fa-3x" style="color: white; cursor: pointer; margin-top: 3em; @media only screen and (max-width: 500px) {
	  									margin-top:	4000px;
									}" id="scroll-bottom" ></i> -->
				            </div>
			          	</div>
			        </div>
		      	</div>
		    </div>
		</div>

	 	@yield('contenedor')

	 	<!--<footer>
		    <div class="container">
		      	<div class="row">
			        <div class="col-md-12">
			          	<p>&copy; Mamba Theme. All Rights Reserved</p>
			          	<div class="credits">
			            	Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
			          	</div>
			        </div>
		      	</div>
		    </div>
		</footer>-->




	</body>
	{!!html::script('frontend_enketo/js/bootstrap.min.js')!!}
	{!!Html::script('frontend_enketo/js/jquery.smooth-scroll.min.js')!!}
	{!!Html::script('frontend_enketo/js/jquery.dlmenu.js')!!}
	{!!Html::script('frontend_enketo/js/wow.min.js')!!}
	{!!Html::script('frontend_enketo/js/custom.js')!!}
	{!!Html::script('frontend_enketo/contactform/contactform.js')!!}

	<script>
		$(document).ready(function(){
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
	  timer = setTimeout(nevada,45);
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


	$("#scroll-bottom").click(function(){
    	document.getElementById( 'services' ).scrollIntoView();

    });

		});
	</script>



</html>