@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 mt-2">

                {{-- Mensajes --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success text-center" role="alert">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                {{-- Mensajes Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger text-center" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

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
                                        {{-- Blanco Y Negro Impresión --}}
                                        <label for="blanco_y_negro" class="form-label">
                                            Blanco Y Negro:
                                            <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                alt="BENMAC" class="icon-benmac-gray">
                                        </label>
                                        <input type="number" id="blanco_y_negro" class="form-control mb-3" placeholder="0.00"
                                            name="blanco_y_negro" autofocus value="{{ $price->blanco_y_negro }}" />
                                        {{-- Color Impresión --}}
                                        <label for="color" class="form-label">
                                            Color:
                                            <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </label>
                                        <input type="number" id="color" class="form-control" placeholder="0.00"
                                            name="color" autofocus value="{{ $price->color }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 pt-2">
                                <input class="btn" id="bg-blue-benmac" type="submit" value="Aplicar Precios" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
