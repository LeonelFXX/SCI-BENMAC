@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mt-2">

                {{-- Mensajes de error --}}
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        Cargar Saldo
                        <img src="https://cdn-icons-png.flaticon.com/512/126/126229.png" alt="BENMAC"
                            class="icon-benmac">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cargarSaldo', $user->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Usuario -->
                                <div class="col-md-12 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label">Usuario</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->name }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}"
                                            disabled />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Matrícula -->
                                <div class="col-md-12 mb-2">
                                    <div class="form-outline">
                                        <label class="form-label" for="matricula">Matrícula | Clave</label>
                                        <input type="text" id="matricula" class="form-control" placeholder="Ej. 213200350000"
                                            name="matricula" value="{{ $user->matricula }}" disabled />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Cantidad -->
                                <label class="form-label" for="cantidad">Cantidad</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" id="cantidad" class="form-control" placeholder="0.00"
                                        name="cantidad" required />
                                </div>
                            </div>
                            <div class="d-grid gap-2 pt-2">
                                <input class="btn" id="bg-blue-benmac" type="submit" value="Cargar Saldo" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
