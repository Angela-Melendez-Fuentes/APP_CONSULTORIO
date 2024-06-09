<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-700 leading-tight">
            {{ __('Citas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Todas las Citas</h3>
                
                @if ($citas->isEmpty())
                    <p>No hay citas registradas.</p>
                @elseif ($citas->where('doctor_id', auth()->id())->isEmpty())
                    <p>No hay citas registradas para este doctor.</p>
                @else
                    <!-- Iterar sobre todas las citas -->
                    @foreach ($citas as $cita)
                        @if ($cita->doctor_id === auth()->id())
                            <!-- Mostrar nombre del paciente -->
                            <h4 class="font-semibold mb-2">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido_p }} {{ $cita->paciente->apellido_m }}</h4>
                            <div class="mb-8 border-b border-gray-200 last:border-b-0">
                                <div class="flex justify-between items-center mb-4">
                                    
                                </div>
                                <div>
                                    <p class="font-semibold">Fecha y Hora:</p>
                                    <p>{{ $cita->fecha }} {{ $cita->hora }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Motivo:</p>
                                    <p>{{ $cita->motivo }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Observaciones:</p>
                                    <p>{{ $cita->observaciones }}</p>
                                </div>




                                <div class="bg-gray-100 p-4 rounded-lg">
                                    <h4 class="font-semibold mb-2">Detalles del Paciente:</h4>
                                    <table>
                                        <tr>
                                            <p><strong>Correo:</strong></p>
                                            <p>{{ $cita->paciente->correo }}</p>
                                        </tr>
                                        <tr>
                                            <p><strong>Teléfono:</strong></p>
                                            <p>{{ $cita->paciente->telefono }}</p>
                                        </tr>
                                        <tr>
                                            <p><strong>Fecha de Nacimiento:</strong></p>
                                            <p>{{ $cita->paciente->fecha_nacimiento }}</p>
                                        </tr>
                                        <tr>
                                            <p><strong>Género:</strong></p>
                                            <p>{{ $cita->paciente->genero_biologico }}</p>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
