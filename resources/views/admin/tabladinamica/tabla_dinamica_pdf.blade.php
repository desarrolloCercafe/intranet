<div class="page-header">
    <h3>Intranet Cercafe <span><img style="margin-left: 92%;" width="120px" height="60px" src="C:/xampp/htdocs/intranetcercafe/public/logo-rojo.png"></span></h3>
    <h1 style="text-align: center">Informe Precebo </h1>
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
<div>
    <table>{{--  table-responsive --}}
        <thead>
            <tr>
                <th>Edad Inicial</th>
                <th>Dias Permanencia</th>
                <th>Edad Final</th>
                <th>Fecha Inicial</th>
                <th>Lote</th>
                <th>Fecha Final</th>
                <th>N° Inicial </th>
                <th>N° Final </th>
                <th>N° DE Muertos </th>
                <th>N° Descarte</th>
                <th>% Mortalidad</th>
                <th>Peso Total Inicial </th>
                <th>Peso Promedio Inicial (Kg)</th>
                <th>Peso Total Final (kg)</th>
                <th>Peso Promedio Final(Kg)</th>
                <th>ganacia de peso total del Lote</th>
                <th>ganancia de peso total por animal</th>
                <th>ganancia de peso animal por dia</th>
                <th>consumo total de lote</th>
                <th>consumo total por animal</th>
                <th>consumo total por animal dia</th>
                <th>conversion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($precebo as $precebo)
                <tr>
                    <td>{{ $precebo->edad_destete }}</td>
                    <td>{{ $precebo->dias_permanencia }}</td>
                    <td>{{ $precebo->edad_final }}</td>
                    <td>{{ $precebo->fecha_destete }}</td>
                    <td><strong>{{ $precebo->lote }}</strong></td>
                    <td>{{ $precebo->fecha_traslado }}</td>
                    <td>{{ $precebo->numero_inicial }}</td>
                    <td>{{ $precebo->numero_final }}</td>
                    <td>{{ $precebo->numero_muertes }}</td>
                    <td>{{ $precebo->numero_descartes }}</td>
                    <td style="color: red;"> {{ $precebo->porciento_mortalidad }}</td>
                    <td>{{ $precebo->peso_ini }}</td>
                    <td>{{ $precebo->peso_promedio_ini }}</td>
                    <td>{{ $precebo->peso_fin }}</td>
                    <td>{{ $precebo->peso_promedio_fin }}</td>
                    <td>{{ $precebo->ganancia }}</td>
                    <td>{{ $precebo->ato_promedio_fin }}</td>
                    <td><strong>{{ $precebo->ato_promedio_dia_fin }}</strong></td>
                    <td>{{ $precebo->cons_total }}</td>
                    <td>{{ $precebo->cons_promedio }}</td>
                    <td>{{ $precebo->cons_promedio_dia_ini }}</td>
                    <td>{{ $precebo->conversion_ajust_fin }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
