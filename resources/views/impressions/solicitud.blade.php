@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-2">

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
                                    <input type="text" class="form-control form-control-lg" value="{{ $impresion->id }}"
                                        disabled />
                                </div>
                            </div>
                            <!-- Número De Hojas -->
                            <div class="col-md-2 mb-2">
                                <div class="form-outline">
                                    <label class="form-label">N. Hojas</label>
                                    <input type="text" class="form-control form-control-lg"
                                        value="{{ $impresion->numero_hojas }}" disabled />
                                </div>
                            </div>
                            <!-- Número De Copias -->
                            <div class="col-md-2 mb-2">
                                <div class="form-outline">
                                    <label class="form-label">N. Copias</label>
                                    <input type="text" class="form-control form-control-lg"
                                        value="{{ $impresion->numero_copias }}" disabled />
                                </div>
                            </div>
                            <!-- Total De Hojas -->
                            <div class="col-md-2 mb-2">
                                <div class="form-outline">
                                    <label class="form-label">T. Hojas</label>
                                    <input type="text" class="form-control form-control-lg"
                                        value="{{ $impresion->total_hojas }}" disabled />
                                </div>
                            </div>
                            <!-- Tamaño -->
                            <div class="col-md-3 mb-2">
                                <div class="form-outline">
                                    <label class="form-label">Tamaño</label>
                                    <input type="text" class="form-control form-control-lg"
                                        value="{{ $impresion->tamaño }}" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <!-- Impresora -->
                            <div class="col-md-4 mb-2">
                                <div class="form-outline">
                                    <label class="form-label">Impresora</label>
                                    <input type="text" class="form-control form-control-lg"
                                        value="{{ $impresion->impresora }}" disabled />
                                </div>
                            </div>
                            <!-- Color -->
                            <div class="col-md-4 mb-2">
                                <div class="form-outline">
                                    <label class="form-label">Color</label>
                                    <input type="text" class="form-control form-control-lg"
                                        value="{{ $impresion->color }}" disabled />
                                </div>
                            </div>
                            <!-- Engargolado -->
                            <div class="col-md-4 mb-2">
                                <div class="form-outline">
                                    <label class="form-label">Engargolado</label>
                                    <input type="text" class="form-control form-control-lg"
                                        value="{{ $impresion->engargolado }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2 mb-2">
                                <div class="form-outline">
                                    <label for="descripcion" class="mb-2">
                                        Justificación De Impresión
                                    </label>
                                    <textarea class="form-control" id="descripcion" disabled>{{ $impresion->descripcion }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <form method="POST" action="{{ route('autorizar', $impresion->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-grid gap-2 mt-2">
                                <button type="submit" class="btn" id="bg-blue-benmac" onclick="imprimirArchivo()"
                                    value="Imprimir">
                                    Autorizar
                                    <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                            </div>
                        </form>
                        <form action="{{ route('denegar', $impresion->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-danger">
                                    Denegar
                                    <img src="https://cdn-icons-png.flaticon.com/512/660/660252.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
