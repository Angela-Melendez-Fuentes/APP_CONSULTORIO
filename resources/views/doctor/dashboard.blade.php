<x-app-layout>
    <header class="bg-blue-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <img src="{{ asset('images/bienvenido.png') }}" alt="Registro" style="width: 300px; max-width: 100%;">
            </div>
        </div>
    </header>

    <div class="flex justify-center items-center h-screen">
        <div class="mt"> 
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/fondo.png') }}" alt="Logo" class="mx-auto max-w-full h-auto" style="max-width: 1000px;">
            </a>
        </div>
    </div>
</x-app-layout>
