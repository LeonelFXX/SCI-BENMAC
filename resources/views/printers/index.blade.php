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
                                ➤ Todos Las Impresoras
                                <img src="https://cdn-icons-png.flaticon.com/512/446/446991.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="col-md-6 d-flex flex-row-reverse">
                                <!-- Agregar Impresora -->
                                <a href="{{ route('printers.create') }}" class="btn btn-primary btn-sm mx-1">
                                    Agregar Impresora
                                    <img src="https://cdn-icons-png.flaticon.com/512/446/446991.png" alt="BENMAC"
                                        class="icon-benmac">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Ubicación</th>
                                    <th scope="col" width="300px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider text-center align-items-center">
                                @foreach ($impresoras as $impresora)
                                    <tr>
                                        <th scope="row">{{ $impresora->id }}</th>
                                        <td>{{ $impresora->nombre }}</td>
                                        <td>{{ $impresora->color }}</td>
                                        <td>{{ $impresora->ubicacion }}</td>
                                        <td>
                                            <form action="{{ route('printers.destroy', $impresora->id) }}" method="POST">
                                                <!-- Editar Usuario -->
                                                <a class="btn btn-primary btn-sm mx-1"
                                                    href="{{ route('printers.edit', $impresora->id) }}">
                                                    Editar
                                                    <img src="https://cdn-icons-png.flaticon.com/512/2355/2355330.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mx-1">
                                                    Eliminar
                                                    <img src="https://cdn-icons-png.flaticon.com/512/608/608258.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
