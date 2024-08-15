<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 dark:bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/agenda.png') }}" alt="Agenda Logo" class="w-10 h-10">
        </div>
    </header>

    <div class="py-12 bg-blue-100 min-h-screen flex">
        <div class="w-4/5 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex">
                <div class="w-1/3 pr-6" style="margin-right: 2cm;">
                    <!-- Contenedor del calendario -->
                    <div id="calendar-container" class="mb-6 bg-white dark:bg-gray-600 p-4 shadow-md rounded-lg" style="height: 400px; width: 300px;"></div>
                    <div id="agendar-container" class="text-center mt-4"></div>
                </div>
                <div class="w-2/3">
                    <!-- Contenedor para la fecha seleccionada -->
                    <div id="selected-date-container" class="mb-4 text-center text-blue-800 text-lg font-bold"></div>
                    <!-- Tabla de citas -->
                    <table id="appointments-table" class="w-full table-auto">
                        <thead>
                            <tr class="bg-blue-200 text-blue-800 dark:text-black">
                                <th class="px-4 py-2">HORA</th>
                                <th class="px-4 py-2">DÍA</th>
                                <th class="px-4 py-2">NOMBRE</th>
                                <th class="px-4 py-2 text-center">CUENTA</th>
                                <th class="px-4 py-2 text-center">EXPEDIENTE</th>
                                <th class="px-4 py-2 text-center">PAGÓ</th>
                                <th class="px-4 py-2 text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($citas->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center py-4 dark:text-black">No hay citas registradas.</td>
                                </tr>
                            @else
                            @foreach ($citas->sortBy('hora') as $cita)
                            @if ($cita->doctor_id === auth()->id())
                                <tr class="appointment-row bg-blue-100 border-b border-blue-200" data-date="{{ $cita->fecha }}">
                                    <td class="px-4 py-2">{{ $cita->hora }}</td>
                                    <td class="px-4 py-2">{{ $cita->fecha }}</td>
                                    <td class="px-4 py-2 whitespace-normal">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido_p }} {{ $cita->paciente->apellido_m }}</td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">${{ $cita->monto }}</td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <button id="factura-{{ $cita->id }}" class="text-red-600 hover:text-green-600" onclick="toggleCheck('factura-{{ $cita->id }}')">
                                            ▢
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <button id="pago-{{ $cita->id }}" class="text-red-600 hover:text-green-600" onclick="toggleCheck('pago-{{ $cita->id }}')">
                                            ▢
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if ($cita->estado === 'Terminada')
                                            <span class="text-green-600">Terminada</span>
                                        @else
                                            Sin terminar
                                            <br>
                                            <a href="{{ route('cita.consulta', $cita->id) }}" class="text-blue-600 hover:text-blue-400">Ir a cita</a>
                                        @endif
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
    </div>

    <style>
        #calendar-container {
            max-width: 400px;
            margin: auto;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .calendar-header button {
            background-color: #4299e1;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .calendar-header div {
            font-size: 1.2em;
            font-weight: bold;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }
        .calendar-grid div {
            text-align: center;
            padding: 10px 0;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            cursor: pointer;
        }
        .calendar-grid .header {
            background-color: #edf2f7;
            font-weight: bold;
        }
        .calendar-grid .has-appointments {
            background-color: #d6bcfa;
        }
        .calendar-grid .selected-day {
            background-color: #a3d5f7 !important;
        }
        .calendar-grid .day-cell {
            text-align: center;
            padding: 10px 0;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            cursor: pointer;
        }
        .calendar-grid .past-day {
            background-color: #f1f5f8;
            color: #b8c2cc;
        }
        .calendar-grid .future-day {
            background-color: #f7fafc;
        }
        .calendar-grid .disabled {
            pointer-events: none;
            opacity: 0.6;
        }
        .calendar-grid .has-appointments {
            background-color: #d6bcfa; 
        }
        .whitespace-nowrap {
            white-space: nowrap;
        }
        .whitespace-normal {
            white-space: normal;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarContainer = document.getElementById('calendar-container');
            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            const daysOfWeek = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
            const today = new Date(); // Fecha actual
            today.setDate(today.getDate() - 1); // No retrocede un día
            let currentMonth = today.getMonth();
            let currentYear = today.getFullYear();
            let selectedDate = today.toISOString().split('T')[0]; // Variable para almacenar la fecha seleccionada
            const appointments = @json($citas);

            function generateCalendar(month, year) {
                calendarContainer.innerHTML = '';
                document.getElementById('agendar-container').innerHTML = '';
                document.getElementById('selected-date-container').innerHTML = selectedDate ? `Fecha seleccionada: ${selectedDate}` : '';

                const header = document.createElement('div');
                header.classList.add('calendar-header');

                const prevButton = document.createElement('button');
                prevButton.innerHTML = '&lt;'; // Símbolo de menor bonis
                prevButton.classList.add('calendar-button');
                prevButton.addEventListener('click', function() {
                    currentMonth--;
                    if (currentMonth < 0) {
                        currentMonth = 11;
                        currentYear--;
                    }
                    generateCalendar(currentMonth, currentYear);
                });

                const nextButton = document.createElement('button');
                nextButton.innerHTML = '&gt;'; // Símbolo de mayor bonis
                nextButton.classList.add('calendar-button');
                nextButton.addEventListener('click', function() {
                    currentMonth++;
                    if (currentMonth > 11) {
                        currentMonth = 0;
                        currentYear++;
                    }
                    generateCalendar(currentMonth, currentYear);
                });

                const monthYear = document.createElement('div');
                monthYear.innerText = `${monthNames[month]} ${year}`;

                header.appendChild(prevButton);
                header.appendChild(monthYear);
                header.appendChild(nextButton);
                calendarContainer.appendChild(header);

                const calendarGrid = document.createElement('div');
                calendarGrid.classList.add('calendar-grid');

                daysOfWeek.forEach(day => {
                    const dayElement = document.createElement('div');
                    dayElement.innerText = day;
                    dayElement.classList.add('header');
                    calendarGrid.appendChild(dayElement);
                });

                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                for (let i = 0; i < firstDay; i++) {
                    const emptyCell = document.createElement('div');
                    calendarGrid.appendChild(emptyCell);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const currentDate = new Date(year, month, day);
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const hasAppointments = appointments.some(appointment => appointment.fecha === dateStr);

                    const dayCell = document.createElement('div');
                    dayCell.innerText = day;
                    dayCell.setAttribute('data-date', dateStr);
                    dayCell.classList.add('day-cell');

                    if (currentDate < today) {
                        dayCell.classList.add('past-day');
                        dayCell.classList.add('disabled');
                    } else {
                        dayCell.classList.add('future-day');
                        if (hasAppointments) {
                            dayCell.classList.add('has-appointments');
                        }
                        if (dateStr === selectedDate) {
                            dayCell.classList.add('selected-day');
                        }
                        dayCell.addEventListener('click', function() {
                            if (currentDate >= today) {
                                selectedDate = dateStr;
                                generateCalendar(currentMonth, currentYear);
                                filterAppointmentsByDate(dateStr);
                                showAgendarButton(dateStr);
                            }
                        });
                    }

                    calendarGrid.appendChild(dayCell);
                }

                calendarContainer.appendChild(calendarGrid);
                // Filtrar citas por la fecha actual al generar el calendario
                filterAppointmentsByDate(selectedDate);
            }

            function filterAppointmentsByDate(date) {
                const rows = document.querySelectorAll('.appointment-row');
                rows.forEach(row => {
                    if (row.getAttribute('data-date') === date) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            function showAgendarButton(date) {
                const agendarContainer = document.getElementById('agendar-container');
                agendarContainer.innerHTML = '';
                const agendarButton = document.createElement('a');
                agendarButton.href = `{{ url('cita/agendar') }}?date=${date}`;
                agendarButton.classList.add('bg-blue-500', 'text-white', 'p-2', 'rounded', 'shadow-md', 'hover:bg-blue-700');
                agendarButton.innerText = 'Agendar';
                agendarContainer.appendChild(agendarButton);
            }

            generateCalendar(currentMonth, currentYear);
        });

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
