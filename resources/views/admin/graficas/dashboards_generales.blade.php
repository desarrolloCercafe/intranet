@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Dashboards Area Tecnica</title>
	<div id="container-main">
		<div class="panel-heading" id="titulo">
			<h4><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboards Generales Área técnica</h4>
		</div>

		<!--<div class="acordeon-container">
			<a class="accordion-titulo">Costo Medicación Hembra Activa por Granja<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
						<iframe width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMmEzMWI4OWMtMmEwMy00NzAzLTk1NDktY2FkNTRhZjk1YTVkIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>-->



		<div class="acordeon-container">
			<a class="accordion-titulo">Cría<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
					<!--<iframe  class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiOTVlMjdmMWYtMTFlMy00NWM2LThjZjMtOThjZDUxZGQxZDYxIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
					<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiM2E3NzJmMTMtMThlZi00YWJmLWI1NGYtMDExYTYyNTE3ZDQ5IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>

		<!--<div class="acordeon-container">
			<a class="accordion-titulo">Primerizas<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive-item" class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiYmY2NjYzYmYtODExOS00ZWI3LTgzOTgtN2Q3Y2M2MTMzNGM0IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>-->

		<div class="acordeon-container">
			<a class="accordion-titulo">Precebo<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive embed-responsive-16by9">
					<!--<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNDAzYmQ4YTMtMzRmNi00OTQyLWI1MWItOWEyZmNjMDIzMjRlIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
					<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZWExNmY3MTUtODM5Mi00OWNlLWE3YWEtOWMwMjllN2NlODVkIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>

		<div class="acordeon-container">
			<a class="accordion-titulo">Ceba<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive embed-responsive-16by9">
					<!--<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZjc2ZTUzMmUtZjBhNC00MWMwLThhN2ItNjNhOWYwMWIxYTAzIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
					<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiOTU5NzRjZWUtMDEwNi00MDc1LWEzNTAtOWI1NTYzOWQ5MDI5IiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>

		<!--<div class="acordeon-container">
			<a class="accordion-titulo">Destete Finalización<span class="toggle-icon"></span></a>
			<div class="accordion-content">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" width="933" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiODdkZmMzOTMtZjEzMy00YjZjLWEzM2ItZTE4YmM4ZTZjZWMwIiwidCI6ImYyZWExNjcxLWU4N2QtNGYwMi05OTQxLWI3MjFhY2JkYmMwMSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
				</div>
			</div>
		</div>-->
	</div>
	{!!Html::script('js/acordeon.js')!!}
	{!!Html::style('media/css/acordeon.css')!!}
@endsection