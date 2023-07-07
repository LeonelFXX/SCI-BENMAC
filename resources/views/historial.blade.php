@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-md-12 mt-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card text-center shadow-lg">
                            <div class="card-header" id="bg-blue-benmac">
                                Últimas Impresiones Realizadas
                                <img src="https://cdn-icons-png.flaticon.com/512/3503/3503786.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive table-hover text-center">
                                    @if ($historial->isEmpty())
                                        <h6 class="h6 mt-3">
                                            No se tiene registro de Impresiones.
                                        </h6>
                                    @else
                                        <thead>
                                            <tr>
                                                <th scope="col">Color</th>
                                                <th scope="col">Hojas</th>
                                                <th scope="col">Engargolado</th>
                                                <th scope="col">Coste</th>
                                                <th scope="col">Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider text-center">
                                            @foreach ($historial as $his)
                                                <tr>
                                                    <th scope="row">{{ $his->color }}</th>
                                                    <td>{{ $his->total_hojas }}</td>
                                                    <td>{{ $his->engargolado }}</td>
                                                    <td>$ {{ $his->coste_impresion }}</td>
                                                    <td>{{ $his->fecha_impresion }}</td>
                                                </tr>
                                            @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-center shadow-lg">
                            <div class="card-header" id="bg-blue-benmac">
                                Últimas Recargas Realizadas
                                <img src="https://cdn-icons-png.flaticon.com/512/2970/2970715.png" alt="BENMAC"
                                    class="icon-benmac">
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive table-hover text-center">
                                    @if ($recargas->isEmpty())
                                        <h6 class="h6 mt-3">
                                            No se tiene registro de Recargas.
                                        </h6>
                                    @else
                                        <thead>
                                            <tr>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Fecha De Recarga</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider text-center">
                                            @foreach ($recargas as $rec)
                                                <tr>
                                                    <th scope="row">$ {{ $rec->monto }}</th>
                                                    <td>{{ $rec->fecha_recarga }}</td>
                                                </tr>
                                            @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
