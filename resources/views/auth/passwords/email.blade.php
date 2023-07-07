@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 mt-2">
                <div class="card text-center shadow-lg">
                    <div class="card-header text-center" id="bg-blue-benmac">
                        {{ __('Restablecer Contraseña') }}
                        <img src="https://cdn-icons-png.flaticon.com/512/8669/8669717.png" alt="BENMAC" class="icon-benmac">
                    </div>
                    <div class="card-body text-center shadow-lg">
                        @if (session('status'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row">
                                <!-- Correo Electrónico -->
                                <label for="email" class="form-label">
                                    {{ __('Correo Electrónico Institucional') }}
                                </label>
                                <div class="col-md-12 mb-2">
                                    <input id="email" placeholder="ejemplo@benmac.edu.mx" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid gap-2 pt-2">
                                <button type="submit" class="btn" id="bg-blue-benmac">
                                    {{ __('Enviar Enlace De Restablecimiento') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
