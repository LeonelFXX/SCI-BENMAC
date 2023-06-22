@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 mt-2">
                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        {{ __('Crear Nuevo Usuario (Personal Administrativo)') }}
                        <img src="https://cdn-icons-png.flaticon.com/512/4202/4202263.png" alt="BENMAC"
                            class="icon-benmac">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Matrícula -->
                                <div class="col-md-3 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label" for="matricula">Clave Administrativa</label>
                                        <input type="text" id="matricula"
                                            class="form-control form-control-lg @error('matricula') is-invalid @enderror"
                                            placeholder="Ej. 213200350000" name="matricula" value="{{ old('matricula') }}"
                                            required autofocus />
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
                                            placeholder="Nombre(s)" name="name" value="{{ old('name') }}" required />
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
                                            value="{{ old('apellido_paterno') }}" required />
                                    </div>
                                </div>

                                <!-- Apellido Materno -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="apellidoMaterno">Apellido Materno</label>
                                        <input type="text" id="apellidoMaterno" class="form-control form-control-lg"
                                            placeholder="A. Materno" name="apellido_materno"
                                            value="{{ old('apellido_materno') }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Teléfono -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="phoneNumber">Télefono</label>
                                        <input type="tel" id="phoneNumber" class="form-control form-control-lg"
                                            placeholder="000-000-00-00" name="telefono" value="{{ old('telefono') }}"
                                            required />
                                    </div>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="col-md-9 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="emailAddress">Correo Electrónico
                                            Institucional</label>
                                        <input type="email" id="emailAddress"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            placeholder="ejemplo@benmac.edu.mx" name="email" value="{{ old('email') }}"
                                            required />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Contraseña -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <input type="password" id="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            placeholder="Contraseña" name="password" required />
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
                                            placeholder="Confirmar Contraseña" name="password_confirmation" required />
                                    </div>
                                </div>

                                <!-- Tipo Usuario -->
                                <div class="input-group mb-3">
                                    <label class="input-group-text @error('tipo_usuario') is-invalid @enderror"
                                        for="inputGroupSelect02">Tipo De Usuario</label>
                                    <select class="form-select" id="inputGroupSelect02" name="tipo_usuario" required>
                                        <option selected disabled>Escoge Una Opción...</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo_usuario')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-2">
                                <input type="submit" class="btn" id="bg-blue-benmac" value="Crear Usuario" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
