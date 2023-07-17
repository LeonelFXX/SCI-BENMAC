@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
                    <div class="col-md-9 mt-2">
                        <div class="card shadow-lg">
                            <div class="card-header" id="bg-blue-benmac">
                                {{ __('Datos De La Impresión') }}
                                <img src="https://cdn-icons-png.flaticon.com/512/10866/10866652.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="card-body">
                                <div class="row d-flex justify-content-between">
                                    <!-- Folio -->
                                    <div class="col-md-2 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Folio</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->id }}" disabled />
                                        </div>
                                    </div>
                                    <!-- Número De Hojas -->
                                    <div class="col-md-2 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">N. Hojas</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->numero_hojas }}" disabled />
                                        </div>
                                    </div>
                                    <!-- Número De Copias -->
                                    <div class="col-md-2 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">N. Copias</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->numero_copias }}" disabled />
                                        </div>
                                    </div>
                                    <!-- Total De Hojas -->
                                    <div class="col-md-2 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">T. Hojas</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->total_hojas }}" disabled />
                                        </div>
                                    </div>
                                    <!-- Tamaño -->
                                    <div class="col-md-3 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Tamaño</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->tamaño }}" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <!-- Impresora -->
                                    <div class="col-md-4 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Impresora</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->impresora }}" disabled />
                                        </div>
                                    </div>
                                    <!-- Color -->
                                    <div class="col-md-4 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Color</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->color }}" disabled />
                                        </div>
                                    </div>
                                    <!-- Engargolado -->
                                    <div class="col-md-4 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Engargolado</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->engargolado }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Ubicación -->
                                    <div class="col-md-12">
                                        <div class="form-outline">
                                            <label class="form-label">Ubicación De La Impresora</label>
                                            <input type="text" class="form-control"
                                                value="{{ $registro->ubicacion }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-5 mt-2">
                                        <h6 class="h6 text-center">
                                            Coste De Impresión: ${{ $registro->coste_impresion }}
                                        </h6>
                                    </div>
                                </div>
                                <hr>
                                <form method="POST" action="{{ route('validacionArchivo', $registro->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <!-- Cargar Archivo -->
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">
                                            Carga Tú Archivo
                                        </label>
                                        <input class="form-control" type="file" id="archivoImprimir"
                                            name="archivoImprimir" required>
                                    </div>
                                    <div class="d-grid gap-2 mt-2">
                                        <button type="submit" class="btn" id="bg-blue-benmac"
                                            onclick="imprimirArchivo()" value="Imprimir">
                                            Imprimir
                                            <img src="https://cdn-icons-png.flaticon.com/512/446/446991.png" alt="BENMAC"
                                                class="icon-benmac">
                                        </button>
                                    </div>
                                </form>
                                <form action="{{ route('rollback', $registro->id) }}" method="POST">
                                    @csrf
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-danger">
                                            Cancelar
                                            <img src="https://cdn-icons-png.flaticon.com/512/660/660252.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="card text-center shadow-lg">
                            <div class="card-header" id="bg-blue-benmac">
                                Saldo De Usuario
                                <img src="https://cdn-icons-png.flaticon.com/512/2211/2211093.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="card-body">
                                <h5 class="h5">
                                    <span class="badge bg-success bg-sm">$
                                        {{ $saldo }} MXN
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
