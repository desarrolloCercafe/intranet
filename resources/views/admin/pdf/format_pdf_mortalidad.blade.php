 <h3>Intranet Cercafe <span><img style="margin-left: 320" width="120px" height="50px" src="C:/xampp/htdocs/intranetcercafe/public/logo-rojo.png"></span></h3>
<h1 style="text-align:center">Lote <strong style="color: #df0101;">{{$lote}}</strong></h1>
<h3 style="text-align:center">Granja <strong style="color: #df0101;">{{$granja->nombre_granja}}</strong></h3>
<style type="text/css">
	.normal 
	{
	  width: 700px;
	  border: 1px solid #000;
	  border-spacing: 0;
	}
	.normal td 
	{
	  border: 1px solid #000;
	  
	}
	.datos 
	{
  		text-align: center;
	}
</style>
<p><strong>Registro: </strong> <span style="color: #df0101;">Mortalidad Precebo, Ceba</span></p>
<table class="normal" summary="Tabla genérica">
	@foreach($mortalidad_solicitada as $mortalidad)
		<tr>
			<td><strong>Sala:</strong> </td>
			<td class="datos">{{$mortalidad['sala']}}</td>
		</tr>
		<tr>
			<td><strong>Numero de Cerdos:</strong> </td>
			<td class="datos">{{$mortalidad['numero_cerdos']}}</td>
		</tr>
		<tr>
			<td><strong>Sexo del Cerdo:</strong> </td>
			<td class="datos">{{$mortalidad['sexo_cerdo']}}</td>
		</tr>
		<tr>
			<td><strong>Peso del Cerdo:</strong> </td>
			<td class="datos">{{$mortalidad['peso_cerdo']}}</td>
		</tr>
		<tr>
			<td><strong>Fecha:</strong> </td>
			<td class="datos">{{$mortalidad['fecha']}}</td>
		</tr>
		<tr>
			<td><strong>Día de Muerte:</strong> </td>
			<td class="datos">{{$mortalidad['dia_muerte']}}</td>
		</tr>
		<tr>
			<td><strong>Año de Muerte:</strong> </td>
			<td class="datos">{{$mortalidad['año_muerte']}}</td>
		</tr>
		<tr>
			<td><strong>Mes de Muerte:</strong> </td>
			<td class="datos">{{$mortalidad['mes_muerte']}}</td>
		</tr>
		<tr>
			<td><strong>Semana de Muerte:</strong> </td>
			<td class="datos">{{$mortalidad['semana_muerte']}}</td>
		</tr>
		<tr>
			<td><strong>Causa:</strong> </td>
			<td class="datos">{{$mortalidad['causa']}}</td>
		</tr>
		<tr>
			<td><strong>Alimento:</strong> </td>
			<td class="datos">{{$mortalidad['nombre_alimento']}}</td>
		</tr>
	@endforeach
</table>