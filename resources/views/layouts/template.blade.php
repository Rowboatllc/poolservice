<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <base href="{{ config('app.url') }}" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">
        <meta name="description" content="FIND AN EXPERIENCED TECHNICIAN FOR ALL OF YOUR POOL SERVICE NEEDS">
        <meta name="keywords" content="POOL, POOLSERVICE">
        @yield('head')
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PoolService') }}</title>
       
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form-elements.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

         <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = {};
            window.Laravel.csrfToken = '{{csrf_token()}}';
        </script>
        
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
    </head>
    <body>
        <div class="container-full">
            <header class="row">
                @include('layouts.header')
            </header>
            @yield('baner')
            <div id="main" class="row admin-panel">
                <div id="app" ng-app="app">
                    @yield('content')
                </div>    
            </div>
            </div>
            <footer class="footer row">
                @include('layouts.footer')
            </footer>
        </div>

        @yield('lib')
    </body>
</html>