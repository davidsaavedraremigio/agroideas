<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name')}} - @yield('title') </title>
    <!-- Seccion Css -->
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/AdminLTE.css') !!}" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    
    <div class="wrapper">
        @include('layouts.menu-superior')
        @include('layouts.menu-lateral')
        <div class="content-wrapper">
            @include('layouts.titulo')
            <section class="content">
                <div class="container-fluid">
                @yield('content')
            </section>
        </div>
        @include('layouts.footer')
    </div>
    <!-- Seccion JS-->
    <script src="{!! asset('js/app.js') !!}"></script>
    <script src="{!! asset('js/config-app.js') !!}"></script>
    <script src="https://cdn.flexmonster.com/flexmonster.js"></script>
    @yield('scripts')
    @routes
    @show
</body>
</html>