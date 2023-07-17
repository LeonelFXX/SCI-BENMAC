@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-2">
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
                    <div class="card-header text-center" id="bg-blue-benmac">
                        {{ __('Buscar Usuario') }}
                        <img src="https://cdn-icons-png.flaticon.com/512/151/151773.png" alt="BENMAC" class="icon-benmac">
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('validarMatricula') }}">
                            @csrf
                            <div class="row">
                                <!-- Matrícula -->
                                <div class="col-md-12 mb-2">
                                    <label for="matricula" class="form-label">
                                        {{ __('Ingresa Tú Matrícula') }}
                                    </label>
                                    <input id="matricula" placeholder="Ej. 213200350000" type="text"
                                        class="form-control mb-2 @error('matricula') is-invalid @enderror" name="matricula"
                                        value="{{ old('matricula') }}" required autocomplete="matricula" autofocus>
                                    @error('matricula')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid gap-2 pt-2">
                                <button type="submit" class="btn" id="bg-blue-benmac">
                                    {{ __('Encontrar Usuario') }}
                                    <img src="https://cdn-icons-png.flaticon.com/512/2312/2312472.png" alt="BENMAC" class="icon-benmac">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
