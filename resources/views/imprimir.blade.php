@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- Mensajes -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success text-center" role="alert">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <!-- Mensajes Error -->
                @if ($errors->any())
                    <div class="alert alert-danger text-center" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
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
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $registro->id }}" disabled />
                                        </div>
                                    </div>

                                    <!-- Número De Hojas -->
                                    <div class="col-md-2 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">N. Hojas</label>
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $registro->numero_hojas }}" disabled />
                                        </div>
                                    </div>

                                    <!-- Número De Copias -->
                                    <div class="col-md-2 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">N. Copias</label>
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $registro->numero_copias }}" disabled />
                                        </div>
                                    </div>

                                    <!-- Total De Hojas -->
                                    <div class="col-md-2 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">T. Hojas</label>
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $registro->total_hojas }}" disabled />
                                        </div>
                                    </div>

                                    <!-- Tamaño -->
                                    <div class="col-md-3 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Tamaño</label>
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $registro->tamaño }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-center">
                                    <!-- Impresora -->
                                    <div class="col-md-6 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Impresora</label>
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $registro->impresora }}" disabled />
                                        </div>
                                    </div>

                                    <!-- Color -->
                                    <div class="col-md-6 mb-2">
                                        <div class="form-outline">
                                            <label class="form-label">Color</label>
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $registro->color }}" disabled />
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-5 mt-2">
                                        <h5 class="h5 text-center">
                                            Coste De Impresión: ${{ $registro->coste_impresion }}
                                        </h5>
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
                                        </button>
                                    </div>
                                </form>
                                <form action="{{ route('rollback', $registro->id) }}" method="POST">
                                    @csrf
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-danger">Cancelar</button>
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
                                <h4 class="h4">
                                    <span class="badge bg-success bg-sm">$
                                        {{ $saldo }} MXN
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
