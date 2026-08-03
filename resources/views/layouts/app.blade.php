<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DarGuest') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-surface-50" x-data="{ sidebarOpen: true, mobileSidebar: false }">
        @include('layouts.sidebar')
        @include('layouts.header')

        <main
            class="transition-all duration-300 pt-16 min-h-screen"
            :class="{
                'ml-64': sidebarOpen && !mobileSidebar,
                'ml-[72px]': !sidebarOpen && !mobileSidebar,
                'ml-0': mobileSidebar
            }"
        >
            <div class="p-6 lg:p-8 max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <div
            x-show="mobileSidebar"
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-surface-900/50 lg:hidden"
            x-on:click="mobileSidebar = false"
            style="display: none;"
        ></div>
    </div>
</body>
</html>
