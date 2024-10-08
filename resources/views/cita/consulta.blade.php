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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                 const citaId = '{{ $cita->id }}'; 
                
                updateEventListeners();

                //"Terminar" button
                const terminarButton = document.getElementById('terminarButton');
                if (terminarButton) {
                    terminarButton.addEventListener('click', function (event) {
                        event.preventDefault(); 
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¡La cita será marcada como terminada!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, terminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '{{ route('cita.updateStatus', $cita->id) }}';

                                const csrfInput = document.createElement('input');
                                csrfInput.type = 'hidden';
                                csrfInput.name = '_token';
                                csrfInput.value = '{{ csrf_token() }}';
                                form.appendChild(csrfInput);

                                const methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'PATCH';
                                form.appendChild(methodInput);

                                document.body.appendChild(form);
                                form.submit();

                                Swal.fire(
                                    'Terminada!',
                                    'La cita ha sido marcada como terminada exitosamente.',
                                    'success'
                                ).then(() => {
                                    window.location.href = `{{ route('cita.consulta', ':id') }}`.replace(':id', citaId); //Regresarme a la misma cita!! ???
                                });
                            }
                        });
                    });
                }


                
                //  "Actualizar" button
                const updateButton = document.getElementById('updateButton');
                if (updateButton) {
                    updateButton.addEventListener('click', function (event) {
                        Swal.fire({
                            title: 'Actualizada!',
                            text: "La cita ha sido actualizada correctamente.",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            window.location.href = `{{ route('cita.consulta', ':id') }}`.replace(':id', citaId); //Regresarme a la misma cita!!
                        });
                    });
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
                            <option value="{{ $medicamento->id }}" class="text-black">{{ $medicamento->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="cantidades[]" class="w-full p-2 border rounded" placeholder="Ingerir" oninput="validatePositive(this)">
                    <input type="text" name="frecuencias[]" class="w-full p-2 border rounded" placeholder="Toma cada">
                    <button type="button" class="bg-purple-400 text-white px-4 py-2 rounded" onclick="removeMedicationRow(this)">Eliminar</button>
                `;
                container.appendChild(row);

                updateEventListeners();
            }

            function removeMedicationRow(button) {
                button.parentElement.remove();
                updateSelectedMedications();
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

            function updateSelectedMedications() {
                const container = document.getElementById('medication-container');
                const selectedList = document.getElementById('selected-medications');
                selectedList.innerHTML = '';

                const rows = container.getElementsByClassName('grid');
                Array.from(rows).forEach(row => {
                    const medication = row.querySelector('select').selectedOptions[0].text;
                    const quantity = row.querySelector('input[name="cantidades[]"]').value;
                    const frequency = row.querySelector('input[name="frecuencias[]"]').value;

                    if (medication && quantity && frequency) {
                        const listItem = document.createElement('li');
                        listItem.textContent = `${medication} - Ingerir: ${quantity}, Toma cada: ${frequency}`;
                        selectedList.appendChild(listItem);
                    }
                });
            }

            function updateEventListeners() {
            document.querySelectorAll('select[name="medicamentos[]"]').forEach(select => {
                select.removeEventListener('change', updateSelectedMedications); 
                select.addEventListener('change', () => {
                    updateSelectedMedications();
                    transferMedicationsToReceta(); 
                });
            });

            document.querySelectorAll('input[name="cantidades[]"]').forEach(input => {
                input.removeEventListener('input', updateSelectedMedications); 
                input.addEventListener('input', () => {
                    updateSelectedMedications();
                    transferMedicationsToReceta();
                });
            });

            document.querySelectorAll('input[name="frecuencias[]"]').forEach(input => {
                input.removeEventListener('input', updateSelectedMedications); 
                input.addEventListener('input', () => {
                    updateSelectedMedications();
                    transferMedicationsToReceta(); 
                });
            });
        }


            function transferMedicationsToReceta() {
                const container = document.getElementById('medication-container');
                const recetaField = document.querySelector('textarea[name="receta"]');
                let recetaText = recetaField.value.trim(); // Mantiene el texto existente

                const rows = container.getElementsByClassName('grid');
                Array.from(rows).forEach(row => {
                    const medication = row.querySelector('select').selectedOptions[0].text;
                    const quantity = row.querySelector('input[name="cantidades[]"]').value;
                    const frequency = row.querySelector('input[name="frecuencias[]"]').value;

                    if (medication && quantity && frequency) {
                        recetaText += `\n${medication} - Ingerir: ${quantity}, Toma cada: ${frequency}`;
                    }
                });

                recetaField.value = recetaText.trim(); // Inserta el texto formateado en el campo "Receta"
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
                <p>Edad: {{ $cita->paciente->age }}</p> 
            </div>

            <!-- Formulario para actualizar la cita -->
            <form action="{{ route('cita.update', $cita->id) }}" method="POST">
                 @csrf
                @method('PATCH')
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
                    <h3 class="text-lg font-bold mb-4">Observaciones</h3>
                    <textarea class="w-full p-2 border rounded" name="observaciones" rows="4">{{ $cita->observaciones }}</textarea>
                </div>

                <!-- Diagnóstico -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Diagnóstico</h3>
                    <textarea id="diagnostico" name="diagnostico" class="w-full p-2 border rounded" rows="3">{{ $cita->diagnostico }}</textarea>
                </div>

                <!-- Alergias -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Alergias</h3>
                    <textarea id="alergias" name="alergias" class="w-full p-2 border rounded" rows="2">{{ $cita->alergias }}</textarea>
                </div>





                <div id="medication-container" class="mb-4">
                    <!-- Los medicamentos se agregan aqui -->
                </div>
                <button type="button" onclick="addMedicationRow()" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Medicamento</button>
                
                
                <button type="button" onclick="transferMedicationsToReceta()" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar a la receta</button>


                <div class="mb-4 mt-4">
                    <label for="receta" class="block text-gray-700 text-sm font-bold mb-2">Receta</label>
                    <textarea name="receta" id="receta" rows="4" class="w-full border rounded p-2">{{ $cita->receta }}</textarea>
                </div>


                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Enfermero Asignado</h3>
                    <select name="enfermero_id" class="w-full p-2 border rounded">
                        <option value="" class="text-black">Seleccione un enfermero</option>
                        @foreach($enfermeros as $enfermero)
                            <option value="{{ $enfermero->id }}" {{ $cita->enfermero_id == $enfermero->id ? 'selected' : '' }}>{{ $enfermero->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mt-8 text-center">
                    @if ($cita->estado !== 'Terminada')
                        <button type="submit" class="bg-blue-200 text-black px-4 py-2 rounded" id="updateButton">Actualizar</button>
                        <br>
                        <br>
                    @endif
                </div>

                
            </form>




            <div class="text-right">
                @if ($cita->estado === 'Terminada')
                    <div class="mt-8 text-center">
                        <a href="{{ route('cita.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Volver al Historial</a>
                        <br>
                        <br>
                    </div>
                @else
                    <button type="button" id="terminarButton" class="bg-green-500 text-white px-4 py-2 rounded">Terminar</button>
                @endif

            </div>
            <div class="text-right">
                @if ($cita->estado === 'Terminada')
                    <div class="mt-8 text-right">
                        <a href="{{ route('cita.descargarPDF', $cita->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Descargar Expediente</a>
                    </div>
                @endif    
            </div>
            
        </div>
    </body>
    </html>
</x-app-layout>
