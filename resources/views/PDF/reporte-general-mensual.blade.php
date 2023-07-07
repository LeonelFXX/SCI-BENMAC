<center style="margin: 10px">
    <h3>Reporte General: {{ $diaInicial }} - {{ $mesInicial }} - {{ $añoInicial }} Hasta {{ $diaFinal }} - {{ $mesFinal }} - {{ $añoFinal }}</h3>

    <hr>
    <br>

    <!-- Detalles Sobre El Gasto En Impresiones - PAGADAS -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="3">Detalles Sobre El Gasto En Impresiones Pagadas</th>
            </tr>
            <tr>
                <th>Total ($)</th>
                <th>Total Impresiones</th>
                <th>Total Hojas</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
            @foreach ($totales_generales as $total_general)
                <tr style="height: 25px">
                    <td>$ {{ $total_general->total_gastado_todas_licenciaturas }}</td>
                    <td>{{ $total_general->total_impresiones_todas_licenciaturas }}</td>
                    <td>{{ $total_general->total_hojas_todas_licenciaturas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <!-- Detalles Sobre El Total De Impresiones - NO PAGO -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="2">Detalles Sobre El Total En Impresiones No Pago</th>
            </tr>
            <tr>
                <th>Total Impresiones</th>
                <th>Total Hojas</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
            @foreach ($totales_generales_no_pago as $total_general)
                <tr style="height: 25px">
                    <td>{{ $total_general->total_impresiones_todas_licenciaturas }}</td>
                    <td>{{ $total_general->total_hojas_todas_licenciaturas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <hr>
    <br>

    <!-- Detalles Sobre El Color En Impresiones -->
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
                <th>Color</th>
                <th>Número De Impresiones</th>
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
    <hr>
    <br>

    <!-- Detalles Sobre El Gasto Por Licenciaturas -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="4">Detalles De Gasto En Impresiones Por Licenciaturas & Labor Administrativa</th>
            </tr>
            <tr>
                <th>Licenciatura</th>
                <th>Total ($)</th>
                <th>Total Impresiones</th>
                <th>Total Hojas</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
            @foreach ($totales_licenciatura as $total_licenciatura)
                <tr>
                    <td>{{ $total_licenciatura->licenciatura }}</td>
                    <td>$ {{ $total_licenciatura->total_gastado_por_licenciatura }}</td>
                    <td>{{ $total_licenciatura->total_impresiones_por_licenciatura }}</td>
                    <td>{{ $total_licenciatura->total_hojas_por_licenciatura }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</center>
