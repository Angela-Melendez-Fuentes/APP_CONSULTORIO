<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-700 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid sm:grid-cols-2 gap-y-7 gap-x-12">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" name="name" id="name" value="{{ $usuario->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo electrónico:</label>
                            <input type="email" name="email" id="email" value="{{ $usuario->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                            <input type="text" name="telefono" id="telefono" value="{{ $usuario->telefono }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="rfc" class="block text-gray-700 text-sm font-bold mb-2">RFC:</label>
                            <input type="text" name="rfc" id="rfc" value="{{ $usuario->rfc }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4 sm:col-span-2">
                            <label for="tipo" class="block text-gray-700 text-sm font-bold mb-2">Rol:</label>
                            <select name="tipo" id="tipo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="admin" {{ $usuario->tipo === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="secretaria" {{ $usuario->tipo === 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                                <option value="doctor" {{ $usuario->tipo === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="doctor_colaborador" {{ $usuario->tipo === 'doctor_colaborador' ? 'selected' : '' }}>Doctor Colaborador</option>
                            </select>
                        </div>

                        <!-- Campos adicionales para doctores -->
                        <div id="doctorFields" class="sm:col-span-2 {{ ($usuario->tipo === 'doctor' || $usuario->tipo === 'doctor_colaborador') ? '' : 'hidden' }}">
                            <div class="mb-4">
                                <label for="cedula_profesional" class="block text-gray-700 text-sm font-bold mb-2">Cédula Profesional:</label>
                                <input type="text" name="cedula_profesional" id="cedula_profesional" value="{{ $usuario->cedula_profesional }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4">
                                <label for="especialidad" class="block text-gray-700 text-sm font-bold mb-2">Especialidad:</label>
                                <input type="text" name="especialidad" id="especialidad" value="{{ $usuario->especialidad }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('tipo').addEventListener('change', function() {
        var doctorFields = document.getElementById('doctorFields');
        if (this.value === 'doctor' || this.value === 'doctor_colaborador') {
            doctorFields.classList.remove('hidden');
        } else {
            doctorFields.classList.add('hidden');
        }
    });
</script>
