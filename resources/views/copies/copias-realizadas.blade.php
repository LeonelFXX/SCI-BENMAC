@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 mt-2">
                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                ➤ Copias Realizadas
                                <img src="https://cdn-icons-png.flaticon.com/512/711/711239.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="col-md-6 d-flex flex-row-reverse">
                                @if ($solicitudes == 0)
                                    <a href="{{ route('solicitudes') }}" class="btn btn-primary btn-sm mx-1">
                                        Pendientes <span class="badge text-bg-danger">
                                            0
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('solicitudes') }}" class="btn btn-primary btn-sm mx-1">
                                        Pendientes <span class="badge text-bg-danger">
                                            {{ $solicitudes }}
                                        </span>
                                    </a>
                                @endif
                                <a href="{{ route('copiasRealizadas') }}" class="btn btn-primary btn-sm mx-1">
                                    Realizados
                                    <span class="badge text-bg-danger">
                                        {{ $realizados }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($resultados->isEmpty())
                            <h6 class="h6 text-center mt-2">No se han realizado copias.</h6>
                        @else
                            <table class="table table-responsive table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Folio</th>
                                        <th scope="col">Matrícula</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col" width="100px">A. Paterno</th>
                                        <th scope="col">A. Materno</th>
                                        <th scope="col">Licenciatura | Labor</th>
                                        <th scope="col">Encargado</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-center">
                                    @foreach ($resultados as $datos)
                                        <tr>
                                            <th scope="row">{{ $datos->id }}</th>
                                            <td>{{ $datos->matricula }}</td>
                                            <td>{{ $datos->name }}</td>
                                            <td>{{ $datos->apellido_paterno }}</td>
                                            <td>{{ $datos->apellido_materno }}</td>

                                            @if ($datos->licenciatura == 'Personal Administrativo')
                                                <td><span class="badge text-bg-warning">{{ $datos->licenciatura }}</span>
                                                </td>
                                            @else
                                                <td><span class="badge text-bg-primary">{{ $datos->licenciatura }}</span>
                                                </td>
                                            @endif

                                            <td>{{ $datos->encargado }}</td>
                                            <td><span class="badge text-bg-success">{{ $datos->estado }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="mx-3">
                        {{ $resultados->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
