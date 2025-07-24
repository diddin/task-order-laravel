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
    </head>
    <body class="min-h-screen font-sans text-gray-900 antialiased bg-gray-100 dark:bg-gray-900">

        {{-- Logo fixed di atas --}}
        <div class="fixed top-0 inset-x-0 flex justify-center pt-6 z-50 bg-gray-100 dark:bg-gray-900">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>
    
        {{-- Wrapper halaman penuh --}}
        <div class="min-h-screen flex flex-col items-center pt-[120px] px-4">
            {{-- Kontainer isi pengumuman --}}
            <div class="w-full max-w-4xl overflow-y-auto rounded-2xl shadow-md 
                        bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6">
                {{ $slot }}
            </div>
        </div>
    
    </body>    
</html>
