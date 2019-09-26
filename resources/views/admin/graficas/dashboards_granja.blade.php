@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Dashboards Area Tecnica</title>
	<div id="container-main">
		<div class="panel-heading" id="titulo">
			<h4><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboards Granjas Área Técnica</h4>
		</div>

		<div class="acordeon-container">
			<a class="accordion-titulo">Cría<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive embed-responsive-16by9">
						<!--<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZTYzMDI5ZjUtNGI4NS00NDI1LTkzY2ItNWExZTFkZDJhNDRlIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
							<!--<iframe width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiN2I0ZjA4OTctNWVhMi00NjEwLTlhMjMtOTI3ZDkwMGJlYTJiIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
							<iframe width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiM2E3NzJmMTMtMThlZi00YWJmLWI1NGYtMDExYTYyNTE3ZDQ5IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>
		<div class="acordeon-container">
			<a class="accordion-titulo">Precebo<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive embed-responsive-16by9">
						<!--<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZWExNmY3MTUtODM5Mi00OWNlLWE3YWEtOWMwMjllN2NlODVkIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->

						<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZWExNmY3MTUtODM5Mi00OWNlLWE3YWEtOWMwMjllN2NlODVkIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>

			</div>
		</div>
		<div class="acordeon-container">
			<a class="accordion-titulo">Ceba<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive embed-responsive-16by9">

					<!--<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiOTU5NzRjZWUtMDEwNi00MDc1LWEzNTAtOWI1NTYzOWQ5MDI5IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->

					<!--<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiOTU5NzRjZWUtMDEwNi00MDc1LWEzNTAtOWI1NTYzOWQ5MDI5IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->

					<!--<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiOTU5NzRjZWUtMDEwNi00MDc1LWEzNTAtOWI1NTYzOWQ5MDI5IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
					<iframe width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiOTU5NzRjZWUtMDEwNi00MDc1LWEzNTAtOWI1NTYzOWQ5MDI5IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>
		<div class="acordeon-container">
			<a class="accordion-titulo">Destete Finalización<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMjMyZTQ2ZGEtYmI1Zi00Mzg1LWJkNjctMjk4NjFkZTdmM2YzIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(".accordion-titulo").click(function(){
		   var contenido=$(this).next(".accordion-content");

		   if(contenido.css("display")=="none"){ //open
		      contenido.slideDown(250);
		      $(this).addClass("open");
		   }
		   else{ //close
		      contenido.slideUp(250);
		      $(this).removeClass("open");
		  }

		});
	</script>
	<style type="text/css">
		#container-main{
		    margin:40px auto;
		    width:95%;
		}

		.accordion-container {
		    width: 100%;
		    margin: 0 0 20px;
		    clear:both;
		}

		.accordion-titulo {
		    position: relative;
		    display: block;
		    padding: 20px;
		    font-size: 24px;
		    font-weight: 300;
		    background: #ffffff;
		    color: #DF0101;
		    text-decoration: none;
		}
		.accordion-titulo.open {
		    background: #DF0101;
		    color: #fff;
		    text-decoration: none;
		}
		.accordion-titulo:hover {
		    background: #DF0101;
		    color: #fff;
		    text-decoration: none;
		}

		.accordion-titulo span.toggle-icon:before {
		    content:"+";
		}

		.accordion-titulo.open span.toggle-icon:before {
		    content:"-";
		}

		.accordion-titulo span.toggle-icon {
		    position: absolute;
		    top: 10px;
		    right: 20px;
		    font-size: 38px;
		    font-weight:bold;
		}
		.accordion-content {
		    display: none;
		    padding: 20px;
		    overflow: auto;
		    text-align: center;
		}

		.accordion-content p{
		    margin:0;
		}

		.accordion-content img {
		    display: block;
		    float: left;
		    margin: 0 15px 10px 0;
		    width: 50%;
		    height: auto;
		}

		@media (max-width: 767px) {
		    .accordion-content {
		        padding: 10px 0;
		    }
		}
	</style>
@endsection