@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-2">

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

            <div class="col-md-3">
                <div class="card text-center shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        Configuración De Precios
                        <img src="https://cdn-icons-png.flaticon.com/512/1/1437.png" alt="BENMAC" class="icon-benmac">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('aplicarPrecios', $price->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="form-outline">
                                        <!-- Blanco Y Negro Impresión -->
                                        <label for="blanco_y_negro" class="form-label">
                                            Blanco Y Negro:
                                            <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                alt="BENMAC" class="icon-benmac-gray">
                                        </label>
                                        <input type="number" id="blanco_y_negro" class="form-control mb-3"
                                            placeholder="0.00" name="blanco_y_negro" autofocus
                                            value="{{ $price->blanco_y_negro }}" required />
                                        <!-- Color Impresión -->
                                        <label for="color" class="form-label">
                                            Color:
                                            <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </label>
                                        <input type="number" id="color" class="form-control mb-3" placeholder="0.00"
                                            name="color" autofocus value="{{ $price->color }}" required />
                                        <!-- Engargolado -->
                                        <label for="engargolado" class="form-label">
                                            Engargolado:
                                            <img src="https://cdn-icons-png.flaticon.com/512/829/829552.png" alt="BENMAC"
                                                class="icon-benmac">
                                        </label>
                                        <input type="number" id="engargolado" class="form-control mb-2" placeholder="0.00"
                                            name="engargolado" autofocus value="{{ $price->engargolado }}" required />
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 pt-2">
                                <!-- Modal: Aplicar Precios -->
                                <button type="button" class="btn" id="bg-blue-benmac" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal01">
                                    Aplicar Precios
                                    <img src="https://cdn-icons-png.flaticon.com/512/87/87932.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                                <!-- Modal: Aplicar Precios -->
                                <div class="modal fade" id="exampleModal01" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" id="bg-blue-benmac">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Actualizar Precios
                                                    <img src="https://cdn-icons-png.flaticon.com/512/87/87932.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="h5">¿Quiéres actualizar los precios?</h5>
                                                <h6 class="h6">Los cambios se veran reflejados en la página de inicio.
                                                </h6>
                                                <div class="d-grid gap-2 pt-2">
                                                    <button type="submit" class="btn" id="bg-blue-benmac">
                                                        Aplicar Cambios
                                                        <img src="https://cdn-icons-png.flaticon.com/512/87/87932.png"
                                                            alt="BENMAC" class="icon-benmac">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
