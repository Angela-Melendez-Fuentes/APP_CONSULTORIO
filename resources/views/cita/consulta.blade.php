<x-app-layout>
    <header class="bg-blue-200">
        <div class="bg-blue-200 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center bg-blue-200"></div>
        </div>
    </header>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
        <title>Consulta</title>
        <script>
            function calculateAge(fechaNacimiento) {
                const today = new Date();
                const birthDate = new Date(fechaNacimiento);
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }

            document.addEventListener('DOMContentLoaded', function () {
                const birthDateElement = document.getElementById('fecha_nacimiento');
                const ageElement = document.getElementById('edad');
                if (birthDateElement && ageElement) {
                    const age = calculateAge(birthDateElement.textContent);
                    ageElement.textContent = age;
                }
            });

            function addMedicationRow() {
                const container = document.getElementById('medication-container');
                const row = document.createElement('div');
                row.className = 'grid grid-cols-4 gap-4 mt-4';
                row.innerHTML = `
                    <select name="medicamentos[]" class="w-full p-2 border rounded text-black">
                        <option value="" class="text-black">Seleccione un medicamento</option>
                        @foreach($medicamentos as $medicamento)
                            <option value="{{ $medicamento->id }}" class="text-black">{{ $medicamento->Medicamento }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="cantidades[]" class="w-full p-2 border rounded" placeholder="Cantidad" oninput="validatePositive(this)">
                    <input type="text" name="frecuencias[]" class="w-full p-2 border rounded" placeholder="Frecuencia">
                    <button type="button" class="bg-purple-400 text-white px-4 py-2 rounded" onclick="removeMedicationRow(this)">Eliminar</button>
                `;
                container.appendChild(row);
            }

            function removeMedicationRow(button) {
                button.parentElement.remove();
            }

            function validatePositive(input) {
                // Reemplazar caracteres no numéricos y el signo "-"
                input.value = input.value.replace(/[^0-9]/g, '');
            }

            function formatBloodPressure(input) {
                let value = input.value.replace(/[^\d]/g, ''); // Remover cualquier carácter que no sea número
                if (value.length > 3) {
                    input.value = value.slice(0, 3) + '/' + value.slice(3, 5); // Insertar '/' después del tercer dígito
                } else {
                    input.value = value;
                }
            }
        </script>
    </head>
    <style>
        .vital-signs {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #F0F4F8;
            border-radius: 0.5rem;
            padding: 1rem;
        }
        .vital-sign {
            text-align: center;
        }
        .vital-sign img {
            display: block;
            margin: 0 auto 0.5rem;
        }
    </style>
    <body class="bg-blue-200">
        <div class="container mx-auto max-w-screen-xl p-8 bg-white rounded shadow-md mt-20">
            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Cita #{{ $cita->id }}</h2>
                <h3 class="text-xl mb-4">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido_p }} {{ $cita->paciente->apellido_m }}</h3>
                <p>Correo: {{ $cita->paciente->correo }}</p>
                <p>Contacto: {{ $cita->paciente->telefono }}</p>
                <p id="fecha_nacimiento">Fecha de Nacimiento: {{ $cita->paciente->fecha_nacimiento }}</p>
                <p>Género: {{ $cita->paciente->genero_biologico }}</p>
                <p>Edad: <span id="edad"></span></p>
            </div>

            <form action="{{ route('cita.consulta', $cita->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Signos Vitales</h3>
                    
                    <div class="vital-signs">
                        <!-- Signos vitales -->
                        <div class="vital-sign">
                            <img src="{{ asset('images/icono-talla.png') }}" alt="Talla" style="width: 50px; max-width: 100%;">
                            <p><input type="number" id="talla" name="talla" value="{{ $cita->talla }}" min="0" class="w-20 h-10 p-2 border rounded" oninput="validatePositive(this)"></p>
                            <p>Talla (cm)</p>
                        </div>
                        <div class="vital-sign">
                            <img src="{{ asset('images/icono-tem.png') }}" alt="temperatura" style="width: 50px; max-width: 100%;">
                            <p><input type="number" id="temperatura" name="temperatura" value="{{ $cita->temperatura }}" min="0" class="w-20 h-10 p-2 border rounded" oninput="validatePositive(this)"></p>
                            <p>Temperatura (°C)</p>
                        </div>
                        <div class="vital-sign">
                            <img src="{{ asset('images/icono-peso.png') }}" alt="peso" style="width: 50px; max-width: 100%;">
                            <p><input type="number" id="peso" name="peso" value="{{ $cita->peso }}" min="0" class="w-20 h-10 p-2 border rounded" oninput="validatePositive(this)"></p>
                            <p>Peso (kg)</p>
                        </div>
                        <div class="vital-sign">
                            <img src="{{ asset('images/icono-TenArt.png') }}" alt="Arterial" style="width: 50px; max-width: 100%;">
                            <p><input type="text" id="tension_arterial" name="tension_arterial" value="{{ $cita->tension_arterial }}" class="w-20 h-10 p-2 border rounded" oninput="formatBloodPressure(this)"></p>
                            <p>Tensión Arterial (mm/Hg)</p>
                        </div>
                        <div class="vital-sign">
                            <img src="{{ asset('images/icono-Oxigeno.png') }}" alt="Oxígeno" style="width: 50px; max-width: 100%;">
                            <p><input type="number" id="saturacion_oxigeno" name="saturacion_oxigeno" value="{{ $cita->saturacion_oxigeno }}" min="0" class="w-20 h-10 p-2 border rounded" oninput="validatePositive(this)"></p>
                            <p>Saturación de Oxígeno (%)</p>
                        </div>
                        <div class="vital-sign">
                            <img src="{{ asset('images/icono-cardiaca.png') }}" alt="Cardíaca" style="width: 50px; max-width: 100%;">
                            <p><input type="number" id="frecuencia_cardiaca" name="frecuencia_cardiaca" value="{{ $cita->frecuencia_cardiaca }}" min="0" class="w-20 h-10 p-2 border rounded" oninput="validatePositive(this)"></p>
                            <p>Frecuencia Cardíaca (bpm)</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Motivo de la Consulta</h3>
                    <textarea class="w-full p-2 border rounded" name="motivo" rows="4">{{ $cita->motivo }}</textarea>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Alergias</h3>
                    <textarea class="w-full p-2 border rounded" name="alergias" rows="4" placeholder="Escribir aquí...">{{ $cita->alergias}}</textarea>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Diagnostico</h3>
                    <textarea class="w-full p-2 border rounded" name="diagnostico" rows="4">{{ $cita->diagnostico }}</textarea>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Receta</h3>
                    <textarea class="w-full p-2 border rounded" name="receta" rows="4">{{ $cita->receta }}</textarea>
                </div>




                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Medicamentos</h3>
                    <div id="medication-container">
                        <div class="grid grid-cols-4 gap-4">
                            <select name="medicamentos[]" class="w-full p-2 border rounded text-black">
                                <option value="" class="text-black">Seleccione un medicamento</option>
                                @foreach($medicamentos as $medicamento)
                                    <option value="{{ $medicamento->id }}" class="text-black">{{ $medicamento->Medicamento }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="cantidades[]" class="w-full p-2 border rounded" placeholder="Cantidad" oninput="validatePositive(this)">
                            <input type="text" name="frecuencias[]" class="w-full p-2 border rounded" placeholder="Frecuencia">
                            <button type="button" class="bg-purple-400 text-white px-4 py-2 rounded" onclick="removeMedicationRow(this)">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" onclick="addMedicationRow()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Agregar Otro Medicamento</button>
                </div>
                <div class="mt-8 text-right">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Terminar</button>
                </div>
            </form>
        </div>
    </body>
    </html>
</x-app-layout>
