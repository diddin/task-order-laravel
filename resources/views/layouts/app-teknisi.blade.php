<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="{{ asset('fonts/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    </head>
    <body class="without-keyboard">
        <!-- header -->
        @include('layouts.navigation-teknisi')
        <!-- Page Content -->
        <div class="body-content detail-tiket">
            {{ $slot }}
        </div>
        <!-- footer -->
        @include('layouts.footer')
        <!-- Tempat menyisipkan script -->
        @stack('scripts')
    </body>
</html>
