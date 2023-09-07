<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @yield('script')
    <script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fonts -->
    @yield('style')

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
{{--    <!-- Styles -->--}}
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet" >
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/result.css') }}" rel="stylesheet">
    <link href="{{ asset('css/upload.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">


        <div class="navbar">
            <div class="navbar-container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>



                <div class="navbar-links">

                    @guest
                        @if (Route::has('login'))
                            <a  href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register'))<a href="{{ route('register') }}">{{ __('Register') }}</a>@endif

                    @else

                        <a  href="{{route('home')}}"> Home</a>
                        <a  href="{{ route('logout') }}"
                           onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                        <div style="margin-top: 10px; ">
                            <a  href="#"> {{ Auth::user()->name }}</a>
                        </div>

                    @endguest

                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
