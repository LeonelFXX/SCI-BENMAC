@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-2">

                <!-- Mensajes De Éxito -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Éxito!</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Mensajes De Error -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <strong>¡Error!</strong> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        @endforeach
                    </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                ➤ Todos Los Usuarios
                            </div>
                            <div class="col-md-6 d-flex flex-row-reverse">
                                <!-- Modal: Quitar Saldo -->
                                <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal01">
                                    Quitar Saldo
                                    <img src="https://cdn-icons-png.flaticon.com/512/3389/3389008.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                                <!-- Modal: Quitar Saldo -->
                                <div class="modal fade" id="exampleModal01" tabindex="-1"
                                    aria-labelledby="exampleModal01Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" id="bg-blue-benmac">
                                                <h5 class="modal-title" id="exampleModal01Label">
                                                    Quitar Saldo
                                                    <img src="https://cdn-icons-png.flaticon.com/512/3389/3389008.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('quitarSaldoModal') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- Matrícula -->
                                                        <div class="col-md-12 mb-2">
                                                            <div class="form-outline">
                                                                <label class="form-label text-dark" for="matricula">
                                                                    Matrícula | Clave Administrativa
                                                                </label>
                                                                <input type="text" id="matricula" class="form-control"
                                                                    placeholder="Ej. 213200350000" name="matricula" required
                                                                    autofocus />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Cantidad -->
                                                        <label class="form-label text-dark" for="cantidad">Cantidad</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" id="cantidad" class="form-control"
                                                                placeholder="0.00" name="cantidad" required />
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 pt-2">
                                                        <button class="btn btn-danger" type="submit">
                                                            Quitar Saldo
                                                            <img src="https://cdn-icons-png.flaticon.com/512/608/608258.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal: Cargar Saldo -->
                                <button type="button" class="btn btn-success btn-sm mx-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Cargar Saldo
                                    <img src="https://cdn-icons-png.flaticon.com/512/126/126229.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                                <!-- Modal: Cargar Saldo -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" id="bg-blue-benmac">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Cargar Saldo
                                                    <img src="https://cdn-icons-png.flaticon.com/512/126/126229.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('cargarSaldoModal') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- Matrícula -->
                                                        <div class="col-md-12 mb-2">
                                                            <div class="form-outline">
                                                                <label class="form-label text-dark" for="matricula">
                                                                    Matrícula | Clave Administrativa
                                                                </label>
                                                                <input type="text" id="matricula" class="form-control"
                                                                    placeholder="Ej. 213200350000" name="matricula"
                                                                    required autofocus />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Cantidad -->
                                                        <label class="form-label text-dark" for="cantidad">
                                                            Cantidad
                                                        </label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" id="cantidad" class="form-control"
                                                                placeholder="0.00" name="cantidad" required />
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 pt-2">
                                                        <button class="btn btn-success" type="submit">
                                                            Cargar Saldo
                                                            <img src="https://cdn-icons-png.flaticon.com/512/1008/1008958.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Agregar Usuario -->
                                <a href="{{ route('clave') }}" class="btn btn-primary btn-sm mx-1">
                                    Agregar Personal Administrativo
                                    <img src="https://cdn-icons-png.flaticon.com/512/4202/4202263.png" alt="BENMAC"
                                        class="icon-benmac">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive table-hover text-center align-items-center">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Matrícula</th>
                                    <th scope="col">Nombre(s)</th>
                                    <th scope="col">A. Paterno</th>
                                    <th scope="col">A. Materno</th>
                                    <th scope="col">Tipo De Usuario</th>
                                    <th scope="col">Saldo</th>
                                    <th scope="col" width="275px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider text-center">
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->matricula }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->apellido_paterno }}</td>
                                        <td>{{ $user->apellido_materno }}</td>
                                        <!-- Color Tipo Usuario -->
                                        @if ($user->tipo_usuario === '1')
                                            <td><span class="badge text-bg-warning">Administrador General</span></td>
                                        @elseif ($user->tipo_usuario === '2')
                                            <td><span class="badge text-bg-warning">Administrador Engargolados</span></td>
                                        @elseif ($user->tipo_usuario === '3')
                                            <td><span class="badge text-bg-warning">Administrador Impresiones</span></td>
                                        @elseif ($user->tipo_usuario === '4')
                                            <td><span class="badge text-bg-danger">Manager</span></td>
                                        @elseif ($user->tipo_usuario === '5')
                                            <td><span class="badge text-bg-primary">Personal Administrativo</span></td>
                                        @else
                                            <td><span class="badge text-bg-primary">Usuario</span></td>
                                        @endif
                                        <!-- Color Saldo -->
                                        @if ($user->saldo == 0)
                                            <td><span class="badge text-bg-danger">$ {{ $user->saldo }}</span></td>
                                        @else
                                            <td><span class="badge text-bg-success">$ {{ $user->saldo }}</span></td>
                                        @endif
                                        <td>
                                            <!-- Editar Usuario -->
                                            <a class="btn btn-primary btn-sm mx-1"
                                                href="{{ route('users.edit', $user->id) }}">Editar
                                                <img src="https://cdn-icons-png.flaticon.com/512/2355/2355330.png"
                                                    alt="BENMAC" class="icon-benmac">
                                            </a>
                                            <!-- Cargar Saldo -->
                                            <a class="btn btn-success btn-sm mx-1"
                                                href="{{ route('users.show', $user->id) }}">Cargar Saldo
                                                <img src="https://cdn-icons-png.flaticon.com/512/126/126229.png"
                                                    alt="BENMAC" class="icon-benmac">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mx-3">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
