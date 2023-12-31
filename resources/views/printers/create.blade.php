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

            <div class="col-md-5">
                <div class="card text-center shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        Agregar Nueva Impresora
                        <img src="https://cdn-icons-png.flaticon.com/512/446/446991.png" alt="BENMAC" class="icon-benmac">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('printers.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-outline">
                                        <!-- Nombre -->
                                        <label for="nombre" class="form-label">
                                            Nombre:
                                        </label>
                                        <input type="text" id="nombre" class="form-control mb-3"
                                            placeholder="Nombre De Impresora" name="nombre" autofocus required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="form-outline">
                                        <!-- Color -->
                                        <label for="color" class="form-label">
                                            Color:
                                        </label>
                                        <select class="form-select" id="autoSizingSelect01" name="color" required>
                                            <option selected disabled>
                                                Escoge Una Opción...
                                            </option>
                                            <option value="Blanco Y Negro">Blanco Y Negro</option>
                                            <option value="Color">Color</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-outline">
                                        <!-- Ubicación -->
                                        <label for="ubicacion" class="form-label">
                                            Ubicación:
                                        </label>
                                        <input type="text" id="ubicacion" class="form-control mb-3"
                                            placeholder="Ubicación De Impresora" name="ubicacion" required />
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-2 pt-2">
                                <!-- Modal: Agregar Impresora -->
                                <button type="button" class="btn" id="bg-blue-benmac" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal10">
                                    Agregar Impresora
                                    <img src="https://cdn-icons-png.flaticon.com/512/87/87932.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                                <!-- Modal: Agregar Impresora -->
                                <div class="modal fade" id="exampleModal10" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" id="bg-blue-benmac">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Agregar Nueva Impresora
                                                    <img src="https://cdn-icons-png.flaticon.com/512/87/87932.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="h5">¿Quiéres agregar está impresora?</h5>
                                                <div class="d-grid gap-2 pt-2">
                                                    <button type="submit" class="btn" id="bg-blue-benmac">
                                                        Agregar Impresora
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
