<x-app-layout>
    <header class="bg-blue-200 bg-blue-200">
        <div class="bg-blue-200 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center bg-blue-200">
                <img src="{{ asset('images/pacientesregistro.png') }}" alt="Registro" style="width: 283px; max-width: 100%;">
            </div>
        </div>
    </header>

    <div class="py-12 flex justify-center items-center bg-blue-200 bg-blue-200">
        <div class="max-w-full w-full mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto">
                <div class="container mx-auto p-8 bg-blue-200 text-black bg-blue-200  rounded-lg shadow-lg">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="max-w-2xl mx-auto" method="POST" action="{{ route('registro_paciente') }}" onsubmit="return validateForm()">
                        @csrf
                        <div class="mb-4">
                            <input type="text" name="nombre" id="nombre" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100    focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Nombre(s)" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <input type="text" name="apellido_p" id="apellido_p" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100    focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Apellido Paterno" required />
                            </div>
                            <div class="mb-4">
                                <input type="text" name="apellido_m" id="apellido_m" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100    focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Apellido Materno" required />
                            </div>
                        </div>
                        <div class="mb-4">
                            <input type="email" name="correo" id="correo" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100  focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Correo" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <input type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="telefono" id="telefono" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100   focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Teléfono (123-456-7890)" required />
                            </div>
                            <div class="mb-4">
                                <select name="genero_biologico" id="genero_biologico" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100     focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" required>
                                    <option value="" disabled selected>Selecciona el género</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100     focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Fecha de Nacimiento" required onchange="calculateAgeAndValidate()" />
                            </div>
                            <div class="mb-4">
                                <input type="text" name="age" id="age" class="block py-2.5 px-4 w-full text-sm text-black bg-gray-100     focus:outline-none focus:ring-0 focus:border-blue-600 rounded-md border-gray-300" placeholder="Edad (Años, Meses, Días)" required readonly />
                            </div>
                        </div>
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm w-full sm:w-auto px-5 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                            Registrar
                        </button>                   
                     </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setMaxDate() {
            const today = new Date();
            today.setDate(today.getDate() - 1); // Restar un día
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Los meses empiezan en 0
            const year = today.getFullYear();
            const maxDate = `${year}-${month}-${day}`;
            
            document.getElementById('fecha_nacimiento').setAttribute('max', maxDate);
        }

        function calculateAge(birthday) {
            const today = new Date();
            const birthDate = new Date(birthday);
            let ageYears = today.getFullYear() - birthDate.getFullYear();
            let ageMonths = today.getMonth() - birthDate.getMonth();
            let ageDays = today.getDate() - birthDate.getDate();

            if (ageDays < 0) {
                ageMonths--;
                ageDays += new Date(today.getFullYear(), today.getMonth(), 0).getDate(); // Number of days in previous month
            }

            if (ageMonths < 0) {
                ageYears--;
                ageMonths += 12;
            }

            if (ageYears > 0) {
                return `${ageYears} años`;
            } else if (ageMonths > 0) {
                return `${ageMonths} meses`;
            } else {
                return `${ageDays} días`;
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

