<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/Servicio.png') }}" alt="Pacientes Logo" style="width: 283px; max-width: 100%;">
        </div>
     
    </header>
    

    <div class="py-12 bg-blue-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <a href="{{ route('servicios.create') }}" class="text-gray-600 hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-sm px-2.5 py-2.5 bg-transparent">
                            <i class="fas fa-plus-circle"></i> Agregar Servicio
                        </a>
                    </div>
                </div>

                @if ($servicios->isEmpty())
                    <div class="text-center text-gray-600 py-4">
                        No hay servicios registrados.
                    </div>
                @else
                    <table class="w-full text-sm text-center text-gray-600">
                        <thead class="text-xs text-gray-800 uppercase bg-blue-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-bold">Nombre</th>
                                <th scope="col" class="px-6 py-3 font-bold">Descripción</th>
                                <th scope="col" class="px-6 py-3 font-bold">Precio</th>
                                <th scope="col" class="px-6 py-3 font-bold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servicios as $servicio)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $servicio->nombre }}</td>
                                    <td class="px-6 py-4">{{ $servicio->descripcion }}</td>
                                    <td class="px-6 py-4">{{ $servicio->precio }}</td>
                                    <td class="px-6 py-4 flex justify-center items-center space-x-8"> 
                                        <a href="{{ route('servicios.edit', $servicio->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este servicio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
