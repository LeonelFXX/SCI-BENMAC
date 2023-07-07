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
                                ➤ Solicitudes Para Realizar Engargolados
                                <img src="https://cdn-icons-png.flaticon.com/512/3602/3602123.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="col-md-6 d-flex flex-row-reverse">
                                @if ($solicitudes == 0)
                                    <a href="{{ route('solicitudes') }}" class="btn btn-primary btn-sm mx-1">
                                        Pendientes <span class="badge text-bg-danger">
                                            0
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('solicitudes') }}" class="btn btn-primary btn-sm mx-1">
                                        Pendientes <span class="badge text-bg-danger">
                                            {{ $solicitudes }}
                                        </span>
                                    </a>
                                @endif
                                <a href="{{ route('engargolados') }}" class="btn btn-primary btn-sm mx-1">
                                    Realizados
                                    <span class="badge text-bg-danger">
                                        {{ $realizados }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($datos_solicitudes->isEmpty())
                            <h6 class="h6 text-center mt-2">No hay solicitudes pendientes.</h6>
                        @else
                            <div class="container">
                                <div class="row">
                                    @foreach ($datos_solicitudes as $datos)
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
                                                            <img src="https://cdn-icons-png.flaticon.com/512/829/829552.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                                {{ $datos->matricula }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                                {{ $datos->licenciatura }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 mt-2 pt-2">
                                                        <form action="{{ route('engargoladoCompletado', ['id' => $datos->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn" id="bg-blue-benmac">
                                                                Marcar Como Engargolado Realizado
                                                                <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                    alt="BENMAC" class="icon-benmac">
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
