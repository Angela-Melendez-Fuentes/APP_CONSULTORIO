<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 dark:bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/detalles.png') }}" alt="Detalles del paciente" style="width: 800px; max-width: 100%;">
        </div>
    </header>

    <div class="py-12 bg-blue-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">{{ $paciente->nombre }} {{ $paciente->apellido_p }} {{ $paciente->apellido_m }}</h3>

                <p><strong>Correo:</strong> {{ $paciente->correo }}</p>
                <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
                <p><strong>Fecha de Nacimiento:</strong> {{ $paciente->fecha_nacimiento }}</p>
                <p><strong>Género:</strong> {{ $paciente->genero_biologico }}</p>
                <p><strong>Edad:</strong> {{ $paciente->age }}</p>

                <div class="mt-6">
                    <a href="{{ route('paciente.edit', $paciente->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                    <form action="{{ route('paciente.destroy', $paciente->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('¿Estás seguro de que quieres eliminar este paciente?');">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-blue-200 dark: bg-blue-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Citas</h3>
                
                @if ($citas->isNotEmpty())
                    <!-- Iterar sobre todas las citas del paciente -->
                    @foreach ($citas as $cita)
                        <div class="mb-4">
                            <p><strong>Fecha y Hora:</strong> {{ $cita->fecha }} {{ $cita->hora }}</p>
                            <p><strong>Motivo:</strong> {{ $cita->motivo }}</p>
                            <p><strong>Observaciones:</strong> {{ $cita->observaciones }}</p>
                            <!-- Agregar enlace para ver detalles de la cita -->
                            <a href="{{ route('cita.consulta', $cita->id) }}" class="text-blue-600 hover:text-blue-400">Ver detalles de la cita</a>

                        </div>
                    @endforeach
                @else
                    <p>No hay citas registradas para este paciente.</p>
                @endif
            </div>
        </div>
    </div>
    
</x-app-layout>
