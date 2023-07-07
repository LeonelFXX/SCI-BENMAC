@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 mt-2">
                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">{{ __('Regístrate') }}
                        <img src="https://cdn-icons-png.flaticon.com/512/681/681494.png" alt="BENMAC" class="icon-benmac">
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <!-- Matrícula -->
                                <div class="col-md-3 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label" for="matricula">Matrícula</label>
                                        <input type="text" id="matricula"
                                            class="form-control form-control-lg @error('matricula') is-invalid @enderror"
                                            placeholder="Ej. 213200350000" name="matricula"
                                            value="{{ $estudiante->matricula }}" readonly />
                                        @error('matricula')
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Nombre -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="name">Nombre(s)</label>
                                        <input type="text" id="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="Nombre(s)" name="name" value="{{ $estudiante->nombre }}"
                                            readonly />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Apellido Paterno -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="apellidoPaterno">Apellido Paterno</label>
                                        <input type="text" id="apellidoPaterno" class="form-control form-control-lg"
                                            placeholder="A. Paterno" name="apellido_paterno"
                                            value="{{ $estudiante->apellido_paterno }}" readonly />
                                    </div>
                                </div>
                                <!-- Apellido Materno -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="apellidoMaterno">Apellido Materno</label>
                                        <input type="text" id="apellidoMaterno" class="form-control form-control-lg"
                                            placeholder="A. Materno" name="apellido_materno"
                                            value="{{ $estudiante->apellido_materno }}" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Télefono -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="phoneNumber">Télefono</label>
                                        <input type="tel" id="phoneNumber" class="form-control form-control-lg"
                                            placeholder="000-000-00-00" name="telefono" value="{{ $estudiante->telefono }}"
                                            readonly />
                                    </div>
                                </div>
                                <!-- Correo Electrónico -->
                                <div class="col-md-9 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="emailAddress">Correo Electrónico
                                            Institucional</label>
                                        <input type="email" id="emailAddress"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            placeholder="ejemplo@benmac.edu.mx" name="email"
                                            value="{{ $estudiante->email }}" readonly />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Licenciatura -->
                                <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="liceciatura">Licenciatura</label>
                                        <input type="text" id="liceciatura" class="form-control form-control-lg"
                                            placeholder="Licenciatura" name="licenciatura"
                                            value="{{ $estudiante->licenciatura }}" readonly />
                                    </div>
                                </div>
                                <!-- Contraseña -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <input type="password" id="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            placeholder="Contraseña" name="password" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Confirmar Contraseña -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="password-confirm">Confirmar Contraseña</label>
                                        <input type="password" id="password-confirm" class="form-control form-control-lg"
                                            placeholder="Confirmar Contraseña" name="password_confirmation" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-2 pt-2">
                                <button type="submit" class="btn" id="bg-blue-benmac">
                                    Entrar
                                    <img src="https://cdn-icons-png.flaticon.com/512/2623/2623062.png" alt="BENMAC"
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
