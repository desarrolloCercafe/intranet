<h3>Intranet Cercafe <span><img style="margin-left: 320" width="120px" height="50px" src="C:/xampp/htdocs/intranetcercafe/public/logo-rojo.png"></span></h3>
<h2 style="text-align:center">Pedido de Insumos</h2>
<h3 style="text-align:center">Granjas Cercafe</h3>
<style type="text/css">
	.normal 
	{
	  width: 700px;
	  border: 1px solid #000;
	  border-spacing: 0;
	}
	.normal th 
	{
  		text-align: center;
	}
	.normal th, .normal td 
	{
	  border: 1px solid #000;
	}
</style>
<p>Consecutivo # <strong>PME{{$cons}}</strong></p>
<p>Fecha de Creación:  <strong>{{$fecha_p}}</strong></p>
<p>Granja: <strong>{{$granja_pedido}}</strong></p>
<p>Documento generado por: <strong>{!!Auth::User()->nombre_completo!!}</strong></p>

<table class="normal" summary="Tabla genérica">
	<tr>
		<th scope="col">Codigo</th>
		<th scope="col">Producto</th>
		<th scope="col">Cantidad</th>
	</tr>
	@foreach($insumos_solicitados as $i_solicitado)
		<tr>
			<td>{{$i_solicitado['codigo']}}</td>
			<td>{{$i_solicitado['nombre']}}</td>
			<td>{{$i_solicitado['cantidad']}}</td>
		</tr>
	@endforeach
</table>