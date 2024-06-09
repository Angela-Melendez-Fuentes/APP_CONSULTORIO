<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Paciente') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center items-center bg-gray-100 dark:bg-gray-900">
        <div class="max-w-full w-full mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto">
                <div class="container mx-auto p-8 bg-white text-gray-900 dark:bg-gray-800 dark:text-white rounded-lg shadow-lg">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="max-w-2xl mx-auto" method="POST" action="{{route('registro_paciente')}}">
                        @csrf
                        <div class="mb-4">
                            <input type="text" name="nombre" id="nombre" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Nombre(s)" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <input type="text" name="apellido_p" id="apellido_p" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Apellido Paterno" required />
                            </div>
                            <div class="mb-4">
                                <input type="text" name="apellido_m" id="apellido_m" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Apellido Materno" required />
                            </div>
                        </div>
                        <div class="mb-4">
                            <input type="email" name="correo" id="correo" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Correo" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <input type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="telefono" id="telefono" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Teléfono (123-456-7890)" required />
                            </div>
                            <div class="mb-4">
                                <input type="number" name="age" id="age" min="1" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Edad" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Fecha de Nacimiento" required />
                            </div>
                            <div class="mb-4">
                                <select name="genero_biologico" id="genero_biologico" class="block py-2.5 px-4 w-full text-sm text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" required>
                                    <option value="" disabled selected>Selecciona el género</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="text-blue-600 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm w-full sm:w-auto px-5 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                            Registrar
                        </button>                   
                     </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
