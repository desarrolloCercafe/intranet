@extends('templates_enketo.enketo_base')
@section('contenedor')   
	<title>Agradecimientos</title>
	<input type="hidden" id="area_seleccionada" value="0">
	<p>El proyecto Cercafé FORMS es presentado por contribuidores OpenSource con el generoso apoyo de:</p>
	<div class="container">
		<a href="https://enketo.org/" target="_blank">{{Html::image('frontend_enketo/img/logo-enketo.png', 'logo', array('class' => 'logotip', 'width' => '200px', 'style' => 'margin-left: 10px; margin-top: 5px;'))}}</a>
		<a href="https://opendatakit.org/" target="_blank">{{Html::image('frontend_enketo/img/logo-odk.png', 'logo', array('class' => 'logotip', 'width' => '200px', 'style' => 'margin-left: 10px; margin-top: 5px;'))}}</a>
		<a href="https://github.com/" target="_blank">{{Html::image('frontend_enketo/img/logo-github.png', 'logo', array('class' => 'logotip', 'width' => '200px', 'style' => 'margin-left: 10px; margin-top: 5px;'))}}</a>
		<br/>
		<br/>
		<p>La finalidad de este proyecto es brindar la posibilidad de capturar información en tiempo real de todas las unidades de negocio de nuestra cooperativa, desde granjas hasta planta de alimento balanceado, area por area, proceso por proceso. Logramos extraer información confiable para tomar decisiones certeras que habran de impactar positivamente cada área, innovando tecnológicamente el sector productivo en medio de un mundo globalizado.</p>
		<br/>
		<p>Esta aplicación esta conectada y monitoreada por: </p>
		<br/>
		<a href="https://powerbi.microsoft.com/es-es/" target="_blank">{{Html::image('frontend_enketo/img/logo-powerBI.png', 'logo', array('class' => 'logotip', 'width' => '150px', 'style' => 'margin-left: 5px; margin-top:2.5px;'))}}</a>
		<a href="http://201.236.212.130:82/intranetcercafe/public/log" target="_blank">{{Html::image('frontend_enketo/img/logo-intranet.png', 'logo', array('class' => 'logotip', 'width' => '150px', 'style' => 'margin-left: 5px; margin-top:2.5px;'))}}</a>
		<br/>
		<h5>La informacion aqui visualizada pertenece a: </h5>
		<br/>
		<a href="https://www.cercafe.com/" target="_blank">{{Html::image('frontend_enketo/img/logo-cercafe.jpg', 'logo', array('class' => 'logotip', 'width' => '200px', 'style' => 'margin-left: 10px; margin-top: 5px;'))}}</a>
		<a href="https://lomus.com.co/" target="_blank">{{Html::image('frontend_enketo/img/logo-lomus.png', 'logo', array('class' => 'logotip', 'width' => '150px', 'style' => 'margin-left: 5px; margin-top:2.5px;'))}}</a>
	</div>
@endsection