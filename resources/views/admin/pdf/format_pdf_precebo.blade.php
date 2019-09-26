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
<p><strong>Registro: </strong> <span style="color: #df0101;">Precebo</span></p>
<table class="normal" summary="Tabla genérica">
	@foreach($precebo_solicitado as $precebo)
		<tr>
			<td><strong>lote:</strong> </td>
			<td class="datos">{{$precebo['lote']}}</td>
		</tr>
		<tr>
			<td><strong>Fecha Inicial:</strong> </td>
			<td class="datos">{{$precebo['fecha_destete']}}</td>
		</tr>
		<tr>
			<td><strong>Fecha Final:</strong> </td>
			<td class="datos">{{$precebo['fecha_traslado']}}</td>
		</tr>
		<tr>
			<td><strong>Numero Inicial:</strong> </td>
			<td class="datos">{{$precebo['numero_inicial']}}</td>
		</tr>
		<tr>
			<td><strong>Numero Final:</strong> </td>
			<td class="datos">{{$precebo['numero_final']}}</td>
		</tr>
		<tr>
			<td><strong>Porcentaje de Mortalidad:</strong> </td>
			<td class="datos">{{$precebo['porciento_mortalidad']}}%</td>
		</tr>
		<tr>
			<td><strong>Dias:</strong> </td>
			<td class="datos">{{$precebo['dias_jaulon']}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Inicial:</strong> </td>
			<td class="datos">{{$precebo['peso_promedio_ini']}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Final:</strong> </td>
			<td class="datos">{{$precebo['peso_promedio_fin']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio:</strong> </td>
			<td class="datos">{{$precebo['cons_promedio_ini']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día:</strong> </td>
			<td class="datos">{{$precebo['cons_promedio_dia_ini']}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio:</strong> </td>
			<td class="datos">{{$precebo['ato_promedio_ini']}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio Dia:</strong> </td>
			<td class="datos">{{$precebo['ato_promedio_dia_ini']}}</td>
		</tr>

		<tr>
			<td><strong>Conversion Real:</strong> </td>
			<td class="datos">{{$precebo['conversion_ini']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio con Mortalidad:</strong> </td>
			<td class="datos">{{$precebo['cons_promedio']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día con Mortalidad:</strong> </td>
			<td class="datos">{{$precebo['cons_promedio_dia']}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio con Mortalidad:</strong> </td>
			<td class="datos">{{$precebo['ato_promedio_fin']}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio Día con Mortalidad:</strong> </td>
			<td class="datos">{{$precebo['ato_promedio_dia_fin']}}</td>
		</tr>
		
		<tr>
			<td><strong>Conversion Real con Mortalidad:</strong> </td>
			<td class="datos">{{$precebo['conversion_fin']}}</td>
		</tr>
	@endforeach
</table>