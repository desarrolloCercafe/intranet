<h3>Intranet Cercafe <span><img style="margin-left: 320" width="120px" height="50px" src="C:/xampp/htdocs/intranetcercafe/public/logo-rojo.png"></span></h3>
<h2 style="text-align:center">Pedido de Concentrados</h2>
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
<p>Consecutivo # <strong>PCO{{$cons}}</strong></p>
<p>Fecha de Creación:  <strong>{{$fecha_p}}</strong></p>
<p>Fecha de Entrega:  <strong>{{$fecha_e}}</strong></p>
<p>Granja: <strong>{{$granja_pedido}}</strong></p>
<p>Pedido solicitado por: <strong>{!!Auth::User()->nombre_completo!!}</strong></p>

<table class="normal" summary="Tabla genérica">
	<tr>
		<th scope="col">Codigo</th>
		<th scope="col">Producto</th>
		<th scope="col"># Bultos</th>
		<th scope="col"># Kilos</th>
	</tr>
	@foreach($concentrados_solicitados as $c_solicitado)
		<tr>
			<td>{{$c_solicitado['codigo']}}</td>
			<td>{{$c_solicitado['nombre']}}</td>
			<td>{{$c_solicitado['bultos']}}</td>
			<td>{{$c_solicitado['kilos']}}</td>
		</tr>
	@endforeach
</table>
