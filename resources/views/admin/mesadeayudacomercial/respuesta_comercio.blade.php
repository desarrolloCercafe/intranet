<!DOCTYPE html>
<html>
<head>
	<title>Respuesta PQR</title>
</head>
<body>
	<h2>Area Comercial Intranet | Cercafe</h2>
	<p>Respuesta de solicitud:</p>
	<p><strong>Motivo de la Solicitud:</strong>{{$motivo_descripcion}} </p>
	@if($motivo_adicional != null)
		<p><strong>Otro Motivo:</strong>{{$motivo_adicional}} </p>
	@endif	
	<p><strong>Descripción:</strong>{{$descripcion_respuesta}}</p>
	<p><strong>Fecha de la Respuesta:</strong> {{$fecha_redaccion}}</p>
</body>
</html>