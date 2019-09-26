<div class="page-header">
    <h3>Intranet Cercafe <span><img style="margin-left: 92%;" width="120px" height="60px" src="C:/xampp/htdocs/intranetcercafe/public/logo-rojo.png"></span></h3>
    <h1 style="text-align: center">Informe Ceba</h1>
</div>
<style>
    th{
        background-color: #DF0101;
        color: white;
    }

    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }
</style>

<div style="overflow-x:auto;">
    <table>
        <thead >
            <tr>
                <th>Edad Inicial</th>
                <th>Fecha Inicial</th>
                <th >Lote</th>
                <th>Fecha Final</th>
                <th>N° Inicial </th>
                <th>N° Final </th>
                <th>N° Muertes </th>
                <th>N° Descarte </th>
                <th >% Mortalidad</th>
                <th>Ps Total Inicial</th>
                <th class="peso">Ps Promedio Inicial</th>
                <th>Ps Total Final</th>
                <th class="peso">Ps Promedio Final</th>
                <th>Dias Permanencia</th>
                <th class="peso">Edad Final</th>
                <th>Ganancia de Ps Total por lote</th>
                <th>Ganancia de Ps Total por animal</th>
                <th class="peso">Ganancia Ps Animal por Dia</th>
                <th>Cons T. del Lote</th>
                <th>Cons T. Por Dia</th>
                <th class="peso">Cons Por Dia</th>
                <th class="peso">Convercion</th>                   
            </tr>
        </thead>
        <tbody>
            @foreach($ceba as $ceba)
                <tr>
                    <td>{{$ceba->edad_inicial}}</td>
                    <td>{{$ceba->fecha_ingreso_lote}}</td>
                    <td><strong>{{$ceba->lote}}</strong></td>
                    <td>{{$ceba->fecha_salida_lote}}</td>
                    <td>{{$ceba->inic}}</td>
                    <td>{{$ceba->cant_final_cerdos}}</td>
                    <td>{{$ceba->muertes}}</td>
                    <td>{{$ceba->cerdos_descartados}}</td>
                    <td style="color: red">{{$ceba->por_mortalidad}}</td>
                    <td>{{$ceba->peso_total_ingresado}}</td>
                    <td>{{$ceba->peso_promedio_ingresado}}</td>
                    <td>{{$ceba->peso_total_vendido}}</td>
                    <td>{{$ceba->peso_promedio_vendido}}</td>
                    <td>{{round($ceba->dias_permanencia)}}</td>
                    <td>{{$ceba->edad_final}}</td>
                    <td>{{$ceba->ganancia_lote_ceba}}</td>
                    <td>{{round($ceba->ato_promedio_dia_fin,2)}}</td>
                    <td>{{round($ceba->ato_promedio_fin,3)}}</td>
                    <td>{{$ceba->consumo_lote}}</td>
                    <td>{{round($ceba->final,2)}}</td>
                    <td>{{round($ceba->cons_promedio_dia_ini,2) }}</td>
                    <td>{{round($ceba->conversion_ajust_fin,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>