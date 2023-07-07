@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 mt-2">
                <div class="card shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                ➤ Impresiones "No Pago" Denegadas
                                <img src="https://cdn-icons-png.flaticon.com/512/711/711239.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="col-md-6 d-flex flex-row-reverse">
                                <a href="{{ route('denegadas') }}" class="btn btn-primary btn-sm mx-1">
                                    Denegadas
                                    <span class="badge text-bg-danger">
                                        {{ $denegados }}
                                    </span>
                                </a>
                                <a href="{{ route('realizadas') }}" class="btn btn-primary btn-sm mx-1">
                                    Realizadas
                                    <span class="badge text-bg-danger">
                                        {{ $realizadas }}
                                    </span>
                                </a>
                                <a href="{{ route('solicitudesImpresiones') }}" class="btn btn-primary btn-sm mx-1">
                                    Pendientes
                                    <span class="badge text-bg-danger">
                                        {{ $pendientes }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($resultados->isEmpty())
                            <h6 class="h6 text-center mt-2">No se han realizado impresiones.</h6>
                        @else
                            <table class="table table-responsive table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Folio</th>
                                        <th scope="col">Matrícula</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Impresora</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">T. Hojas</th>
                                        <th scope="col">Engargolado</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Encargado</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-center">
                                    @foreach ($resultados as $datos)
                                        <tr>
                                            <th scope="row">{{ $datos->id }}</th>
                                            <td>{{ $datos->matricula }}</td>
                                            <td>{{ $datos->color }}</td>
                                            <td>{{ $datos->impresora }}</td>
                                            <td>{{ $datos->fecha_impresion }}</td>
                                            <td>{{ $datos->total_hojas }}</td>
                                            <td>{{ $datos->engargolado }}</td>
                                            <td>{{ $datos->descripcion }}</td>
                                            <td>{{ $datos->encargado }}</td>
                                            <td><span class="badge text-bg-danger">{{ $datos->estado }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
