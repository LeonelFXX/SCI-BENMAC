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
                        ➤ Solicitudes De Impresiones "No Pago"
                        <img src="https://cdn-icons-png.flaticon.com/512/3240/3240587.png" alt="BENMAC"
                            class="icon-benmac">
                    </div>
                    <div class="card-body">
                        @if ($resultados->isEmpty())
                            <h6 class="h6 text-center mt-2">No hay solicitudes para impresiones.</h6>
                        @else
                            <div class="container">
                                <div class="row">
                                    @foreach ($resultados as $datos)
                                        <div class="col-md-6">
                                            <div class="card mb-2">
                                                <div class="card-header" id="bg-blue-benmac">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-md-6 mt-1">
                                                            Solicitud Para Impresión
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
                                                            <h5 class="h5 align-items-center">
                                                                Estado: {{ $datos->estado }}
                                                                @if ($datos->estado == 'Realizado')
                                                                    <span class="badge bg-primary">
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                            alt="BENMAC" class="icon-benmac">
                                                                    </span>
                                                                @elseif ($datos->estado == 'Pendiente')
                                                                    <span class="badge bg-secondary">
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/541/541954.png"
                                                                            alt="BENMAC" class="icon-benmac">
                                                                    </span>
                                                                    @elseif ($datos->estado == 'Autorizado')
                                                                    <span class="badge bg-success">
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                            alt="BENMAC" class="icon-benmac">
                                                                    </span>
                                                                    @else
                                                                    <span class="badge bg-danger">
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/838/838412.png"
                                                                            alt="BENMAC" class="icon-benmac">
                                                                    </span>
                                                                @endif
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
                                                                Fecha: {{ $datos->fecha_impresion }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                                Descripción: {{ $datos->descripcion }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    @if ($datos->estado == 'Autorizado')
                                                        <div class="d-grid gap-2 mt-2 pt-2">
                                                            <a href="{{ route('imprimirSolicitud', ['id' => $datos->id]) }}"
                                                                class="btn" id="bg-blue-benmac">
                                                                Imprimir Solicitud
                                                                <img src="https://cdn-icons-png.flaticon.com/512/60/60492.png"
                                                                    alt="BENMAC" class="icon-benmac">
                                                            </a>
                                                        </div>
                                                    @elseif ($datos->estado == 'Pendiente')
                                                        <div class="d-grid gap-2 mt-2 pt-2">
                                                            <form action="{{ route('rollbackImpresion', $datos->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">
                                                                    Cancelar Solicitud
                                                                    <img src="https://cdn-icons-png.flaticon.com/512/660/660252.png"
                                                                        alt="BENMAC" class="icon-benmac">
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
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
