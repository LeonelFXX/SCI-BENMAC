@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mt-2">
                <div class="card text-center shadow-lg">
                    <div class="card-header" id="bg-blue-benmac">
                        Últimas Impresiones Realizadas
                        <img src="https://cdn-icons-png.flaticon.com/512/3503/3503786.png" alt="BENMAC" class="icon-benmac">
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
                                        <th scope="col">Impresora</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Hojas</th>
                                        <th scope="col">Coste</th>
                                        <th scope="col">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-center">
                                    @foreach ($historial as $his)
                                        <tr>
                                            <th scope="row">{{ $his->impresora }}</th>
                                            <td>{{ $his->color }}</td>
                                            <td>{{ $his->total_hojas }}</td>
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
        </div>
    </div>
@endsection
