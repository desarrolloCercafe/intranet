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
	<h2>Formulario de Destete Finalización | Cercafe</h2>
	<p>Se ha ingresado un nuevo lote: </p>

	<p>El Usuario <strong>{!!Auth::User()->nombre_completo!!}</strong> Ha ingresado el lote #<strong>{!!$lote!!}</strong> a la base de datos de <strong>Destete Finalización</strong></p>

	<table id="customers">
		<tr>
			<td><strong>Fecha Inicial:</strong></td>
			<td class="datos">{{$fecha_ingreso_granja}}</td>
		</tr>
		<tr>
			<td><strong>Fecha Final:</strong></td>
			<td class="datos">{{$fecha_salida_granja}}</td>
		</tr>
		<tr>
			<td><strong>Numero Inicial:</strong></td>
			<td class="datos">{{$cant_cerdos_lote}}</td>
		</tr>
		<tr>
			<td><strong>Numero Final:</strong></td>
			<td class="datos">{{$cant_cerdos_finales}}</td>
		</tr>
		<tr>
			<td><strong>Porcentaje de Mortalidad:</strong></td>
			<td class="datos">{{$mortalidad}}%</td>
		</tr>
		<tr>
			<td><strong>Dias Jaulon:</strong></td>
			<td class="datos">{{$dias_granja}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Inicial:</strong></td>
			<td class="datos">{{$peso_promedio_cerdos_ingresados}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Final:</strong></td>
			<td class="datos">{{$peso_promedio_cerdos_vendidos}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio:</strong></td>
			<td class="datos">{{$cons_promedio_ini}}</td>  
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día:</strong></td>
			<td class="datos">{{$cons_promedio_dia_ini}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio:</strong></td>
			<td class="datos">{{$ato_promedio}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio Dia:</strong></td>
			<td class="datos">{{$ato_promedio_dia}}</td>
		</tr>
		<tr>
			<td><strong>Conversion Real:</strong></td>
			<td class="datos">{{$conv}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio con Mortalidad:</strong></td>
			<td class="datos">{{$consumo_promedio}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día con Mortalidad:</strong></td>
			<td class="datos">{{$consumo_promedio_dias}}</td>
		</tr>	
	</table>

	<p>Esta es una notificación generada Automaticamente por <strong><a href="http://201.236.212.130:82/intranetcercafe/">Intranet Cercafe</a></strong>, por favor no responder</p>
</body>
</html>