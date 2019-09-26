@extends('template.plantilla')
@section('content')
	@include('flash::message')
    <title>Asignaciones | Cercafe</title>
	<div class="panel panel-danger">
		<div class="panel-heading" id="titulo">
			<h4 style="font-size: 25px;"><i class="fa fa-industry" aria-hidden="true"></i> Granjas Asignadas</h4>
		</div>
		<br>
		<div class="container-fluid">
			<div class="form-group col-lg-6 col-xs-5">
				<ul class="list-inline">
					<li><a href="{{ route('admin.asociacionGranjas.create') }}" type="button" class="btn btn-success btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Permiso</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body">
			<table id="data_list" class="table table-bordered table-hover table-responsive text-center" cellspacing="0" width="100%">
				<thead> 
					<tr style="color: white;">
                      <th>Granja</th>
                      <th>Usuario</th>
                      <th>Opciones</th>
                    </tr>
				</thead>
				<tbody>
					@foreach($g_asociadas as $g_asociada)
                      <tr>
                        <td>{{ $g_asociada->nombre_granja }}</td>
                        <td>{{ $g_asociada->nombre_completo }}</td>
                        <td>
                          <a href="{{ route('admin.asociacionGranjas.destroy', $g_asociada->id) }}" class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminarlo?')">
                            <span class="fa fa-trash"></span>
                          </a>
                        </td>
                      </tr>
                    @endforeach	
				</tbody>
			</table>
		</div>
	</div>
@endsection

