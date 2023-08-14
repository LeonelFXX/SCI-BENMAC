@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-around">
            <div class="col-md-10 mt-2">

                <!-- Mensajes De Éxito -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Éxito!</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Mensajes De Error -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <strong>¡Error!</strong> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        @endforeach
                    </div>
                @endif

                <!-- Mensajes De Error En Checkboxes -->
                @if ($errors->has('sin_engargolado') || $errors->has('engargolado'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>¡Error!</strong> Debes seleccionar al menos una opción.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card text-center shadow-lg">
                            <div class="card-header" id="bg-blue-benmac">
                                Bienvenido {{ Auth::user()->name }}
                                <img src="https://cdn-icons-png.flaticon.com/512/64/64572.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('assets/img/escudo.jpg') }}" class="rounded" alt="BENMAC"
                                    width="100px" height="100px">
                                <h5 class="card-title mt-2">
                                    {{ Auth::user()->name }}
                                    {{ Auth::user()->apellido_paterno }}
                                    {{ Auth::user()->apellido_materno }}
                                </h5>
                                <!-- Licenciatura || Labor Administrativa -->
                                @if (Auth::user()->tipo_usuario === '6')
                                    <p class="card-text">Carrera: {{ Auth::user()->licenciatura }}<br>
                                        Matrícula: {{ Auth::user()->matricula }}</p>
                                @else
                                    <p class="card-text">Labor: {{ Auth::user()->licenciatura }}<br>
                                        Clave Administrativa: {{ Auth::user()->matricula }}</p>
                                @endif
                                <!-- Color Saldo -->
                                @if (Auth::user()->saldo == 0)
                                    <h3><span class="badge bg-danger">$ {{ Auth::user()->saldo }}</span></h3>
                                @else
                                    <h3><span class="badge bg-success">$ {{ Auth::user()->saldo }}</span></h3>
                                @endif

                            </div>
                            <div class="card-footer text-muted">
                                @if (Auth::user()->saldo > 0)
                                    <!-- Modal: Imprimir -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal02">
                                        Imprimir
                                        <img src="https://cdn-icons-png.flaticon.com/512/2874/2874791.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </button>
                                    <!-- Modal: Imprimir -->
                                    <div class="modal fade" id="exampleModal02" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" id="bg-blue-benmac">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Configura Tú Impresión
                                                        <img src="https://cdn-icons-png.flaticon.com/512/2874/2874791.png"
                                                            alt="BENMAC" class="icon-benmac">
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('imprimir') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <!-- Número De Hojas -->
                                                            <div class="col-md-12 mb-2">
                                                                <div class="form-outline">
                                                                    <h6 class="h6">
                                                                        Número De Hojas
                                                                    </h6>
                                                                    <input type="number" id="numero_hojas"
                                                                        class="form-control @error('numero_hojas') is-invalid @enderror"
                                                                        placeholder="#" name="numero_hojas"
                                                                        value="{{ old('numero_hojas') }}" required
                                                                        autofocus />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <!-- Número De Copias -->
                                                            <div class="col-md-12 mb-2">
                                                                <div class="form-outline">
                                                                    <label class="form-label" for="numero_copias">Número De
                                                                        Copias</label>
                                                                    <input type="number" id="numero_copias"
                                                                        class="form-control @error('numero_copias') is-invalid @enderror"
                                                                        placeholder="#" name="numero_copias"
                                                                        value="{{ old('numero_copias') }}" required
                                                                        autofocus />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <!-- Tamaño -->
                                                            <div class="col-md-12 mb-2">
                                                                <label class="form-label" for="autoSizingSelect">
                                                                    Tamaño De Papel
                                                                </label>
                                                                <select class="form-select" id="autoSizingSelect"
                                                                    name="tamaño">
                                                                    <option selected disabled>Escoge Una Opción...
                                                                    </option>
                                                                    <option value="Carta">Carta</option>
                                                                    <option value="Oficio">Oficio</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <!-- Impresora -->
                                                            <div class="col-md-12 mb-2">
                                                                <label class="form-label" for="autoSizingSelect01">
                                                                    Impresora, Color Y Ubicación
                                                                </label>
                                                                <select class="form-select" id="autoSizingSelect01"
                                                                    name="impresora">
                                                                    <option selected disabled>
                                                                        Escoge Una Opción...
                                                                    </option>
                                                                    @foreach ($printers as $printer)
                                                                        <option value="{{ $printer->id }}">
                                                                            {{ $printer->nombre }} ({{ $printer->color }})
                                                                            {{ $printer->ubicacion }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <!-- Engargolado -->
                                                            <div class="col-md-12 mb-2 d-flex justify-content-evenly">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="1" id="checkbox1"
                                                                        name="sin_engargolado" checked>
                                                                    <label class="form-check-label" for="checkbox1">
                                                                        Sin Engargolado
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="2" id="checkbox2"
                                                                        name="con_engargolado">
                                                                    <label class="form-check-label" for="checkbox2">
                                                                        Con Engargolado
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-grid gap-2 pt-2">
                                                            <button type="submit" class="btn" id="bg-blue-benmac">
                                                                Continuar
                                                                <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                    alt="BENMAC" class="icon-benmac">
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal: Engargolado -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Engargolar
                                        <img src="https://cdn-icons-png.flaticon.com/512/3388/3388622.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </button>
                                    <!-- Modal: Engargolado -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" id="bg-blue-benmac">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Solicitar Engargolado
                                                        <img src="https://cdn-icons-png.flaticon.com/512/3388/3388622.png"
                                                            alt="BENMAC" class="icon-benmac">
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('enviarSolicitud') }}">
                                                        @csrf
                                                        <h5 class="h5">
                                                            ¿Quiéres solicitar un engargolado?
                                                        </h5>
                                                        <h6 class="h6">Se creará una solicitud que podrás presentar
                                                            para que realicen tu engargolado, puedes cancelar esta solicitud
                                                            en el apartado de "Solicitudes De Engargolados" de tu perfil.
                                                        </h6>
                                                        <div class="d-grid gap-2 pt-2">
                                                            <button type="submit" class="btn" id="bg-blue-benmac">
                                                                Solicitar
                                                                <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                    alt="BENMAC" class="icon-benmac">
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal: Copias -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal10">
                                        Solicitar Copias
                                        <img src="https://cdn-icons-png.flaticon.com/512/4700/4700444.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </button>
                                    <!-- Modal: Copias -->
                                    <div class="modal fade" id="exampleModal10" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" id="bg-blue-benmac">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Configura Tú Solicitud De Copias
                                                        <img src="https://cdn-icons-png.flaticon.com/512/4700/4700444.png"
                                                            alt="BENMAC" class="icon-benmac">
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('solicitarCopias') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <!-- Número De Hojas A Color -->
                                                            <div class="col-md-12 mb-2">
                                                                <div class="form-outline">
                                                                    <label class="form-label" for="color">
                                                                        Número De Hojas A Color
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                                            alt="BENMAC" class="icon-benmac">
                                                                    </label>
                                                                    <input type="number" id="color"
                                                                        class="form-control @error('color') is-invalid @enderror"
                                                                        placeholder="0" name="color"
                                                                        value="{{ old('color') }}" required autofocus />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <!-- Número De Copias A Blanco Y Negro -->
                                                            <div class="col-md-12 mb-2">
                                                                <div class="form-outline">
                                                                    <label class="form-label" for="blanco_y_negro">
                                                                        Número De Hojas A Blanco Y Negro
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                                            alt="BENMAC" class="icon-benmac-gray">
                                                                    </label>
                                                                    <input type="number" id="blanco_y_negro"
                                                                        class="form-control @error('blanco_y_negro') is-invalid @enderror"
                                                                        placeholder="0" name="blanco_y_negro"
                                                                        value="{{ old('blanco_y_negro') }}" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-grid gap-2 mt-2 pt-2">
                                                            <button type="submit" class="btn" id="bg-blue-benmac">
                                                                Solicitar
                                                                <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                    alt="BENMAC" class="icon-benmac">
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Modal: Sin Saldo -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal01">
                                        Sin Saldo
                                        <img src="https://cdn-icons-png.flaticon.com/512/2780/2780808.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </button>
                                    <!-- Modal: Sin Saldo -->
                                    <div class="modal fade" id="exampleModal01" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" id="bg-blue-benmac">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        ¡Sin Saldo!
                                                        <img src="https://cdn-icons-png.flaticon.com/512/2780/2780808.png"
                                                            alt="BENMAC" class="icon-benmac">
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="h5">No cuentas con saldo para realizar
                                                        impresiones.</h5>
                                                    <h6 class="h6">Por favor, solicita una recarga de saldo.
                                                    </h6>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @role('Administrador_General|Personal_Administrativo')
                                    <!-- Modal: Solicitar Impresión -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal05">
                                        Solicitar Impresión
                                        <img src="https://cdn-icons-png.flaticon.com/512/2874/2874791.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </button>
                                    <!-- Modal: Solicitar Impresión -->
                                    <div class="modal fade" id="exampleModal05" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" id="bg-blue-benmac">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Solicitar Una Impresión "No Pago"
                                                        <img src="https://cdn-icons-png.flaticon.com/512/2874/2874791.png"
                                                            alt="BENMAC" class="icon-benmac">
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('solicitarImpresion') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <!-- Número De Hojas -->
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <h6 class="h6">
                                                                        Número De Hojas
                                                                    </h6>
                                                                    <input type="number" id="numero_hojas"
                                                                        class="form-control @error('numero_hojas') is-invalid @enderror"
                                                                        placeholder="#" name="numero_hojas"
                                                                        value="{{ old('numero_hojas') }}" required
                                                                        autofocus />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!-- Número De Copias -->
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="numero_copias">
                                                                        Número
                                                                        De
                                                                        Copias</label>
                                                                    <input type="number" id="numero_copias"
                                                                        class="form-control @error('numero_copias') is-invalid @enderror"
                                                                        placeholder="#" name="numero_copias"
                                                                        value="{{ old('numero_copias') }}" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <!-- Tamaño -->
                                                            <div class="col-md-12 mb-2">
                                                                <label class="form-label" for="autoSizingSelect">
                                                                    Tamaño De Papel
                                                                </label>
                                                                <select class="form-select" id="autoSizingSelect"
                                                                    name="tamaño">
                                                                    <option selected disabled>Escoge Una Opción...
                                                                    </option>
                                                                    <option value="Carta">Carta</option>
                                                                    <option value="Oficio">Oficio</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <!-- Impresora -->
                                                            <div class="col-md-12 mb-2">
                                                                <label class="form-label" for="autoSizingSelect01">
                                                                    Impresora, Color Y Ubicación
                                                                </label>
                                                                <select class="form-select" id="autoSizingSelect01"
                                                                    name="impresora">
                                                                    <option selected disabled>
                                                                        Escoge Una Opción...
                                                                    </option>
                                                                    @foreach ($printers as $printer)
                                                                        <option value="{{ $printer->id }}">
                                                                            {{ $printer->nombre }} ({{ $printer->color }})
                                                                            {{ $printer->ubicacion }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2 mb-2">
                                                            <div class="form-group">
                                                                <label for="descripcion" class="mb-2">
                                                                    Justifica La Impresión
                                                                </label>
                                                                <textarea class="form-control" id="descripcion" rows="2" name="descripcion"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="d-grid gap-2 pt-2">
                                                            <button type="submit" class="btn" id="bg-blue-benmac">
                                                                Solicitar
                                                                <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                    alt="BENMAC" class="icon-benmac">
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endrole
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center shadow-lg">
                            <div class="card-header" id="bg-blue-benmac">
                                Precios De Impresiones
                                <img src="https://cdn-icons-png.flaticon.com/512/1/1437.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Blanco Y Negro -->
                                    <div class="col-md-12 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">
                                                Blanco Y Negro
                                                <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                    alt="BENMAC" class="icon-benmac-gray">
                                            </label>
                                            <h4 class="h4">
                                                <span class="badge bg-success bg-sm">$
                                                    {{ $price->blanco_y_negro }} MXN
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Color -->
                                    <div class="col-md-12 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="matricula">
                                                Color
                                                <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                    alt="BENMAC" class="icon-benmac">
                                            </label>
                                            <h4 class="h4">
                                                <span class="badge bg-success bg-sm">
                                                    $ {{ $price->color }} MXN
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Engargolado -->
                                    <div class="col-md-12 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="matricula">
                                                Engargolado
                                                <img src="https://cdn-icons-png.flaticon.com/512/829/829552.png"
                                                    alt="BENMAC" class="icon-benmac">
                                            </label>
                                            <h4 class="h4">
                                                <span class="badge bg-success bg-sm">
                                                    $ {{ $price->engargolado }} MXN
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
