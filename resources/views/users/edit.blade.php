@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 mt-2">
                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        Editar Usuario: {{ $user->name }}
                        <img src="https://cdn-icons-png.flaticon.com/512/2355/2355330.png" alt="BENMAC" class="icon-benmac">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Matrícula -->
                                <div class="col-md-3 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label" for="matricula">Matrícula | Clave</label>
                                        <input type="text" id="matricula" class="form-control form-control-lg"
                                            placeholder="Ej. 213200350000" name="matricula" value="{{ $user->matricula }}"
                                            required autofocus disabled />
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="name">Nombre(s)</label>
                                        <input type="text" id="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="Nombre(s)" name="name" value="{{ $user->name }}" required />
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
                                            value="{{ $user->apellido_paterno }}" required />
                                    </div>
                                </div>

                                <!-- Apellido Materno -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="apellidoMaterno">Apellido Materno</label>
                                        <input type="text" id="apellidoMaterno" class="form-control form-control-lg"
                                            placeholder="A. Materno" name="apellido_materno"
                                            value="{{ $user->apellido_materno }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Teléfono -->
                                <div class="col-md-3 mb-4">
                                    <div class="form-outline">
                                        <label class="form-label" for="phoneNumber">Télefono</label>
                                        <input type="tel" id="phoneNumber" class="form-control form-control-lg"
                                            placeholder="000-000-00-00" name="telefono" value="{{ $user->telefono }}"
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
                                            placeholder="ejemplo@benmac.edu.mx" name="email" value="{{ $user->email }}"
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
                                <!-- Licenciatura -->
                                <div class="input-group mb-3">
                                    <label class="input-group-text @error('licenciatura') is-invalid @enderror"
                                        for="inputGroupSelect01">Licenciatura</label>
                                    <select class="form-select" id="inputGroupSelect01" name="licenciatura" required>
                                        <option selected disabled>{{ $user->licenciatura }}</option>
                                        <option value="Licenciatura En Educación Primaria">Licenciatura En Educación
                                            Primaria</option>
                                        <option value="Licenciatura En Educación Preescolar">Licenciatura En Educación
                                            Preescolar</option>
                                        <option value="Licenciatura En Educación Física">Licenciatura En Educación Física
                                        </option>
                                        <option value="Licenciatura En Enseñanza Y Aprendizaje En Educación Telesecundaria">
                                            Licenciatura En Enseñanza Y Aprendizaje En Educación Telesecundaria</option>
                                        <option value="Licenciatura En Inclusión Educativa">Licenciatura En Inclusión
                                            Educativa</option>
                                        <option value="Maestría En Educación">Maestría En Educación</option>
                                        <option value="Personal Administrativo">Personal Administrativo</option>
                                    </select>
                                    @error('licenciatura')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Tipo Usuario -->
                                <div class="input-group mb-3">
                                    <label class="input-group-text @error('tipo_usuario') is-invalid @enderror"
                                        for="inputGroupSelect02">Tipo De Usuario</label>
                                    <select class="form-select" id="inputGroupSelect02" name="tipo_usuario" required>
                                        <option selected disabled>{{ $user->tipo_usuario }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->hasRole($role) ? 'selected' : '' }}>
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
                            <div class="d-grid gap-2 mt-2 pt-2">
                                <input type="submit" class="btn" id="bg-blue-benmac" value="Actualizar Usuario" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
