<center style="margin: 10px">
    <h3>Reporte Individual:
        {{ $usuario->name }}
        {{ $usuario->apellido_paterno }}
        {{ $usuario->apellido_materno }}
    </h3>
</center>
<table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
    <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
        <tr>
            <th colspan="2">Datos Generales De
                {{ $usuario->name }}
            </th>
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
        <tr style="height: 25px">
            @foreach ($totales as $total)
                <td>$ {{ $total->suma_total_gastado }}</td>
                <td>{{ $total->suma_total_hojas }}</td>
            @endforeach
        </tr>
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
            <th colspan="9">Datos De Usuario</th>
        </tr>
        <tr>
            <th>Matrícula:</th>
            <th>Nombre(s):</th>
            <th>A. Paterno:</th>
            <th>A. Materno:</th>
            <th>Licenciatura</th>
            <th>Impresora</th>
            <th>Total De Hojas:</th>
            <th>Fecha De Impresión</th>
            <th>Coste De Impresión</th>
        </tr>
    </thead>
    <tbody
        style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
        @foreach ($historial as $his)
            <tr>
                <td>{{ $his->matricula }}</td>
                <td>{{ $his->name }}</td>
                <td>{{ $his->apellido_paterno }}</td>
                <td>{{ $his->apellido_materno }}</td>
                <td>{{ $his->licenciatura }}</td>
                <td>{{ $his->impresora }}</td>
                <td>{{ $his->total_hojas }}</td>
                <td>{{ $his->fecha_impresion }}</td>
                <td>$ {{ $his->coste_impresion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
