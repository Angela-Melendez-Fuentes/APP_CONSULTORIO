<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/pacientes_logo.png') }}" alt="Pacientes Logo"
                style="width: 283px; max-width: 100%;">
        </div>

    </header>


    <div class="py-12 bg-blue-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <button style="margin-right: 3cm" onclick="window.location.href='pacientes/registrar_pacientes'"
                            type="button"
                            class="text-gray-600 hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-sm px-2.5 py-2.5 bg-transparent">
                            <i class="fas fa-user-plus"></i>
                        </button>
                        <form method="GET" action="{{ route('paciente') }}" class="flex">
                            <input type="text" name="search" placeholder="Buscar paciente"
                                class="bg-gray-100 text-sm px-4 py-2.5 rounded-md outline-blue-500"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="ml-2 px-4 py-2 bg-blue-200 text-black rounded-md">Buscar</button>
                        </form>
                    </div>
                </div>

                @if ($pacientes->isEmpty())
                    <div class="text-center text-gray-600 py-4">
                        No hay registro de ese paciente.
                    </div>
                @else
                    <table class="w-full text-sm text-center text-gray-600 ">
                        <thead class="text-xs text-gray-800 uppercase bg-blue-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-bold">Nombre Paciente</th>
                                <th scope="col" class="px-6 py-3 font-bold">Correo</th>
                                <th scope="col" class="px-6 py-3 font-bold">Teléfono</th>
                                <th scope="col" class="px-6 py-3 font-bold">Fecha Nacimiento</th>
                                <th scope="col" class="px-6 py-3 font-bold">Género</th>
                                <th scope="col" class="px-6 py-3 font-bold">Edad</th>
                                <th scope="col" class="px-6 py-3 font-bold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pacientes as $paciente)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $paciente->nombre }} {{ $paciente->apellido_p }} {{ $paciente->apellido_m }}
                                    </td>
                                    <td class="px-6 py-4">{{ $paciente->correo }}</td>
                                    <td class="px-6 py-4">{{ $paciente->telefono }}</td>
                                    <td class="px-6 py-4">{{ $paciente->fecha_nacimiento }}</td>
                                    <td class="px-6 py-4">{{ $paciente->genero_biologico }}</td>
                                    <td class="px-6 py-4">{{ $paciente->age }}</td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <div class="rounded-md overflow-hidden">
                                            <a href="{{ route('paciente.edit', $paciente->id) }}" class="block text-center text-indigo-600 hover:text-indigo-900 px-3 py-2">Editar</a>
                                        </div>
                                       
                                        <div class="rounded-md overflow-hidden">
                                            <form action="{{ route('paciente.destroy', $paciente->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este paciente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="block text-center text-red-600 hover:text-red-900 px-3 py-2">Eliminar</button>
                                            </form>
                                        </div>
                                        <div class="rounded-md overflow-hidden">
                                            <a href="{{ route('cita.agendar') }}"
                                                class="block text-center text-gray-600 hover:text-gray-900 px-3 py-2">
                                                <i class="fas fa-calendar-plus"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</x-app-layout>
