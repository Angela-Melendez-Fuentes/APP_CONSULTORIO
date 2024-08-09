<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/Historial.png') }}" alt="Historial Logo" class="w-10 h-10">
        </div>
    </header>

    <div class="py-12 bg-blue-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-blue-200 text-blue-800">
                            <th class="px-4 py-2">FECHA</th>
                            <th class="px-4 py-2">HORA</th>
                            <th class="px-4 py-2">NOMBRE</th>
                            <th class="px-4 py-2">CUENTA</th>
                            <th class="px-4 py-2">EXPEDIENTE</th>
                            <th class="px-4 py-2">PAGÓ</th>
                            <th class="px-4 py-2">ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($citas->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay citas registradas.</td>
                            </tr>
                        @else
                            @foreach ($citas as $cita)
                                @if ($cita->doctor_id === auth()->id())
                                    <tr class="bg-blue-100 border-b border-blue-200 dark:text-black">
                                        <td class="px-4 py-2">{{ $cita->fecha }}</td>
                                        <td class="px-4 py-2">{{ $cita->hora }}</td>
                                                                               
                                        <td class="px-4 py-2">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido_p }} {{ $cita->paciente->apellido_m }}</td>
                                        <td class="px-4 py-2 text-center">
                                            ${{ $cita->monto }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button id="factura-{{ $cita->id }}" class="text-red-600 hover:text-green-600" onclick="toggleCheck('factura-{{ $cita->id }}')">
                                                ▢
                                            </button>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button id="pago-{{ $cita->id }}" class="text-red-600 hover:text-green-600" onclick="toggleCheck('pago-{{ $cita->id }}')">
                                                ▢
                                            </button>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            Sin terminar<br>
                                            <a href="{{ route('cita.consulta', $cita->id) }}" class="text-blue-600 hover:text-blue-400">Ir a cita</a>
                                            <br>
                                            CITA #{{ $cita->id }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleCheck(id) {
            var element = document.getElementById(id);
            if (element.innerHTML === '▢') {
                element.innerHTML = '✅';
                element.classList.remove('text-red-600');
                element.classList.add('text-green-600');
            } else {
                element.innerHTML = '▢';
                element.classList.remove('text-green-600');
                element.classList.add('text-red-600');
            }
        }
    </script>
</x-app-layout>
