<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/myScripts.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                

                <div>
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        
                        @guest
                                                    
                        @else
                           <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->first_name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu bg-dark border-0 text-center" aria-labelledby="navbarDropdown">
                            <a class="text-white" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @guest

        @else
            <nav class="navbar navbar-expand-md navbar-light navbar-default border-bottom">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/rota">Rota</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sop">SOPs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/menu">Menu Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/account">Your Account</a>
                            </li>
                        </ul>
    
                    </div>
                </div>
            </nav>
        @endguest

        <div id="main" class="p-4">
            <div class="mx-12 px-12">
                @include('inc.messages')    
                @yield('content')
            </div>
           
        </div>
    </div>
</body>
</html>
