@extends('template.auth')
@section('content')
        <title>Internal Server</title>
        <div class="content">
        	<div style="margin-left: 43%; margin-right: 35%; margin-top: 2%">{!!Html::image('server.png','us',array('class' => 'imuser'))!!}</div>
        	<div style="margin-left: 45%; margin-right: 35%; margin-top: 2%"><strong style="font-size: 100px;">500</strong></div>
        	<div style="color: #000000; margin-left: 480px; font-size: 30px;"><strong>Internal Server Error!! </strong><span style="color: #df0101; font-size: 30px"> Intentalo luego</span></div>
        	<br/>
        </div> 	
@endsection