@extends('template.auth')
@section('content')
        <title>Error 504</title>
        <div class="content">
        	<div style="margin-left: 43%; margin-right: 35%; margin-top: 2%">{!!Html::image('stopwatch.png','us',array('class' => 'imuser'))!!}</div>
        	<div style="margin-left: 45%; margin-right: 35%; margin-top: 2%"><strong style="font-size: 100px;">504</strong></div>
        	<div style="color: #000000; margin-left: 480px; font-size: 30px;"><strong>Tiempo de Respuesta Caducado..!! <br/></strong><span style="color: #DF7401; font-size: 30px; margin-left: 70px;"> Recarga esta página!!!</span></div>
        	<br/>
        </div> 	
@endsection