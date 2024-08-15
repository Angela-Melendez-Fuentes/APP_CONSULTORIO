<x-app-layout>
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 flex items-center justify-center">
            <img src="{{ asset('images/editar.png') }}" alt="Editar pacientes" style="width: 800px; max-width: 100%;">
        </div>
    </header>

    
    <div class="py-12 bg-blue-200">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-hidden shadow-lg rounded-lg bg-white p-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('paciente.update', $paciente->id) }}" method="POST" class="space-y-6" onsubmit="return validateForm()">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" value="{{ $paciente->nombre }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="apellido_p" class="block text-gray-700 font-medium mb-2">Apellido Paterno:</label>
                        <input type="text" name="apellido_p" id="apellido_p" value="{{ $paciente->apellido_p }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="apellido_m" class="block text-gray-700 font-medium mb-2">Apellido Materno:</label>
                        <input type="text" name="apellido_m" id="apellido_m" value="{{ $paciente->apellido_m }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="age" class="block text-gray-700 font-medium mb-2">Edad:</label>
                        <input type="text" name="age" id="age" value="{{ $paciente->age }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="correo" class="block text-gray-700 font-medium mb-2">Correo:</label>
                        <input type="email" name="correo" id="correo" value="{{ $paciente->correo }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="telefono" class="block text-gray-700 font-medium mb-2">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" value="{{ $paciente->telefono }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="fecha_nacimiento" class="block text-gray-700 font-medium mb-2">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $paciente->fecha_nacimiento }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500" onchange="calculateAgeAndValidate()">
                    </div>

                    <div class="mb-4">
                        <label for="genero_biologico" class="block text-gray-700 font-medium mb-2">Género:</label>
                        <select name="genero_biologico" id="genero_biologico" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                            <option value="Masculino" {{ $paciente->genero_biologico == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ $paciente->genero_biologico == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setMaxDate() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Los meses empiezan en 0
            const year = today.getFullYear();
            const maxDate = `${year}-${month}-${day}`;
            
            document.getElementById('fecha_nacimiento').setAttribute('max', maxDate);
        }

        function calculateAge(birthday) {
            const today = new Date();
            const birthDate = new Date(birthday);
            const diffTime = Math.abs(today - birthDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const ageYears = Math.floor(diffDays / 365);
            const ageMonths = Math.floor(diffDays / 30);
            const ageWeeks = Math.floor(diffDays / 7);

            if (ageYears >= 2) {
                return `${ageYears} años`;
            } else if (ageMonths >= 2) {
                return `${ageMonths} meses`;
            } else {
                return `${diffDays} días`;
            }
        }

        function calculateAgeAndValidate() {
            const birthDate = document.getElementById('fecha_nacimiento').value;
            const ageField = document.getElementById('age');
            const calculatedAge = calculateAge(birthDate);
            ageField.value = calculatedAge;
        }

        function validateForm() {
            const birthDate = document.getElementById('fecha_nacimiento').value;
            const today = new Date().toISOString().split('T')[0]; // Obtener la fecha actual en formato YYYY-MM-DD
            
            if (birthDate > today) {
                alert('La fecha de nacimiento no puede ser futura.');
                return false;
            }

            const ageField = document.getElementById('age').value;
            const calculatedAge = calculateAge(birthDate);

            if (ageField !== calculatedAge) {
                alert('La edad no coincide con la fecha de nacimiento.');
                return false;
            }
            return true;
        }

        // Establecer la fecha máxima al cargar la página
        document.addEventListener('DOMContentLoaded', setMaxDate);
    </script>
</x-app-layout>
