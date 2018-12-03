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
    <script src="{{ asset('js/vendor/onscreen.min.js') }}" defer></script>
    <script src="{{ asset('js/vendor/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/vendor/argon.min.js') }}" defer></script>

    <!-- Fonts -->
    <link href="{{ asset('css/vendor/nucleo.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/vendor/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body style="height: 100%;">

    <div id="app" style="height: 100%;"></div>
</body>
</html>
