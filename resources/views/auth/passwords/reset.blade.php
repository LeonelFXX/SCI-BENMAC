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
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row mb-3">
                                <!-- Correo Electrónico -->
                                <label for="email"
                                    class="form-label">{{ __('Correo Electrónico Institucional') }}</label>
                                <div class="col-md-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" placeholder="ejemplo@benmac.edu.mx" required
                                        autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Contraseña -->
                                <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                                <div class="col-md-12">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Nueva Contarseña" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Confirmar Contraseña -->
                                <label for="password-confirm"
                                    class="form-label">{{ __('Confirmar Nueva Contraseña') }}</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="Confirmar Nueva Contraseña" required
                                        autocomplete="new-password">
                                </div>
                            </div>
                            <div class="d-grid gap-2 pt-2">
                                <button type="submit" class="btn" id="bg-blue-benmac">
                                    {{ __('Restablecer Contraseña') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
