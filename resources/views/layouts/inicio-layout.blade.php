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
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="font-[sans-serif] text-[#333]">
            <div class="min-h-screen flex flex-col items-center justify-center">
                <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md bg-white dark:bg-gray-800">
                    <div class="w-full sm:max-w-6xl mt-5 px-5 py-2 mb-5 bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg" style="height: 600px;">
                        @yield('content')
                    </div>

                    <!-- Sección de la imagen -->
                    <div class="md:h-full max-md:mt-10">
                        <img src="images/AngelaLogin.png" class="w-full h-full object-contain" alt="Descripción de la imagen" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
