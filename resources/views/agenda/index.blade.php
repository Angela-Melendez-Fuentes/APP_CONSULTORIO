<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/Historial.png') }}" alt="Historial Logo" class="w-10 h-10">
        </div>
    </header>
    

    <div class="py-12 bg-blue-100 min-h-screen">

        
<div class="relative max-w-sm">
    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
       <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
        </svg>
    </div>
    <input datepicker type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
</div>
  
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">
                
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-blue-200 text-blue-800">
                            <th class="px-4 py-2">FECHA</th>
                            <th class="px-4 py-2">NOMBRE</th>
                            <th class="px-4 py-2">CUENTA</th>
                            <th class="px-4 py-2">FACTURA</th>
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
                                    <tr class="bg-blue-100 border-b border-blue-200">
                                        <td class="px-4 py-2">{{ $cita->fecha }}<br>{{ $cita->hora }}</td>
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
                                            <a href="#" class="text-blue-600 hover:text-blue-400">Ver cita</a><br>
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
                element.innerHTML = '✔';
                element.classList.remove('text-red-600');
                element.classList.add('text-green-600');
            } else {
                element.innerHTML = '▢';
                element.classList.remove('text-green-600');
                element.classList.add('text-red-600');
            }
        }
    </script>



     <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js">
        // Configurar el datepicker
        document.addEventListener('DOMContentLoaded', function() {
            const datepicker = new Datepicker(document.querySelector('[datepicker]'), {
                format: 'yyyy-mm-dd', // Formato de fecha deseado
                buttonClass: 'bg-blue-500 text-white px-3 py-1 rounded-lg', // Clase para el botón
                overlay: true, // Mostrar un overlay
                autohide: true // Ocultar automáticamente el datepicker después de seleccionar una fecha
            });
        });
    </script>
    
</x-app-layout>
