@extends ('template.plantilla')

@section ('content')
    <style>
        thead{
            background: white;
        }
    </style>
    <title>Informes de Precebo</title>
    {!!Html::script('js/tabla_dinamica.js')!!}
    <form method="POST" action="{{ url('admin/ExcelPrecebo') }}" enctype="application/x-www-form-urlencoded">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
        <h2 style="text-align: center">Informes de Precebo</h2>
        <div class="col-md-12">
            <div class="col-lg-2 col-xs-12 form-group">
                <select id="granja" name="granja" class="form-control" style="width: 100% !important;">
                    @if(Auth::User()->rol_id == 7)
                        @foreach($granjas as $granja)
                            <option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>
                        @endforeach
                    @else
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
    
            <div class="col-lg-2 col-xs-12 form-group">
                <select name="ano" id="selecionar_anno1" class=" form-control">
                    @foreach($anno_precebo as $anno)
                        <option value="{{$anno->año_traslado}}">{{$anno->año_traslado}}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-lg-3 col-xs-12 form-group">
                <select name="parametros[]" id="selecionar_mes" class="form-control" multiple="multiple" style="width: 100% !important;">
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
            <button class="btn btn-primary" type="button" id="filtro">Filtro</button>
            <button class="btn btn-success" id="exportar_precebo" type="submit"><img src="http://201.236.212.130:82/intranetcercafe/public/c.png" alt=""> exportar</button>  
    </form>
        <form method="post" action="{{url('admin/descargar_consulta') }}" style="display: inline;" target="_blank">

                {{ csrf_field() }}
                <input type="hidden" id="granja_hidden" name="granja_hidden" readonly>
                <input type="hidden" id="ano_hidden" name="ano_hidden" readonly>
                <input type="hidden" id="parametro_hidden" name="parametro_hidden" readonly>
                
                <script>
                    // Aaqui mientras funciona
                    $(document).ready(function() {
                        $("#granja_hidden").val($("#granja").val());
                        $("#ano_hidden").val($("#selecionar_anno1").val());
                        $("#parametro_hidden").val($("#selecionar_mes").val());
                
                        $("#granja").change(function() {
                            $("#granja_hidden").val($(this).val());
                        })
                
                        $("#selecionar_anno1").change(function() {
                            $("#ano_hidden").val($(this).val());
                        })
                
                        $("#selecionar_mes").change(function() {
                            $("#parametro_hidden").val($(this).val());
                        })
                       
                    })
                </script>
                <button class="btn btn-danger" type="submit" id="pdf"><img src="http://201.236.212.130:82/intranetcercafe/public/pdf2.png" alt="pdf" style="height: 25px;">  PDF</button>
        </form>
            <div style="text-align: center;" id="procesando">
                <i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i>
            </div>
        </div>
    <div class="col-md-12">
        <div class="table-responsive" >
            <table class="table table-hover table-bordered table-condensed dataTables_wrapper nowrap responsive-table">
                <br>
                <thead >
                    <tr>
                        <th>Año de traslado</th>
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
                <tbody id="busqueda">                    
                </tbody>
            </table>    
        </div>
    </div>
@endsection