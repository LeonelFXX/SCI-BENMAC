<center style="margin: 10px">
    <h3>Reporte De La Licenciatura: {{ $licenciatura }}</h3>
</center>
<table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
    <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
        <tr>
            <th colspan="2">Datos Generales Por Licenciaturas</th>
        </tr>
        <tr>
            <th>Total ($):</th>
            <th>Total Hojas:</th>
        </tr>
    </thead>
    <tbody
        style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
        @foreach ($totales as $total)
            <tr style="height: 25px">
                <td>$ {{ $total->suma_general_total_gastado }}</td>
                <td>{{ $total->suma_general_total_hojas }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>

<table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
    <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
        <tr>
            <th colspan="2">Color De Impresiones
            </th>
        </tr>
        <tr>
            <th>Color:</th>
            <th>Número De Impresiones:</th>
        </tr>
    </thead>
    <tbody
        style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
        @foreach ($impresiones as $tipo)
            <tr style="height: 25px">
                <td>{{ $tipo->color }}</td>
                <td>{{ $tipo->tipo_color }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>

<table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
    <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
        <tr>
            <th colspan="6">Datos De Usuarios Por Licenciatura</th>
        </tr>
        <tr>
            <th>Matrícula:</th>
            <th>Nombre(s):</th>
            <th>A. Paterno:</th>
            <th>A. Materno:</th>
            <th>Total ($):</th>
            <th>Total Hojas:</th>
        </tr>
    </thead>
    <tbody
        style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
        @foreach ($historial as $his)
            <tr>
                <th>{{ $his->matricula }}</th>
                <td>{{ $his->name }}</td>
                <td>{{ $his->apellido_paterno }}</td>
                <td>{{ $his->apellido_materno }}</td>
                <td>$ {{ $his->suma_total_gastado }}</td>
                <td>{{ $his->suma_total_hojas }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
