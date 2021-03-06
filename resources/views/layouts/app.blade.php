<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        @else
                        <li class="nav-item">
                             <div class="form-inline">
                                <div class="input-group">
                                    <input type="hidden" id="txt_search_account_route_ajax" value="{{ route('search_account_autocomplete')}}"/>
                                    <input type="hidden" id="txt_search_account_route" value="{{ route('search_account')}}"/>
                                    <input id="txt_seach_account" type="text" class="form-control" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="icon-search font-weight-bold"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('monitor') }}" target="_blank">Monitor</a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('scraping') }}">Scraping</a>
                        </li>
                        -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('account') }}">Cuentas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reminder_index') }}">Recordatorios</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} 
                                {{ Auth::user()->middle_name }} 
                                {{ Auth::user()->last_name }}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('sales') }}">Inicio</a>
                                @if(Auth::user()->user_rol_id ==1)
                                <a class="dropdown-item" href="{{ route('users') }}">Usuarios</a>
                                <a class="dropdown-item" href="{{ route('upload_csv') }}">Subir CSV</a>
                                <a class="dropdown-item" href="{{ route('follow_options') }}">Codificaciones</a>
                                <a class="dropdown-item" href="{{ route('details') }}" target="_blank">Detalle BD</a>
                                <a class="dropdown-item" href="{{ route('report') }}" target="">Reportes</a>
                                @endif
                                <!--<a class="dropdown-item" href="{{ route('configuration') }}">Configuración</a>-->
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Cerrar sesión
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <br><br>
        @if(Session::has('message'))
        <br>
        <p id="p_message" class="bg-{{ Session::get('class') }} font-weight-bold"
            style="padding:3px;padding-left:10px;color:rgb(15, 15, 15);border-radius:10px;">
            <span onclick="$('#p_message').hide();" class="icon icon-cross float-right"
                style="cursor:pointer;padding:5px;"></span>
            {{ Session::get('message') }}
        </p>
        @endif
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>