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
<p><strong>Registro: </strong> <span style="color: #df0101;">Destete Finalización</span></p>
<table class="normal" summary="Tabla genérica">
	@foreach($destete_f_solicitado as $destete)
		<tr>
			<td><strong>Fecha Inicial:</strong> </td>
			<td class="datos">{{$destete['fecha_ingreso_lote']}}</td>
		</tr>
		<tr>
			<td><strong>Fecha Final:</strong> </td>
			<td class="datos">{{$destete['fecha_salida_lote']}}</td>
		</tr>
		<tr>
			<td><strong>Numero Inicial:</strong> </td>
			<td class="datos">{{$destete['inic']}}</td>
		</tr>
		<tr>
			<td><strong>Numero Final:</strong> </td>
			<td class="datos">{{$destete['cant_final_cerdos']}}</td>
		</tr>
		<tr>
			<td><strong>Porcentaje de Mortalidad:</strong> </td>
			<td class="datos">{{$destete['por_mortalidad']}}%</td>
		</tr>
		<tr>
			<td><strong>Dias:</strong> </td>
			<td class="datos">{{$destete['dias']}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Inicial:</strong> </td>
			<td class="datos">{{$destete['peso_promedio_ingresado']}}</td>
		</tr>
		<tr>
			<td><strong>Peso Promedio Final:</strong> </td>
			<td class="datos">{{$destete['peso_promedio_vendido']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio:</strong> </td>
			<td class="datos">{{$destete['cons_promedio_ini']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día:</strong> </td>
			<td class="datos">{{$destete['cons_promedio_dia_ini']}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio:</strong> </td>
			<td class="datos">{{$destete['ato_promedio']}}</td>
		</tr>
		<tr>
			<td><strong>Ganancia Promedio Dia:</strong> </td>
			<td class="datos">{{$destete['ato_promedio_dia']}}</td>
		</tr>
		<tr>
			<td><strong>Conversion Real:</strong> </td>
			<td class="datos">{{$destete['conversion']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio con Mortalidad:</strong> </td>
			<td class="datos">{{$destete['consumo_promedio_lote']}}</td>
		</tr>
		<tr>
			<td><strong>Consumo Promedio Día con Mortalidad:</strong> </td>
			<td class="datos">{{$destete['consumo_promedio_lote_dias']}}</td>
		</tr>	
	@endforeach
</table>