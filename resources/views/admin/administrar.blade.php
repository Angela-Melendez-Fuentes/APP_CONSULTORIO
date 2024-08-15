<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center bg-blue-200">
                <img src="{{ asset('images/AdministrarUser.png') }}" alt="Registro" style="width: 683px; max-width: 100%;">
            </div>
        </div>
    </header>
    

    <div class="py-12 bg-blue-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <form method="GET" action="{{ route('admin.administrar') }}" class="flex">
                            <input type="text" name="search" placeholder="Buscar usuario" class="bg-gray-100 text-sm px-4 py-2.5 rounded-md outline-blue-500" value="{{ request('search') }}">
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-200 text-black rounded-md">Buscar</button>
                        </form>
                    </div>
                </div>

                @if ($usuarios->isEmpty())
                    <div class="text-center text-gray-600 py-4">
                        No hay usuarios registrados.
                    </div>
                @else
                    <table class="w-full text-sm text-center text-gray-600">
                        <thead class="text-xs text-gray-800 uppercase bg-blue-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-bold">Nombre</th>
                                <th scope="col" class="px-6 py-3 font-bold">Correo</th>
                                <th scope="col" class="px-6 py-3 font-bold">Tipo</th>
                                <th scope="col" class="px-6 py-3 font-bold">Teléfono</th>
                                <th scope="col" class="px-6 py-3 font-bold">RFC</th>
                                <th scope="col" class="px-6 py-3 font-bold">Cédula Profesional</th>
                                <th scope="col" class="px-6 py-3 font-bold">Especialidad</th>
                                <th scope="col" class="px-6 py-3 font-bold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                @if ($usuario->tipo !== 'admin')
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $usuario->name }}</td>
                                        <td class="px-6 py-4">{{ $usuario->email }}</td>
                                        <td class="px-6 py-4">{{ $usuario->tipo }}</td>
                                        <td class="px-6 py-4">{{ $usuario->telefono }}</td>
                                        <td class="px-6 py-4">{{ $usuario->rfc }}</td>
                                        <td class="px-6 py-4">{{ $usuario->cedula_profesional }}</td>
                                        <td class="px-6 py-4">{{ $usuario->especialidad }}</td>
                                        <td class="px-6 py-4 flex space-x-2 justify-center">
                                            <!-- Editar usuario -->
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="text-indigo-600 hover:text-indigo-900 px-3 py-2">Editar</a>
                                            <!-- Eliminar usuario -->
                                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 px-3 py-2">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</x-app-layout>
