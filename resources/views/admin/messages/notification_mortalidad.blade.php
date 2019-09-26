 <!DOCTYPE html>
<html>
<head>
	<title>Nuevo Movimiento</title>
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
	<h2>Formulario de Mortalidad| Cercafe</h2>
	<p>Se ha ingresado un nuevo lote: </p>

	<p>El Usuario <strong>{!!Auth::User()->nombre_completo!!}</strong> Ha ingresado el lote #<strong>{!!$lote!!}</strong> a la base de datos de <strong>Mortalidad</strong></p>

	<table id="customers">
		<tr>
			<td><strong>Sala:</strong> </td>
			<td class="datos">{{$sala}}</td>
		</tr>
		<tr>
			<td><strong>Numero de Cerdos:</strong> </td>
			<td class="datos">{{$numero_cerdos}}</td> 
		</tr>
		<tr>
			<td><strong>Sexo del Cerdo:</strong> </td>
			<td class="datos">{{$sexo_cerdo}}</td>
		</tr>
		<tr>
			<td><strong>Peso del Cerdo:</strong> </td>
			<td class="datos">{{$peso_cerdo}}</td>
		</tr>
		<tr>
			<td><strong>Fecha:</strong> </td>
			<td class="datos">{{$fecha_muerte}}</td> 
		</tr>
		<tr>
			<td><strong>Día de Muerte:</strong> </td>
			<td class="datos">{{$dia_muerte}}</td>
		</tr>
		<tr>
			<td><strong>Año de Muerte:</strong> </td>
			<td class="datos">{{$año_muerte}}</td>
		</tr>
		<tr>
			<td><strong>Mes de Muerte:</strong> </td>
			<td class="datos">{{$mes_muerte}}</td>
		</tr>
		<tr>
			<td><strong>Semana de Muerte:</strong> </td>
			<td class="datos">{{$semana_muerte}}</td>
		</tr>
	</table>

	<p>Esta es una notificación generada Automaticamente por <strong><a href="http://201.236.212.130:82/intranetcercafe/">Intranet Cercafe</a></strong>, por favor no responder</p>
</body>
</html>