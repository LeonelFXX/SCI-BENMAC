@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-around">
            <div class="col-md-10">

                <!-- Mensajes De Éxito -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <strong>Éxito En La Acción.</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Mensajes De Error -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        @foreach ($errors->all() as $error)
                            <strong>Error En La Acción.</strong> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        @endforeach
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8 mt-2">
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

                                {{-- Muestra Licenciatura OR Labor --}}
                                @if (Auth::user()->tipo_usuario === '3' || Auth::user()->tipo_usuario === 'Estudiante')
                                    <p class="card-text">Carrera: {{ Auth::user()->licenciatura }}<br>
                                    Matrícula: {{ Auth::user()->matricula }}</p>
                                @else
                                    <p class="card-text">Labor: {{ Auth::user()->licenciatura }}<br>
                                    Clave Administrativa: {{ Auth::user()->matricula }}</p>
                                @endif

                                {{-- Color Saldo --}}
                                @if (Auth::user()->saldo == 0)
                                    <h3><span class="badge bg-danger">$ {{ Auth::user()->saldo }}</span></h3>
                                @else
                                    <h3><span class="badge bg-success">$ {{ Auth::user()->saldo }}</span></h3>
                                @endif

                            </div>
                            <div class="card-footer text-muted">
                                @if (Auth::user()->saldo > 0)
                                    {{-- Modal: Imprimir --}}
                                    <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal01">
                                        Imprimir
                                        <img src="https://cdn-icons-png.flaticon.com/512/2874/2874791.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </button>

                                    {{-- Modal: Imprimir --}}
                                    <div class="modal fade" id="exampleModal01" tabindex="-1"
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
                                                        <div class="row mt-2">
                                                            <!-- Número Hojas -->
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
                                                            <!-- Número Copias -->
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
                                                                <label class="form-label" for="autoSizingSelect">Tamaño De
                                                                    Papel</label>
                                                                <select class="form-select" id="autoSizingSelect"
                                                                    name="tamaño">
                                                                    <option selected disabled>Escoge Una Opción...
                                                                    </option>
                                                                    <option value="Carta">Carta</option>
                                                                    <option value="Oficio">Oficio</option>
                                                                    <option value="Estamento">Estamento</option>
                                                                    <option value="Ejecutivo">Ejecutivo</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-2">
                                                            <!-- Impresora -->
                                                            <div class="col-md-12 mb-2">
                                                                <label class="form-label" for="autoSizingSelect01">Impresora
                                                                    Y Color</label>
                                                                <select class="form-select" id="autoSizingSelect01"
                                                                    name="impresora">
                                                                    <option selected disabled>Escoge Una Opción...
                                                                    </option>
                                                                    <option value="HP LaserJet M604">HP LaserJet
                                                                        M604
                                                                        (Blanco Y Negro)</option>
                                                                    <option value="XRX9">XRX9 (Color)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-grid gap-2 pt-4">
                                                            <button type="submit" class="btn" id="bg-blue-benmac">
                                                                Continuar
                                                                <img src="https://cdn-icons-png.flaticon.com/512/724/724954.png"
                                                                    alt="BENMAC" class="icon-benmac">
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Modal: Sin Saldo --}}
                                    <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Sin Saldo
                                        <img src="https://cdn-icons-png.flaticon.com/512/2780/2780808.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </button>

                                    {{-- Modal: Sin Saldo --}}
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
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
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
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
                                                <span class="badge bg-success bg-sm">$
                                                    {{ $price->color }} MXN
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
