<!DOCTYPE html>
<html>
<head>
	<title>Pedido de Concentrados Modificado</title>
	<style type="text/css">
	#customers {
	  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	  border-collapse: collapse;
	  width: 100%;
	}
	#customers td, #customers th {
	  border: 1px solid #ddd;
	  padding: 8px;
	}
	#customers tr:nth-child(even){background-color: #f2f2f2;}

	#customers tr:hover {background-color: #ddd;}

	#customers th {
	  padding-top: 12px;
	  padding-bottom: 12px;
	  text-align: left;
	  background-color: red;
	  color: white;
	}
</style>
</head>
<body>
	<h2>Pedido de Concentrados | Cercafe</h2>
	<p style="font-size: 2rem"><strong>Adicional</strong></p>
	<p>Tienes un nuevo pedido del tipo adicional por evaluar:</p>
	<p>Consecutivo: <strong>PCO{{$consecutivo}}</strong></p>
	<p>Generado por el usuario: <strong>{{$usuario}}</strong></p>
	<p>Esta es una notificación generada Automaticamente por <strong><a href="http://201.236.212.130:82/intranetcercafe/">Intranet Cercafe</a></strong>, por favor no responder</p>
</body>
</html>