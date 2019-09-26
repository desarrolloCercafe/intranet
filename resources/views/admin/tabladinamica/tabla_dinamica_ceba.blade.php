@extends ('template.plantilla')

@section ('content')
    <style>
        thead{
            background: white;
        }
    </style>
    <title>Informes de Ceba</title>
    {!!Html::script('js/tabla_dinamica_ceba.js')!!}
    <form method="post" action="{{ url('admin/ExcelCeba') }}" enctype="application/x-www-form-urlencoded">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
        <h2 style="text-align: center">Informes de Ceba</h2>
        <div class="col-md-12">
            <div class="col-lg-2 col-xs-12 form-group">
                <select name="granja_ceba" id="granjas_ceba"  class="form-control" style="width: 100% !important;">
                    @if(Auth::User()->rol_id == 7)
                        @foreach($granjas_ceba as $granj)
                            <option value="{{$granj->id}}">{{$granj->nombre_granja}}</option>
                        @endforeach
                    @else
                        @foreach($g_as as $g)
                            @if($g->user_id == Auth::User()->id)
                                @foreach($granjas_ceba as $granj)
                                    @if($g->granja_id == $granj->id)
                                        <option value="{{$granj->id}}">{{$granj->nombre_granja}} </option>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
    
             <div class="col-lg-2 col-xs-12 form-group">
                <select name="ano_mes" id="ano_mes" class="form-control">
                    @foreach($ano_ceba as $anno)
                        <option value="{{$anno->año}}">{{$anno->año}}</option>
                    @endforeach
                </select>
             </div>
    
            <div class="col-lg-3 col-xs-12 form-group">
                <select name="meses[]" id="selecionar_mes" class=" form-control" multiple="multiple" style="width: 100% !important;">
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
    
            <button class="btn btn-primary" type="button" id="filtro_ceba">Filtro</button>
            <button class="btn btn-success" id="exportar_ceba" type="submit"><img src="http://201.236.212.130:82/intranetcercafe/public/c.png" alt=""> exportar</button>
    </form>
        <form method="post" action="{{url('admin/descargar_consulta_ceba') }}" style="display: inline;" target="_blank">
            {{ csrf_field() }}
            <input type="hidden" id="granjas_ceba_hidden" name="granjas_ceba_hidden" readonly>
            <input type="hidden" id="ano_mes_hidden" name="ano_mes_hidden" readonly>
            <input type="hidden" id="selecionar_mes_hidden" name="selecionar_mes_hidden" readonly>


            <script>
                $(document).ready(function() {
                    $("#granjas_ceba_hidden").val($("#granjas_ceba").val());
                    $("#ano_mes_hidden").val($("#ano_mes").val());
                    $("#selecionar_mes_hidden").val($("#parametro_hidden").val());

                    $("#granjas_ceba").change(function() {
                        $("#granjas_ceba_hidden").val($(this).val());
                    })

                    $("#ano_mes").change(function() {
                        $("#ano_mes_hidden").val($(this).val());
                    })

                    $("#selecionar_mes").change(function() {
                        $("#selecionar_mes_hidden").val($(this).val());
                    })
                })
            </script>

            <button class="btn btn-danger" type="submit" id="pdf"><img src="http://201.236.212.130:82/intranetcercafe/public/pdf2.png" alt="pdf" style="height: 25px;">  PDF</button>
        </form>
        </div>     
        <div style="text-align: center;" id="procesando">
            <i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i>
        </div>
    <div class="col-md-12">
        <div class="table-responsive" >
            <table class="table table-hover table-bordered table-condensed dataTables_wrapper nowrap responsive-table">
                <br>
                <thead >
                    <tr>
                        <th></th>
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
                <tbody id="busqueda">                    
                </tbody>
            </table>    
        </div>
    </div>
@endsection