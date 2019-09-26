<h3>Intranet Cercafe <span><img style="margin-left: 320" width="120px" height="50px" src="C:/xampp/htdocs/intranetcercafe/public/logo-rojo.png"></span></h3>
<h2 style="text-align:center">Pedido de SEMEN CIA</h2>
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
<p>Consecutivo # <strong>PSE{{$cons}}</strong></p>
<p>Fecha de Creación:  <strong>{{$fecha_p}}</strong></p>
<p>Granja: <strong>{{$granja_pedido}}</strong></p>
<p>Pedido solicitado por: <strong>{!!Auth::User()->nombre_completo!!}</strong></p>

<table class="normal" summary="Tabla genérica">
	<tr>
		<th scope="col">Codigo</th>
		<th scope="col">Producto</th>
		<th scope="col"># Dosis</th>
	</tr>
	@foreach($productos_cia_solicitados as $p_solicitado)
		<tr>
			<td>{{$p_solicitado['codigo']}}</td>
			<td>{{$p_solicitado['nombre']}}</td>
			<td>{{$p_solicitado['dosis']}}</td>
		</tr>
	@endforeach
</table>