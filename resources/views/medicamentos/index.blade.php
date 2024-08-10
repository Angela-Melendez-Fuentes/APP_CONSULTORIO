<x-app-layout>
    <header class="bg-blue-200">
        <div class="bg-blue-200 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center bg-blue-200">
                <img src="{{ asset('images/medicamento.png') }}" alt="Registro" style="width: 600px; max-width: 100%;">
            </div>
        </div>
    </header>

    <div class="container mx-auto max-w-screen-xl p-8 bg-white rounded shadow-md mt-20">
        <div class="text-right mb-4">
            <a href="{{ route('medicamentos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Medicamento</a>
        </div>

        <!-- Contenedor para centrar la tabla -->
        <div class="flex justify-center">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-blue-200">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-black tracking-wider">NOMBRE</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-black tracking-wider">DESCRIPCIÓN</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-black tracking-wider">PRECIO</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-black tracking-wider">CANTIDAD</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-black tracking-wider">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Medicamento as $medicamento)
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $medicamento->nombre }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $medicamento->descripcion }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $medicamento->precio }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $medicamento->cantidad }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <a href="{{ route('medicamentos.edit', $medicamento->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a> |

                                <form action="{{ route('medicamentos.destroy', $medicamento->id) }}" method="POST" class="delete-form" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-900 delete-button">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script para SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            @if(session('success'))
                Swal.fire({
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
            @endif
        });
    </script>
</x-app-layout>
