<!DOCTYPE html>
<html>
<head>
	<title>Pedido de Medicamentos Modificado</title>
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
	<h2>Modificacion | Cercafe</h2>
	<p><strong>Saludos</strong>, a continuación se describe la cantidad solicitada:</p>
	<p>Consecutivo:  <strong>PME{{$cons}}</strong></p>
	<table id="customers">
		<tr>
			<td><strong>Codigo:</strong></td>
			<td><strong>Granja: </strong></td>
			<td><strong>Producto:</strong></td>
			<td><strong>Cantidad: </strong></td>
		</tr> 
		@foreach($req as $pedido)
			<tr>
				@if($pedido["medicamento"] != null)
					<td class="datos">{{$pedido["codigo"]}}</td>
					@foreach($granjas as $granja) 
						@if($granja->id == $pedido["granja"])
							<td class="datos">{{$granja->nombre_granja}}</td>
						@endif
					@endforeach
					<td class="datos">{{$pedido["medicamento"]}}</td>
					<td class="datos"><strong>{{$pedido["cantidad"]}}</strong></td>
				@endif
			</tr> 
		@endforeach
	</table>
	<p>Esta es una notificación generada Automaticamente por <strong><a href="http://201.236.212.130:82/intranetcercafe/">Intranet Cercafe</a></strong>, por favor no responder</p>
</body>
</html>