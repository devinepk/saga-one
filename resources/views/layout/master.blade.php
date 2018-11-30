<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ Storage::url('img/sagaone-icon.png') }}"/>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
    @yield('additional_link_tags')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>@yield('title')</title>
</head>
<body class="@yield('body_classes')">
    <div id="app" v-cloak>

    @yield('body')

    </div>

    @yield('js')
</body>
</html>
