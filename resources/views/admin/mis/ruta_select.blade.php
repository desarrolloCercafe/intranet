@extends('template.plantilla')

@section('content')
		<meta charset="utf-8">
		<title>SIGC | Cercafe</title>
		@include('admin.alerts.request') 
			<!-- switches -->
		<div>
			<center>
				<h2>{{ $rutaSelect->nombre_ruta }}</h2>
			</center>
		</div>
				
		<div>
			<center>
				<iframe src="{{ $rutaSelect->ruta }}" width="450" height="350" style="margin-left: 80px; "></iframe>
			</center>
		</div>
@endsection