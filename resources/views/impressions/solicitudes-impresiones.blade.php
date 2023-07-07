@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 mt-2">

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

                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                ➤ Solicitudes Para Realizar Impresiones "No Pago"
                                <img src="https://cdn-icons-png.flaticon.com/512/3602/3602123.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="col-md-6 d-flex flex-row-reverse">
                                <a href="{{ route('denegadas') }}" class="btn btn-primary btn-sm mx-1">
                                    Denegadas
                                    <span class="badge text-bg-danger">
                                        {{ $denegados }}
                                    </span>
                                </a>
                                <a href="{{ route('realizadas') }}" class="btn btn-primary btn-sm mx-1">
                                    Realizadas
                                    <span class="badge text-bg-danger">
                                        {{ $realizadas }}
                                    </span>
                                </a>
                                <a href="{{ route('solicitudesImpresiones') }}" class="btn btn-primary btn-sm mx-1">
                                    Pendientes
                                    <span class="badge text-bg-danger">
                                        {{ $pendientes }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($resultados->isEmpty())
                            <h6 class="h6 text-center mt-2">No hay solicitudes para impresiones pendientes.</h6>
                        @else
                            <div class="container">
                                <div class="row">
                                    @foreach ($resultados as $datos)
                                        <div class="col-md-6">
                                            <div class="card mb-2">
                                                <div class="card-header" id="bg-blue-benmac">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-md-6 mt-1">
                                                            Nueva Solicitud
                                                            <img src="https://cdn-icons-png.flaticon.com/512/2164/2164609.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </div>
                                                        <div class="col-md-6 mt-1 d-flex flex-row-reverse">
                                                            Folio: {{ $datos->id }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row d-flex align-items-center justify-content-between">
                                                        <div class="col-md-8">
                                                            <h5 class="card-title">
                                                                {{ $datos->name }}
                                                                {{ $datos->apellido_paterno }}
                                                                {{ $datos->apellido_materno }}
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-3 d-flex justify-content-end">
                                                            <img src="https://cdn-icons-png.flaticon.com/512/1041/1041985.png"
                                                                alt="BENMAC" class="icon-benmac" style="filter: invert(0)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                                Clave: {{ $datos->matricula }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                                Descripción: {{ $datos->descripcion }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 mt-2 pt-2">
                                                        <a href="{{ route('mostrarSolicitud', ['id' => $datos->id]) }}"
                                                            class="btn" id="bg-blue-benmac">
                                                            Ver Detalles
                                                            <img src="https://cdn-icons-png.flaticon.com/512/60/60492.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mx-3">
                        {{ $resultados->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
