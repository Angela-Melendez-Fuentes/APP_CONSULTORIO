<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Renace') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-gray-800">
    
    <div class="min-h-screen flex items-center justify-center pt-6 sm:pt-0">
        <div class="font-[sans-serif] text-[#333] flex sm:flex-row w-full max-w-4xl p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md bg-white dark:bg-gray-800">
            <!-- Contenido del formulario -->
            <div class="w-full sm:w-2/3 p-5 bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                @yield('content')
            </div>
            <!-- Sección de la imagen -->
            <div class="flex items-center justify-center w-full sm:w-1/3 p-5">
                <img src="images/AngelaLogin.png" class="max-w-full max-h-full object-contain" alt="Descripción de la imagen" />
            </div>
        </div>
    </div>
</body>
</html>
