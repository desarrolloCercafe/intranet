<!DOCTYPE html>
<html>
<head>
		<title>Respuesta Mesa de Ayuda</title>
</head>
<body>
	<h2>Respuesta solicitud mesa de ayuda Cercafe</h2>
	<p>{!!$asunto_respuesta!!}</p>
	<textarea  style="width:658px;height:81px;font-size:14px;padding:5px;" readonly="readonly">{!!$descripcion_respuesta!!}</textarea>
	<p>Atentamente: <strong>{!!Auth::User()->nombre_completo!!}</strong></p>
	<p>Esta es una notificación de la Mesa de Ayuda generado Automaticamente por <a href="http://201.236.225.205:82/intranetcercafe/">Intranet Cercafe</a>, por favor no responder</p>
</body>
</html>