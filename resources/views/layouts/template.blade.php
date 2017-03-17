<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="http://poolservice.com/favicon.ico?v=1" type="image/x-icon">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PoolService') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
        
        <!-- Javascript -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/nav.js') }}"></script>
        
    </head>
    <body>
        <div class="container-full">
            <header class="row">
                @include('layouts.header')
            </header>

            <div id="main" class="row">
                <div id="app" ng-app="app">
                    @yield('content')
                </div>    
            </div>
            </div>
            <footer class="footer row">
                @include('layouts.footer')
            </footer>
        </div>
        
    </body>
</html>