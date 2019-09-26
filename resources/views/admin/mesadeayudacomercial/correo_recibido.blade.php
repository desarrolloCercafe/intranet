<!DOCTYPE html>
<html>
<head>
	<title>Se ha Recibido su Solicitud</title>
</head>
<body>
	<h1>Area Comercial Intranet | Cercafe</h1>
	<h2>Buen día</h2>
	<h3>¡Hemos recibido tu solicitud!, empezaremos a trabajar en ella, y pronto nos estaremos comunicando contigo.</h3>
	<p><strong>Su Solicitud es la Numero: SO</strong>{{$solicitud_id}}</p>
	<p><strong>Motivo de la Solicitud:</strong>{{$motivo_descripcion}} </p>
	@if($motivo_adicional != null)
		<p><strong>Otro Motivo:</strong>{{$motivo_adicional}} </p>
	@endif	
	<p><strong>Descripción:</strong>{{$descripcion}}</p>
</body>
</html>