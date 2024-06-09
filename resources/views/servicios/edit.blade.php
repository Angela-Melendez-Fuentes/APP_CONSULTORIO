<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-700 leading-tight">
            {{ __('Editar Servicio') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
                <form method="POST" action="{{ route('servicios.update', $servicio->id) }}">
                    @csrf
                    @method('PUT') 

                    <div>
                        <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="mt-1 p-2 border rounded-md w-full" value="{{ $servicio->nombre }}" required autofocus />
                    </div>

                    <div class="mt-4">
                        <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="mt-1 p-2 border rounded-md w-full" required>{{ $servicio->descripcion }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label for="precio" class="block font-medium text-sm text-gray-700">Precio</label>
                        <input type="number" name="precio" id="precio" class="mt-1 p-2 border rounded-md w-full" value="{{ $servicio->precio }}" required />
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded-md">Actualizar Servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
