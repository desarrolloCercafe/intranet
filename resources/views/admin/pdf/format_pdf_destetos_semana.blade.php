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
<p><strong>Registro: </strong> <span style="color: #df0101;">Destete Semanal</span></p>
<table class="normal" summary="Tabla genérica">
	@foreach($desteteS_solicitada as $desteto)
		<tr>
			<td><strong>Numero de Destetos:</strong> </td>
			<td class="datos">{{$desteto['numero_destetos']}}</td>
		</tr>
		<tr>
			<td><strong>Mortalidad en Precebo:</strong> </td>
			<td class="datos">{{$desteto['mortalidad_precebo']}}</td>
		</tr>
		<tr>
			<td><strong>Mortalidad en Ceba:</strong> </td>
			<td class="datos">{{$desteto['mortalidad_ceba']}}</td>
		</tr>
		<tr>
			<td><strong>Disponibilidad de Venta:</strong> </td>
			<td class="datos">{{$desteto['disponibilidad_venta']}}</td>
		</tr>
		<tr>
			<td><strong>Kilos en Venta:</strong> </td>
			<td class="datos">{{$desteto['kilos_venta']}}</td>
		</tr>
	@endforeach
</table>