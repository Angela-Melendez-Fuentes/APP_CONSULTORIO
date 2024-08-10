<x-app-layout>
    <header class="bg-blue-200">
        <div class="bg-blue-200 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center bg-blue-200">
                <img src="{{ asset('images/medicamento.png') }}" alt="Registro" style="width: 600px; max-width: 100%;">
            </div>
        </div>
    </header>

    <div class="container mx-auto max-w-screen-md p-8 bg-white rounded shadow-md mt-20">
        <h3 class="text-lg font-bold mb-4">Editar Medicamento</h3>

        <form action="{{ route('medicamentos.update', $medicamento->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Medicamento</label>
                <input type="text" id="nombre" name="nombre" value="{{ $medicamento->nombre }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" value="{{ $medicamento->descripcion }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                <input type="number" step="0.01" id="precio" name="precio" value="{{ $medicamento->precio }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" value="{{ $medicamento->cantidad }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="text-right">
                <a href="{{ route('medicamentos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</a>
                <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded">Actualizar Medicamento</button>
            </div>
        </form>
    </div>
</x-app-layout>
