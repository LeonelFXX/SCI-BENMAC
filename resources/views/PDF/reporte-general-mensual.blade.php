<center style="margin: 10px">
    <h3>Reporte General: {{ $diaInicial }} - {{ $mesInicial }} - {{ $añoInicial }} Hasta {{ $diaFinal }} -
        {{ $mesFinal }} - {{ $añoFinal }}</h3>

    <hr>
    <br>

    <!-- Detalles Sobre Recargos -->
    <table style="margin: 0 auto;
      font-family: Arial, Helvetica, sans-serif;
      width: 650px;">
        <thead style="background: #131921;
                  color: #fff;
                  height: 70px;">
            <tr>
                <th colspan="2">Detalles Generales Sobre Recargas</th>
            </tr>
            <tr>
                <th>Número De Recargas</th>
                <th>Total ($)</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
              text-align: center;
              background: #a5a19d;">
            <tr style="height: 25px">
                @foreach ($recargas as $datos)
                    <td>{{ $datos->veces_recargos }}</td>
                    <td>$ {{ $datos->total_recargado }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

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

    <!-- Detalles Sobre El Gasto En Copias -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="3">Detalles Sobre El Gasto En Copias</th>
            </tr>
            <tr>
                <th>Solicitudes De Copiado</th>
                <th>Total De Hojas</th>
                <th>Total ($)</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
            @foreach ($copias as $datos)
                <tr style="height: 25px">
                    <td>{{ $datos->num_copias }}</td>
                    <td>{{ $datos->total_copias }}</td>
                    <td>$ {{ $datos->coste_total }}</td>
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
