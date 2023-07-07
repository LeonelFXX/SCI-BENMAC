@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-2">

                <!-- Mensajes De Éxito -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <strong>Éxito En La Acción.</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header" id="bg-blue-benmac">
                        <div class="row">
                            <div class="col-md-3 mt-1">
                                ➤ Detalles De Impresiones
                            </div>
                            <div class="col-md-9 d-flex flex-row-reverse">
                                <!-- Impresoras -->
                                <a href="{{ route('printers.index') }}" class="btn btn-primary btn-sm mx-1">
                                    Impresoras
                                    <img src="https://cdn-icons-png.flaticon.com/512/446/446991.png" alt="BENMAC"
                                        class="icon-benmac">
                                </a>
                                <!-- Configurar Precios -->
                                <a href="{{ route('vistaPrecios', $price->id) }}" class="btn btn-success btn-sm mx-1">
                                    Modificar Precios
                                    <img src="https://cdn-icons-png.flaticon.com/512/1/1437.png" alt="BENMAC"
                                        class="icon-benmac">
                                </a>
                                <!-- Modal: Reporte Individual -->
                                <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal01">
                                    Reporte Individual
                                    <img src="https://cdn-icons-png.flaticon.com/512/709/709722.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                                <!-- Modal: Reporte Individual -->
                                <div class="modal fade" id="exampleModal01" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" id="bg-blue-benmac">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Generar Reporte Individual
                                                    <img src="https://cdn-icons-png.flaticon.com/512/709/709722.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('individual') }}" method="GET">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- Matrícula || Clave Administrativa -->
                                                        <div class="col-md-12 mb-2">
                                                            <div class="form-outline">
                                                                <label class="form-label text-dark" for="matricula">
                                                                    Matrícula | Clave Administrativa
                                                                </label>
                                                                <input type="text" id="matricula" class="form-control"
                                                                    placeholder="Ej. 213200350000" name="matricula_reporte"
                                                                    autofocus required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 pt-2">
                                                        <button class="btn btn-success" id="bg-blue-benmac" type="submit">
                                                            Descargar Reporte Individual
                                                            <img src="https://cdn-icons-png.flaticon.com/512/2382/2382067.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal: Reporte Licenciatura -->
                                <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal02">
                                    Reporte Licenciatura
                                    <img src="https://cdn-icons-png.flaticon.com/512/5305/5305730.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                                <!-- Modal: Reporte Licenciatura -->
                                <div class="modal fade" id="exampleModal02" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" id="bg-blue-benmac">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Generar Reporte Por Licenciatura
                                                    <img src="https://cdn-icons-png.flaticon.com/512/5305/5305730.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('licenciatura') }}" method="GET">
                                                    @csrf
                                                    <div class="row mb-2">
                                                        <!-- Mes | Año -->
                                                        <div class="form-group">
                                                            <label class="form-label text-dark">
                                                                Ingresa El Periodio Inicial
                                                            </label>
                                                            <input class="form-control" type="date"
                                                                name="lic_fecha_reporte_inicio" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <!-- Mes | Año -->
                                                        <div class="form-group">
                                                            <label class="form-label text-dark">
                                                                Ingresa El Periodo Final
                                                            </label>
                                                            <input class="form-control" type="date"
                                                                name="lic_fecha_reporte_fin" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Licenciatura -->
                                                        <div class="input-group mt-2 mb-3">
                                                            <label class="input-group-text">Licenciatura</label>
                                                            <select class="form-select" name="licenciatura_reporte"
                                                                required>
                                                                <option selected disabled>Escoge Una Opción...</option>
                                                                <option value="Licenciatura En Educación Primaria">
                                                                    Licenciatura En Educación Primaria</option>
                                                                <option value="Licenciatura En Educación Preescolar">
                                                                    Licenciatura En Educación Preescolar</option>
                                                                <option value="Licenciatura En Educación Física">
                                                                    Licenciatura En Educación Física</option>
                                                                <option
                                                                    value="Licenciatura En Enseñanza Y Aprendizaje En Educación Telesecundaria">
                                                                    Licenciatura En Enseñanza Y Aprendizaje En Educación
                                                                    Telesecundaria</option>
                                                                <option value="Licenciatura En Inclusión Educativa">
                                                                    Licenciatura En Inclusión Educativa</option>
                                                                <option value="Maestría En Educación">Maestría En Educación
                                                                </option>
                                                                <option value="Personal Administrativo">Personal
                                                                    Administrativo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 pt-2">
                                                        <button class="btn btn-success" id="bg-blue-benmac"
                                                            type="submit">
                                                            Descargar Reporte Por Licenciatura
                                                            <img src="https://cdn-icons-png.flaticon.com/512/2382/2382067.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal: Reporte General Mensual -->
                                <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal03">
                                    Reporte General
                                    <img src="https://cdn-icons-png.flaticon.com/512/2838/2838764.png" alt="BENMAC"
                                        class="icon-benmac">
                                </button>
                                <!-- Modal: Reporte General Mensual -->
                                <div class="modal fade" id="exampleModal03" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" id="bg-blue-benmac">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Generar Reporte General
                                                    <img src="https://cdn-icons-png.flaticon.com/512/2838/2838764.png"
                                                        alt="BENMAC" class="icon-benmac">
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('mensual-general') }}" method="GET">
                                                    @csrf
                                                    <div class="row mb-2">
                                                        <!-- Mes | Año -->
                                                        <div class="form-group">
                                                            <label class="form-label text-dark">
                                                                Ingresa El Periodio Inicial
                                                            </label>
                                                            <input class="form-control" type="date"
                                                                name="fecha_reporte_inicio" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Mes | Año -->
                                                        <div class="form-group">
                                                            <label class="form-label text-dark">
                                                                Ingresa El Periodo Final
                                                            </label>
                                                            <input class="form-control" type="date"
                                                                name="fecha_reporte_fin" required>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 mt-2 pt-2">
                                                        <button class="btn btn-success" id="bg-blue-benmac"
                                                            type="submit">
                                                            Descargar Reporte General
                                                            <img src="https://cdn-icons-png.flaticon.com/512/2382/2382067.png"
                                                                alt="BENMAC" class="icon-benmac">
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Gráfica -->
                                    <div class="card">
                                        <div class="card-header text-center" id="bg-blue-benmac">
                                            Gasto General Por Licenciatura
                                            <img src="https://cdn-icons-png.flaticon.com/512/5305/5305730.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </div>
                                        <div class="card-body">
                                            <div class="grafica">
                                                <canvas id="myChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <!-- Impresora Más Utilizada -->
                                    <div class="card" id="fix-table">
                                        <div class="card-header text-center" id="bg-blue-benmac">
                                            Impresoras Más Utilizada Por Licenciatura
                                            <img src="https://cdn-icons-png.flaticon.com/512/446/446991.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-responsive table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Licenciatura</th>
                                                        <th>Impresora</th>
                                                        <th>Utilizaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-group-divider text-center">
                                                    @foreach ($impresoras as $impresora)
                                                        <tr>
                                                            <th scope="row">{{ $impresora->licenciatura }}</th>
                                                            <td>{{ $impresora->impresora }}</td>
                                                            <td>{{ $impresora->total_utilizaciones }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-around mt-4">
                                <div class="col-3" id="fix-col">
                                    <!-- Total General -->
                                    <div class="card">
                                        <div class="card-header text-center" id="bg-blue-benmac">
                                            Total General
                                            <img src="https://cdn-icons-png.flaticon.com/512/126/126229.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </div>
                                        <div class="card-body d-flex justify-content-center">
                                            <h3 class="h3">
                                                <span class="badge bg-success">$
                                                    @foreach ($general_gastado as $general)
                                                        {{ $general->suma_coste_impresion }}
                                                    @endforeach
                                                </span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3" id="fix-col">
                                    <!-- Total Impresiones -->
                                    <div class="card">
                                        <div class="card-header text-center" id="bg-blue-benmac">
                                            Total Impresiones
                                            <img src="https://cdn-icons-png.flaticon.com/512/2874/2874791.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </div>
                                        <div class="card-body d-flex justify-content-center">
                                            <h3 class="h3">
                                                <span class="badge bg-primary">
                                                    {{ $total_impresiones }}
                                                </span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3" id="fix-col">
                                    <!-- Total De Impresiones A Color -->
                                    <div class="card">
                                        <div class="card-header text-center" id="bg-blue-benmac">
                                            Impresiones: Color
                                            <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                alt="BENMAC" class="icon-benmac">
                                        </div>
                                        <div class="card-body d-flex justify-content-center">
                                            <h3 class="h3">
                                                <span class="badge bg-primary">
                                                    @foreach ($impresiones_color as $color)
                                                        {{ $color->impresiones_color }}
                                                    @endforeach
                                                </span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3" id="fix-col">
                                    <!-- Total De Impresiones A B/N -->
                                    <div class="card">
                                        <div class="card-header text-center" id="bg-blue-benmac">
                                            Impresiones: B/N
                                            <img src="https://cdn-icons-png.flaticon.com/512/2071/2071669.png"
                                                alt="BENMAC" class="icon-benmac-gray">
                                        </div>
                                        <div class="card-body d-flex justify-content-center">
                                            <h3 class="h3">
                                                <span class="badge bg-primary">
                                                    @foreach ($impresiones_byn as $byn)
                                                        {{ $byn->impresiones_byn }}
                                                    @endforeach
                                                </span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        var labels = [];
        var data = [];

        @foreach ($resultado as $item)
            labels.push('{{ $item->licenciatura }}');
            data.push({{ $item->suma_coste_impresion_licenciatura }});
        @endforeach

        var config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Dinero Que Han Gastado',
                    data: data,
                    backgroundColor: [
                        'rgba(3, 39, 51, 1)',
                        'rgba(192, 16, 16, 1)',
                        'rgba(209, 161, 10, 1)',
                        'rgba(48, 67, 190, 0.8)',
                        'rgba(184, 16, 232, 0.8)',
                        'rgba(232, 130, 16, 0.8)',
                        'rgba(175, 189, 200, 1)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
            }
        };

        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, config);
    </script>
@endsection
</div>
</div>
</div>
</div>
@endsection
