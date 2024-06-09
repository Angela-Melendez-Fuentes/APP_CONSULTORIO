<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-700 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Formulario de edición de usuario -->
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del usuario -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" name="name" id="name" value="{{ $usuario->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <!-- Correo electrónico del usuario -->
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo electrónico:</label>
                            <input type="email" name="email" id="email" value="{{ $usuario->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <!-- Rol del usuario -->
                        <div class="mb-4">
                            <label for="rol" class="block text-gray-700 text-sm font-bold mb-2">Rol:</label>
                            <select name="rol" id="rol" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="secretaria" {{ $usuario->rol === 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                                <option value="doctor" {{ $usuario->rol === 'doctor' ? 'selected' : '' }}>Doctor</option>
                            </select>
                        </div>

                        <!-- Botón de guardar cambios -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
