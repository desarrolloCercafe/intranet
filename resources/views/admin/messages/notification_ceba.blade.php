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
	<h2>Formulario de Ceba | Cercafe</h2>
	<p>Se ha ingresado un nuevo lote: </p> 
	
	<p>El Usuario <strong>{!!Auth::User()->nombre_completo!!}</strong> Ha ingresado el lote #<strong>{!!$lote!!}</strong> a la base de datos de <strong>Ceba</strong></p>
	<table id="customers">
		<tr>
			<td><strong>Fecha Inicial:</strong></td>
			<td>{{$fecha_ingreso_granja}}</td>
		</tr>
		<tr>
			<td><strong>Fecha Final:</strong></td>
			<td >{{$fecha_salida_granja}}</td>
		</tr>
		<tr>
			<td><strong>Numero Inicial:</strong></td>
			<td >{{$cant_cerdos_lote}}</td>
		</tr>
		<tr>
			<td><strong>Numero Final:</strong></td>
			<td >{{$cant_cerdos_finales}}</td>
		</tr>
		<tr>
			<td><strong>Porcentaje de Mortalidad:</strong></td>
			<td >{{$mortalidad}}%</td>
		</tr>
		<tr>
			<td><strong>Dias Jaulon:</strong></td>
			<td >{{$dias_granja}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Inicial:</strong></td>
			<td >{{$peso_promedio_cerdos_ingresados}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Final:</strong></td>
			<td >{{$peso_promedio_cerdos_vendidos}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio:</strong></td>
			<td >{{$cons_promedio_ini}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día:</strong></td>
			<td >{{$cons_promedio_dia_ini}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio:</strong></td>
			<td >{{$ato_promedio_ini}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio Día:</strong></td>
			<td >{{$ato_promedio_dia_ini}}</td>
		</tr>
		<tr>
			<td><strong>Conversion Real:</strong></td>
			<td >{{$conversion_ini}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio con Mortalidad:</strong></td>
			<td >{{$consumo_promedio}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día con Mortalidad:</strong></td>
			<td >{{$consumo_promedio_dias}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio con Mortalidad:</strong></td>
			<td >{{$ato_promedio_fin}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio Día con Mortalidad:</strong></td>
			<td >{{$ato_promedio_dia_fin}}</td>
		</tr>
		<tr>
			<td><strong>Conversion Real con Mortalidad:</strong></td>
			<td >{{$conversion_fin}}</td>
		</tr>
	</table>
	<p>Esta es una notificación generada Automaticamente por <strong><a href="http://201.236.212.130:82/intranetcercafe/">Intranet Cercafe</a></strong>, por favor no responder</p>
</body>
</html>