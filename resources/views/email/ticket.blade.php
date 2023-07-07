<center>
    <h3>¡Hola {{ $usuario->name }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}!</h3>
    <h4>Acabas de recargar saldo para impresiones o engargolados.</h4>
    <p>Monto: ${{ $cantidad }} MXN</p>
    <p>Fecha: {{ $fecha }}</p>
    <p>Atendio: {{ $encargado }}</p>
</center>