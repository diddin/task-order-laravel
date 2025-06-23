@php
    $role = Auth::user()->role->name;
@endphp

@props(['role'])

@if ($role === 'master')
    <x-app-master-layout :header="$header ?? null">
        @include('layouts.navigation-master')
        <!-- Page Heading if isset x-slot name="header" on child -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        {{ $slot }}
    </x-app-master-layout>
@elseif ($role === 'admin')
    <x-app-admin-layout :header="$header ?? null">
        @include('layouts.navigation-admin')
        <!-- Page Heading if isset x-slot name="header" on child -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        {{ $slot }}
    </x-app-admin-layout>
@else
    <x-app-teknisi-layout :header="$header ?? null">
        <!-- Page Heading if isset x-slot name="header" on child -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        {{ $slot }}
    </x-app-teknisi-layout>
@endif
