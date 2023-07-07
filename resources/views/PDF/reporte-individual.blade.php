<center style="margin: 10px">
    <h3>Reporte Individual:
        {{ $usuario->name }}
        {{ $usuario->apellido_paterno }}
        {{ $usuario->apellido_materno }}
    </h3>

    <hr>
    <br>

    <!-- Datos De Usuario -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="6">Datos Personales Del Usuario</th>
            </tr>
            <tr>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>A. Paterno</th>
                <th>A. Materno</th>
                <th>Licenciatura</th>
                <th>Saldo Actual</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
            <tr style="height: 25px">
                <td>{{ $usuario->matricula }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->apellido_paterno }}</td>
                <td>{{ $usuario->apellido_materno }}</td>
                <td>{{ $usuario->licenciatura }}</td>
                <td>$ {{ $usuario->saldo }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <!-- Datos De Contacto -->
    <table style="margin: 0 auto;
      font-family: Arial, Helvetica, sans-serif;
      width: 650px;">
        <thead style="background: #131921;
                  color: #fff;
                  height: 70px;">
            <tr>
                <th colspan="2">Datos De Contacto Del Usuario</th>
            </tr>
            <tr>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
              text-align: center;
              background: #a5a19d;">
            <tr style="height: 25px">
                <td>{{ $usuario->telefono }}</td>
                <td>{{ $usuario->email }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <hr>
    <br>

    <!-- Detalles Sobre Gasto En Impresiones -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="2">Detalles Sobre El Gasto En Impresiones</th>
            </tr>
            <tr>
                <th>Total ($)</th>
                <th>Total Hojas</th>
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

    <!-- Detalles Sobre El Gasto En Engargolados -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="2">Detalles Sobre El Gasto En Engargolados</th>
            </tr>
            <tr>
                <th>Total ($)</th>
                <th>Engargolados Pagados</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
                    text-align: center;
                    background: #a5a19d;">
            @foreach ($totales_engargolados as $datos)
                <tr style="height: 25px">
                    <td>$ {{ $datos->total_gastado_engargolados }}</td>
                    <td>{{ $datos->solicitudes_engargolados }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <!-- Detalles Sobre Color En Impresiones -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="2">Detalles Sobre El Color De Impresiones</th>
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

    <!-- Detalles Sobre Engargolados -->
    <table style="margin: 0 auto;
     font-family: Arial, Helvetica, sans-serif;
     width: 650px;">
        <thead style="background: #131921;
                 color: #fff;
                 height: 70px;">
            <tr>
                <th colspan="6">Detalles Sobre Engargolados Pagados</th>
            </tr>
            <tr>
                <th>Folio</th>
                <th>Folio De Impresión</th>
                <th>Coste</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Encargado</th>
            </tr>
        </thead>
        <tbody
            style="font-family: Arial, Helvetica, sans-serif;
             text-align: center;
             background: #a5a19d;">
            @foreach ($engargolados as $datos)
                <tr style="height: 25px">
                    <td>{{ $datos->id }}</td>
                    @if ($datos->impresion_id == null)
                        <td>Sin Impresión</td>
                    @else
                        <td>{{ $datos->impresion_id }}</td>
                    @endif
                    <td>{{ $datos->coste_engargolado }}</td>
                    <td>{{ $datos->fecha_engargolado }}</td>
                    <td>{{ $datos->estado }}</td>
                    @if ($datos->encargado == null)
                        <td>Sin Realizar
                        <td>
                        @else
                        <td>{{ $datos->encargado }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    @if ($usuario->licenciatura == 'Personal Administrativo')
        <!-- Detalles Sobre Impresiones - NO PAGO -->
        <table style="margin: 0 auto;
    font-family: Arial, Helvetica, sans-serif;
    width: 650px;">
            <thead style="background: #131921;
            color: #fff;
            height: 70px;">
                <tr>
                    <th colspan="7">Detalles Sobre Impresiones No Pago</th>
                </tr>
                <tr>
                    <th>Matrícula</th>
                    <th>Impresora</th>
                    <th>T. Hojas</th>
                    <th>Engargolado</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Encargado</th>
                </tr>
            </thead>
            <tbody
                style="font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        background: #a5a19d;">
                @foreach ($impresiones_no_pago as $his)
                    <tr>
                        <td>{{ $his->matricula }}</td>
                        <td>{{ $his->impresora }}</td>
                        <td>{{ $his->total_hojas }}</td>
                        <td>{{ $his->engargolado }}</td>
                        <td>{{ $his->descripcion }}</td>
                        <td>{{ $his->fecha_impresion }}</td>
                        <td>{{ $his->encargado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <br>

    <!-- Detalles Sobre Impresiones - PAGADAS -->
    <table style="margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            width: 650px;">
        <thead style="background: #131921;
                        color: #fff;
                        height: 70px;">
            <tr>
                <th colspan="10">Detalles Sobre Impresiones Pagadas</th>
            </tr>
            <tr>
                <th>Folio</th>
                <th>N. Hojas</th>
                <th>N. Copias</th>
                <th>Tamaño</th>
                <th>Color</th>
                <th>Impresora</th>
                <th>Total De Hojas</th>
                <th>Engargolado</th>
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
                    <td>{{ $his->id }}</td>
                    <td>{{ $his->numero_hojas }}</td>
                    <td>{{ $his->numero_copias }}</td>
                    <td>{{ $his->tamaño }}</td>
                    <td>{{ $his->color }}</td>
                    <td>{{ $his->impresora }}</td>
                    <td>{{ $his->total_hojas }}</td>
                    <td>{{ $his->engargolado }}</td>
                    <td>{{ $his->fecha_impresion }}</td>
                    <td>$ {{ $his->coste_impresion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</center>
