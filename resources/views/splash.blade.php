<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DarGuest') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface-50 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <div class="w-16 h-16 bg-navy-700 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg animate-pulse">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-surface-900 tracking-tight">Dar<span class="text-navy-700">Guest</span></h1>
        <p class="text-surface-500 mt-2 mb-6">Redirection en cours...</p>
        <div class="w-8 h-1 bg-surface-200 rounded-full mx-auto overflow-hidden">
            <div class="w-1/2 h-full bg-navy-600 rounded-full animate-pulse"></div>
        </div>
    </div>
    <meta http-equiv="refresh" content="0; url={{ route('login') }}">
</body>
</html>
