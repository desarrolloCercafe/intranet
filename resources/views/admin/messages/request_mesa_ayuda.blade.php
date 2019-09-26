<!DOCTYPE html>
<html>
<head>
	<title>Solicitud Recibida</title>
</head>
<body>
	<h2>Solicitud recibida por medio de la Intranet | Cercafe</h2>
	<p>Tienes una solicitud pendiente: </p>
	<p><strong>Asunto:</strong>{!!$asunto!!}</p>	
	<p><strong>Descripción: </strong></p>
	<textarea  style="width:658px;height:81px;font-size:12px;padding:5px;" readonly="readonly">{!!$descripcion_solicitud!!}</textarea>
	<p><strong>Solicitado por:</strong> {!!Auth::User()->nombre_completo!!}</p>
	<p><strong>Fecha de Creación:</strong> {!!$fecha_creacion!!}</p>
	<p><strong>Prioridad: </strong>{!!$prioridad!!}</p>

	<p>Esta es una notificación de la Mesa de Ayuda generada Automaticamente por <a href="http://201.236.225.205:82/intranetcercafe/">Intranet Cercafe</a>, por favor no responder</p>
</body>
</html>