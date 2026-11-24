<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="dark">
    <meta name="theme-color" content="#0f1923">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Pokedex')</title>
    <link rel="icon" type="image/svg+xml" href="{{ app()->environment('production') ? secure_asset('favicon.svg') : asset('favicon.svg') }}?v={{ filemtime(public_path('favicon.svg')) }}">
    <link rel="shortcut icon" href="{{ app()->environment('production') ? secure_asset('favicon.svg') : asset('favicon.svg') }}?v={{ filemtime(public_path('favicon.svg')) }}">
    <link rel="apple-touch-icon" href="{{ app()->environment('production') ? secure_asset('images/pokeball.png') : asset('images/pokeball.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=chakra-petch:600,700|jetbrains-mono:500,600,700|plus-jakarta-sans:400,500,600,700,800&display=swap">
    <link rel="preconnect" href="https://raw.githubusercontent.com">
    @stack('head')

    <link rel="stylesheet" href="{{ app()->environment('production') ? secure_asset('css/pokedex.css') : asset('css/pokedex.css') }}?v={{ filemtime(public_path('css/pokedex.css')) }}">
</head>
<body>
    {{-- Latar Pokédex modern berpola geometris halus --}}
    <div class="page-bg" aria-hidden="true"></div>

    <a class="skip-link" href="#search">Langsung ke tabel Pokédex</a>

    @yield('content')

    @stack('scripts')
</body>
</html>
