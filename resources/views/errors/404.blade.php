@extends('template.auth')
@section('content')
        <title>Error 404</title>
        <div class="content">
        	<div style="margin-left: 43%; margin-right: 35%; margin-top: 2%">{!!Html::image('pig.png','us',array('class' => 'imuser'))!!}</div>
        	<div style="margin-left: 45%; margin-right: 35%; margin-top: 2%"><strong style="font-size: 100px;">404</strong></div>
        	<div style="color: #000000; margin-left: 500px; font-size: 30px;"><strong>Ooopss..!</strong><span style="color: #FA5882; font-size: 30px"> Ha ocurrido un error!!!</span></div>
        	<br/>
        	<a href="/intranetcercafe/public/log" style="margin-left: 39%;"><button class="btn btn-default" style="margin-left: 110px;">Redireccionar</button></a>
        </div> 		
@endsection