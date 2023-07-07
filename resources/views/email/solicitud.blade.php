<center>
    <h3>¡Hola {{ $usuario->name }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}!</h3>
    <h4>Se acaba de actualizar el estado de tú solicitud de impresión.</h4>
    <p>Folio: {{ $impresion->id }}</p>
    @if ($impresion->estado == 'Autorizado')
        <h4>Autorizado</h4>
        <h5>Descripción: {{ $impresion->descripcion }}</h5>
        <p>Se aprobo tú solicitud de impresión. Puedes reclamarla en el apartado de "Solicitudes De Impresión" en tú
            perfil.</p>
    @elseif ($impresion->estado == 'Denegado')
        <h4>Denegado</h4>
        <h5>Descripción: {{ $impresion->descripcion }}</h5>
        <p>Se denego tú solicitud de impresión.</p>
    @endif
    <p>Atendio: {{ $encargado }}</p>
</center>
