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
                        ➤ Solicitudes De Engargolados
                        <img src="https://cdn-icons-png.flaticon.com/512/3240/3240587.png" alt="BENMAC"
                            class="icon-benmac">
                    </div>
                    <div class="card-body">
                        @if ($historial_pendientes->isEmpty())
                            <h6 class="h6 text-center mt-2">No hay solicitudes para engargolado.</h6>
                        @else
                            <div class="container">
                                <div class="row">
                                    @foreach ($historial_pendientes as $datos)
                                        <div class="col-md-6">
                                            <div class="card mb-2">
                                                <div class="card-header" id="bg-blue-benmac">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-md-6 mt-1">
                                                            Solicitud Para Engargolado
                                                            <img src="https://cdn-icons-png.flaticon.com/512/2822/2822537.png"
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
                                                                Estado: {{ $datos->estado }}
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
                                                                {{ $datos->fecha_engargolado }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                                $ {{ $datos->coste_engargolado }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 mt-2 pt-2">
                                                        <form action="{{ route('rollbackSolicitud', $datos->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal01">
                                                                Cancelar Solicitud
                                                                <img src="https://cdn-icons-png.flaticon.com/512/660/660252.png"
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
                    <div class="mx-3">
                        {{ $historial_pendientes->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
