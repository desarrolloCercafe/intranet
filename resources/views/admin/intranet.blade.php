@extends('template.plantilla')
@section('content')
	<meta charset="utf-8">
	<title>Intranet | Cercafe</title>
	@include('admin.alerts.request') 
	<style type="text/css">
		html, body, div, iframe
		{
			margin: 0px;
			padding: 0px;
			height: 100%;
		}
		iframe
		{
			margin-top: -40px;
			display: block;
			border: none;
		}
	</style>
	<iframe src="http://201.236.212.130:8080" class="col-lg-12 col-xs-12 col-md-12"> </iframe>		
@endsection