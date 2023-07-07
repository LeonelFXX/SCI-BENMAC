<center style="margin: 10px">
    <h3>Reporte De La Licenciatura: {{ $licenciatura }}</h3>
    <h3>Periodo: {{ $diaInicial }} - {{ $mesInicial }} - {{ $añoInicial }} Hasta {{ $diaFinal }} -
        {{ $mesFinal }} - {{ $añoFinal }}</h3>

    <hr>
    <br>

    <!-- Detalles Sobre Impresiones -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="2">Detalles Generales Sobre Impresiones</th>
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
            @foreach ($totales_generales as $total)
                <tr style="height: 25px">
                    <td>{{ $total->total_impresiones_todas_licenciaturas }}</td>
                    <td>{{ $total->suma_general_total_hojas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <hr>
    <br>

    <!-- Detalles Sobre Gasto En Impresiones - PAGADAS -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="3">Detalles De Gasto En Impresiones Pagadas Por Licenciatura</th>
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
            @foreach ($totales as $total)
                <tr style="height: 25px">
                    <td>$ {{ $total->suma_general_total_gastado }}</td>
                    <td>{{ $total->total_impresiones_todas_licenciaturas }}</td>
                    <td>{{ $total->suma_general_total_hojas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    @if ($licenciatura == 'Personal Administrativo')
        <!-- Detalles Sobre Impresiones - NO PAGO -->
        <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
            <thead
                style="background: #131921;
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
                @foreach ($totales_no_pago as $total)
                    <tr style="height: 25px">
                        <td>{{ $total->total_impresiones_todas_licenciaturas }}</td>
                        <td>{{ $total->suma_general_total_hojas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

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

    <!-- Detalles Sobre Engargolados - PAGADOS -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="2">Detalles Sobre Engargolados Pagados</th>
            </tr>
            <tr>
                <th>Total ($)</th>
                <th>Total Engargolados</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
            @foreach ($engargolados as $datos)
                <tr style="height: 25px">
                    <td>$ {{ $datos->total_coste_engargolados }}</td>
                    <td>{{ $datos->suma_total_engargolados }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <hr>
    <br>

    @if ($licenciatura == 'Personal Administrativo')
        <!-- Detalles Sobre Impresiones - NO PAGO -->
        <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
            <thead
                style="background: #131921;
                        color: #fff;
                        height: 70px;">
                <tr>
                    <th colspan="5">Detalles De Usuarios Con Impresiones No Pago</th>
                </tr>
                <tr>
                    <th>Matrícula</th>
                    <th>T. Hojas</th>
                    <th>Descripción</th>
                    <th>Encargado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody
                style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
                @foreach ($historial_no_pago as $his)
                    <tr>
                        <th>{{ $his->matricula }}</th>
                        <td>{{ $his->total_hojas }}</td>
                        <td>{{ $his->descripcion }}</td>
                        <td>{{ $his->encargado }}</td>
                        <td>{{ $his->fecha_impresion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <br>

    <!-- Detalles De Usuarios Con Impresiones - PAGADAS -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="7">Detalles De Usuarios Con Impresiones Pagadas</th>
            </tr>
            <tr>
                <th>Matrícula</th>
                <th>Nombre(s)</th>
                <th>A. Paterno</th>
                <th>A. Materno</th>
                <th>N. Impresiones</th>
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
                    <td>{{ $his->veces_impreso }}</td>
                    <td>$ {{ $his->suma_total_gastado }}</td>
                    <td>{{ $his->suma_total_hojas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</center>
