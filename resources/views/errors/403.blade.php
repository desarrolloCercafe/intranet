@extends('template.auth')
@section('content')
        <title>Error 403</title>
        <div class="content">
        	<div style="margin-left: 43%; margin-right: 35%; margin-top: 2%">{!!Html::image('forbidden.png','us',array('class' => 'imuser'))!!}</div>
        	<div style="margin-left: 45%; margin-right: 35%; margin-top: 2%"><strong style="font-size: 100px;">403</strong></div>
        	<div style="color: #000000; margin-left: 500px; font-size: 30px;"><strong>Ooopss..!</strong><span style="color: #FF0000; font-size: 30px"> Acceso Denegado!!!</span></div>
        	<br/>
        </div> 		
@endsection