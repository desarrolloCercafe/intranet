@extends ('template.plantilla')
@section ('content')
    <style>
        thead{
            background: white;
        }
    </style>
    <title>Consolidados Cercafe</title>
    {!!Html::script('js/ConsolidacionCercafe.js')!!}
	    <form method="post" action="{{url('admin/ConsolidacionExcel')}}" enctype="application/x-www-form-urlencoded">
       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
        <h2 style="text-align: center">Consolidacion Cercafe </h2>
        <div class="container-fluid">
            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                <select name="option" id="decision" class="form-control">
                    <option value="">Etapa</option>
                    <option value="1">Precebo</option>
                    <option value="2">Ceba</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                <select id="granja" name="granja" class="form-control">
                    @foreach($granjas as $granja)
                        <option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                <select name="ano" id="selecionar_anno1" class=" form-control">
                    @foreach($anno_precebo as $anno)
                        <option value="{{$anno->año_traslado}}">{{$anno->año_traslado}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                <select name="parametros[]" id="selecionar_mes" class=" form-control" multiple="multiple">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>

            <div class="col-lg-6 col-xs-6">
                <button class="btn btn-primary" type="button" id="filtro">Filtro</button>
                <button class="btn btn-success" type="submit"><img src="http://201.236.212.130:82/intranetcercafe/public/c.png" alt=""> exportar</button>
            </div>
              
            <div style="text-align: center;" id="procesando">
                <i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i>
            </div>

            <div class="col-md-12">
                <div class="table-responsive" id="consolidado_precebo">
                    <table style=" margin:0 0 -20px 20em;">
                        <tr>  
                            <th>Consolidado</th>
                        </tr>
                    </table>

                    <table class="table table-hover table-bordered table-condensed dataTables_wrapper nowrap responsive-table">
                        <br>
                        <thead >
                            <tr>
                                <th>Precebo</th>
                                <th>Edad Inicial</th>
                                <th>Dias Permanencia</th>
                                <th>Edad Final</th>
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
                        <tbody id="consolidado">
                        </tbody>
                    </table>
                </div>
                
                <div class="table-responsive" id="Consolidado_ceba">
                    <table style=" margin:0 0 -20px 20em;">
                        <tr>  
                            <th>Consolidado</th>
                        </tr>
                    </table>
                    <table class="table table-hover table-bordered table-condensed dataTables_wrapper nowrap responsive-table">
                        <br>
                        <thead >
                            <tr>
                                <th>Ceba</th>
                                <th>Edad Inicial</th>
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
                                <th class="peso">Convercion</th>                   
                            </tr>
                        </thead>                
                        <tbody id="ConsolidadoCeba">
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </form>
@endsection