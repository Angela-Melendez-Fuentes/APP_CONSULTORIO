<x-app-layout>
    <header class="bg-blue-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <h2 class="text-2xl font-bold">Medicamentos</h2>
            </div>
        </div>
    </header>

    <div class="container mx-auto max-w-screen-xl p-8 bg-white rounded shadow-md mt-20">
        <div class="mb-4">
            <h3 class="text-lg font-bold">Lista de Medicamentos</h3>
            <ul>
                @foreach ($Medicamento as $medicamentos)
                    <li>{{ $medicamentos->Medicamento }} - Cantidad: {{ $medicamentos->cantidad }} - Precio: {{ $medicamentos->frecuencia }}</li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('medicamentos.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="medicamento" class="block text-sm font-medium text-gray-700">Medicamento</label>
                <input type="text" id="medicamento" name="medicamento" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="frecuencia" class="block text-sm font-medium text-gray-700">Precio</label>
                <input type="text" id="frecuencia" name="frecuencia" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Agregar Medicamento</button>
            </div>
        </form>
    </div>
</x-app-layout>
