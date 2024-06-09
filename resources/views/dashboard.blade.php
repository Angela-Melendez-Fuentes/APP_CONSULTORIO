<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('REGISTRO DE PERSONAL') }}

        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-200 dark:bg-blue-600 overflow-hidden shadow-sm sm:rounded-lg">
                {{ __('Aqui quiero poner un admin que muestre a todos los usuarios y acepte al docotor o secretaria') }}

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <img src="{{ asset('images/espere.png') }}" alt="Perrito de espera" class="mx-auto mb-4">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
