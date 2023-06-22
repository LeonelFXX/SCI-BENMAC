<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Links --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/img/escudo.jpg') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@latest"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" id="bg-blue-benmac">
            <div class="container">
                <a class="navbar-brand text-white" id="link-hover" href="{{ url('home') }}">
                    <img src="{{ asset('assets/img/escudo-2.png') }}" alt="BENMAC" class="icon-benmac-primary">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" id="link-hover"
                                        href="{{ route('login') }}">{{ __('Iniciar Sesión') }}
                                        <img src="https://cdn-icons-png.flaticon.com/512/64/64572.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" id="link-hover"
                                        href="{{ route('register') }}">{{ __('Regístrate') }}
                                        <img src="https://cdn-icons-png.flaticon.com/512/681/681494.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </a>
                                </li>
                            @endif
                        @else
                            @role('Administrador')
                                {{-- Impresiones --}}
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown-impressiones" class="nav-link text-white dropdown-toggle"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        v-pre>
                                        Impresiones
                                        <img src="https://cdn-icons-png.flaticon.com/512/2874/2874791.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown-impressiones">
                                        <a class="dropdown-item" href="{{ route('impressions.index') }}">
                                            Todas Las Impresiones
                                        </a>
                                    </div>
                                </li>
                            @endrole

                            @role('Administrador|Manager')
                                {{-- Usuarios --}}
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown-users" class="nav-link text-white dropdown-toggle" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Usuarios
                                        <img src="https://cdn-icons-png.flaticon.com/512/3394/3394785.png" alt="BENMAC"
                                            class="icon-benmac">
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown-users">
                                        <a class="dropdown-item" href="{{ route('users.index') }}">
                                            Todos Los Usuarios
                                        </a>
                                    </div>
                                </li>
                            @endrole
                            {{-- Sesión Usuario --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link text-white dropdown-toggle" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <img src="https://cdn-icons-png.flaticon.com/512/2099/2099174.png" alt="BENMAC"
                                        class="icon-benmac">
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('historial') }}">
                                        Historial De Impresiones
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-2">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
    <script src="{{ asset('assets/js/impresion.js') }}"></script>
</body>

</html>
