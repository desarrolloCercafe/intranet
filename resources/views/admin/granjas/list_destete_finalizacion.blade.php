@extends('template.plantilla')
@section('content')
	@include('flash::message')
	<title>Destetes Finalizados | Cercafe</title>
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Reportes de Destete y Finalización</h4>
		</div> 
		<br>
		<div class="container-fluid col-lg-12">
			{!!Form::open(['route'=> 'admin.filterDesteteFinalizacion.store', 'class'=>'form-inline', 'method'=>'POST'])!!}
				<h1>Filtrar Informacion:</h1>
				<div class="form-group">
					<input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}"> 
					<select name="granja" class="form-control" id="granja">
						@if(Auth::User()->rol_id == 7)
						<option value="">Seleccione Granja</option>
							@foreach($granjas as $granja)
								<option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>	
							@endforeach
						@else
						<option value="">Seleccione Granja</option>
							@foreach($g_as as $g)
								@if($g->user_id == Auth::User()->id)
									@foreach($granjas as $granja)
										@if($g->granja_id == $granja->id)
											<option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>
										@endif
									@endforeach
								@endif
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					{!!Form::text('lote',null, ['class'=>'form-control', 'placeholder' => 'Ingrese el Lote'])!!}
				</div>
				<div class="form-group">
					{!!Form::text('fecha_desde_finalizacion',null, ['id' => 'date_picker_desde', 'class'=>'form-control', 'readonly', 'required', 'style' => 'cursor: pointer !important;', 'placeholder' => 'Desde'])!!}
				</div>
				<div class="form-group">
					{!!Form::text('fecha_hasta_finalizacion',null, ['id' => 'date_picker_hasta', 'class'=>'form-control', 'readonly', 'required', 'style' => 'cursor: pointer !important;', 'placeholder' => 'Hasta'])!!}
				</div>
				<div class="form-group">
					{!!Form::submit('Filtrar', array('class'=>'btn btn-default'))!!}
				</div>
				<div class="form-group pull-right">
					<a href="javascript:history.go(-1);" class="btn btn-info"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
					@if(Auth::User()->rol_id == 1 || Auth::User()->rol_id == 7)
						<a href="/intranetcercafe/public/admin/excelDesteteFinalizacion" class="btn btn-success" ><i>{!!Html::image('c.png','us',array('class' => 'imuser'))!!} </i> Exportar</a>
					@endif
				</div> 
			{!! Form::close() !!}
		</div>
		<div class="panel-body table-responsive">
			<table id="data_list" class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
						<td><strong>Acción</strong></td>
						<td><strong>Lote</strong></td>
						<td><strong>Granja</strong></td>
						<td><strong>Fecha Inicial</strong></td>
						<td><strong>Fecha Final</strong></td>
						<td><strong>Numero Inicial</strong></td>
					</tr>
				</thead>
				<tbody>
					@if(Auth::User()->rol_id == 7)
						@foreach($destetes as $destete)
							<tr>
								<td>
									<a href="{{ route('admin.desteteFinalizacion.destroy', $destete->id) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Lote"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<a href="{{ route('admin.desteteFinalizacion.show', $destete->id) }}" class="btn btn-default boton_ojo" data-toggle="tooltip" data-placement="top" title="Ver Información Adicional"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a></td>
								<td><strong>{{$destete->lote}}</strong></td>
								<td>{{$destete->nombre_granja}}</td>
								<td>{{$destete->fecha_ingreso_lote}}</td>
								<td>{{$destete->fecha_salida_lote}}</td>
								<td>{{$destete->inic}}</td>
							</tr>	
						@endforeach
					@else
						@foreach($g_as as $g)
							@if($g->user_id == Auth::User()->id)
								@foreach($destetes as $destete)
									@if($g->granja_id == $destete->granja_id)
										@foreach($granjas as $grs)
											@if($destete->nombre_granja == $grs->nombre_granja)
												<tr>
													<td>
														<a href="{{ route('admin.desteteFinalizacion.destroy', $destete->id) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Lote"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
														
														<a href="{{ route('admin.desteteFinalizacion.show', $destete->id) }}" class="btn btn-default boton_ojo" data-toggle="tooltip" data-placement="top" title="Ver Información Adicional"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
													</td>
													<td><strong>{{$destete->lote}}</strong></td>
													<td>{{$destete->nombre_granja}}</td>
													<td>{{$destete->fecha_ingreso_lote}}</td>
													<td>{{$destete->fecha_salida_lote}}</td>
													<td>{{$destete->inic}}</td>
												</tr>
											@endif
										@endforeach
									@endif
								@endforeach
							@endif
						@endforeach
					@endif
				</tbody>
			</table>			
		</div>
	</div>
@endsection