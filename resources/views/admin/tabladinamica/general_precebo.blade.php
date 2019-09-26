@extends ('template.plantilla')
@section ('content')
	<style>
		thead{
			background: white;
		}
	</style>
	<title>Informes Generales</title>
	<form method="post" action="{{url('admin/general_informe')}}" enctype="application/x-www-form-urlencoded">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
	  	<h2 style="text-align: center;">Informe General De Precebo Y Ceba </h2>
	  	<div class="col-md-12">
		  	<div class="col-md-3">
		  		<select name="option" id="decision" class="form-control">
		  			<option value="">Etapas</option>
		  			<option value="1">Precebo</option>
		  			<option value="2">Ceba</option>
		  		</select>
		  	</div>
		  	<div class="col-md-2">
		        <select  name ="ano" id="selecionar_anno1" class=" form-control">
		            @foreach($anno_precebo as $anno)
		                <option  name="ano" value="{{$anno->año_traslado}}">{{$anno->año_traslado}}</option>
		            @endforeach
		        </select>
		    </div>
		    <div class="col-md-2">
		        <select name="ano1" id="selecionar_anno2" class=" form-control">
		            @foreach($anno_precebo as $anno)
		                <option " value="{{$anno->año_traslado}}">{{$anno->año_traslado}}</option>
		            @endforeach
		        </select>
		    </div>
	  		<button class="btn btn-primary" type="button" id="buscar">Buscar</button>
	  		<button class="btn btn-success" type="submit" id="ExportarGeneral"><img src="http://201.236.212.130:82/intranetcercafe/public/c.png" alt=""> exportar</button>
	    </div>
	    <div style="text-align: center;" id="procesando">
	    	<i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i>
	    </div>
       
	  	<div class="col-md-12">
	        <div class="table-responsive" id="precebo">
	            <table class="table table-hover table-bordered table-condensed dataTables_wrapper nowrap responsive-table">
	                <br>
	                <thead>
	                	<h3>Informe de Precebo</h3>
	                    <tr>
	                        <th>Año</th>
                            <th>Edad Inicial</th>
                            <th>Dias Permanencia</th>
                            <th>Edad Final</th>
                            <th>Fecha Inicial</th>
                            <th class="lote">Lote</th>
                            <th>Fecha Final</th>
                            <th>N° Inicial de animales</th>
							<th>N° Final de animales</th>
							<th>N° DE Muertos de animales</th>
							<th>N° Descarte de animales</th>
							<th class="mortalidad">% Mortalidad</th>
							<th >Peso Total Inicial </th>
							<th class="peso">Peso Promedio Inicial (Kg)</th>
							<th >Peso Total Final (kg)</th>
							<th class="peso">Peso Promedio Final(Kg)</th>
							<th>ganacia de peso total del Lote</th>
							<th>ganancia de peso total por animal</th>
							<th class="peso">ganancia de peso animal por dia</th>
							<th>consumo total de lote</th>
							<th>consumo total por animal</th>
							<th class="peso">consumo total por animal dia</th>
							<th class="peso">conversion</th>                
	                    </tr>
	                </thead>  

	                <tbody id="transportar_datos">

	                </tbody>
	            </table>    
	        </div>
			<div class="table-responsive" id="ceba">
			    <table class="table table-hover table-bordered table-condensed dataTables_wrapper nowrap responsive-table">
			        <br>
			        <thead>
			        	<h3>Informe de Ceba</h3>
			            <tr>
			                <th>Año</th>
                            <th>Edad Inicial</th>
                            <th>Fecha Inicial</th>
                            <th class="peso">Lote</th>
                            <th>Fecha Final</th>
                            <th>N° Inicial animales</th>
                            <th>N° Final animales</th>
                            <th>N° Muertes animales</th>
                            <th>N° Descarte animales</th>
                            <th class="mortalidad">% Mortalidad</th>
                            <th>Peso Total Inicial(Kg)</th>
                            <th class="peso">Peso Promedio Inicial(Kg)</th>
                            <th>Peso Total Final(Kg)</th>
                            <th class="peso">Peso Promedio Final(Kg)</th>
                            <th>Dias Permanencia</th>
                            <th class="peso">Edad Final</th>
                            <th>Ganancia de Peso Total por lote</th>
                            <th>Ganancia de Peso Total por animal</th>
                            <th class="peso">Ganancia de Peso Animal por Dia</th>
                            <th>Consumo Total del Lote</th>
                            <th>Consumo Total Por Dia</th>
                            <th class="peso">Consumo Por Animal Por Dia</th>
                            <th class="peso">Conversion</th>                   
			            </tr>
			        </thead>                
			        <tbody id="transportar_datos_ceba">

			        </tbody>
			    </table>    
			</div>
	  	</div>
	</form>
@endsection