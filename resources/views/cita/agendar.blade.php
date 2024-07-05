<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/registrarCita.png') }}" alt="Pacientes Logo" style="width: 283px; max-width: 100%;">
        </div>
    </header>

    <div class="py-12 flex justify-center items-center bg-blue-200">
        <div class="max-w-4xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
    
                <form action="{{ route('cita.store') }}" method="POST">
                    @csrf
    
                    <div class="mb-4">
                        <label for="paciente_id" class="block text-gray-700 text-sm font-bold mb-2">Paciente:</label>
                        <select required name="paciente_id" id="paciente_id" class="form-select block w-full mt-1 text-black bg-gray-100 rounded-md">
                            <option value="">Seleccione un paciente</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->nombre }} {{ $paciente->apellido_p }} {{ $paciente->apellido_m }} | {{ $paciente->correo }} | {{ $paciente->fecha_nacimiento }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="mb-4">
                        <label for="doctor_id" class="block text-gray-700 text-sm font-bold mb-2">Doctor:</label>
                        <select name="doctor_id" id="doctor_id" class="form-select block w-full mt-1 text-black bg-gray-100 rounded-md">
                            <option value="">Seleccione un doctor</option>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="mb-4">
                        <label for="fecha" class="block text-gray-700 text-sm font-bold mb-2">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" class="form-input mt-1 w-full bg-gray-100 text-gray-700 rounded-md" value="{{ $date }}">
                    </div>

                    <div class="mb-4">
                        <label for="hora" class="block text-gray-700 text-sm font-bold mb-2">Hora:</label>
                        <input type="time" name="hora" id="hora" class="form-input mt-1 w-full bg-gray-100 text-gray-700 rounded-md" step="1800">
                    </div>
                    
                    <div class="mb-6">
                        <label for="motivo" class="block text-gray-700 text-sm font-bold mb-2">Motivo:</label>
                        <textarea name="motivo" id="motivo" class="form-textarea mt-1 w-full bg-gray-100 text-gray-700 rounded-md"></textarea>
                    </div>
    
                    <div class="mb-4">
                        <label for="monto" class="block text-gray-700 text-sm font-bold mb-2">Monto de la cita:</label>
                        <input type="number" name="monto" id="monto" class="form-input mt-1 w-full bg-gray-100 text-gray-700 rounded-md" required>
                    </div>
    
                    <div class="mb-6">
                        <label for="observaciones" class="block text-gray-700 text-sm font-bold mb-2">Observaciones (Opcional):</label>
                        <textarea name="observaciones" id="observaciones" class="form-textarea mt-1 w-full bg-gray-100 text-gray-700 rounded-md"></textarea>
                    </div>
    
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Agendar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
