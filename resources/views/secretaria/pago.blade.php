<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-700 leading-tight">
            {{ __('Pagos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-md rounded-lg bg-white p-6">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-white bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3">Doctor Name</th>
                            <th scope="col" class="px-6 py-3">Specialty</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900">Dr. John Doe</th>
                            <td class="px-6 py-4">Cardiology</td>
                            <td class="px-6 py-4">johndoe@example.com</td>
                            <td class="px-6 py-4">(555) 123-4567</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900">Dr. Jane Smith</th>
                            <td class="px-6 py-4">Neurology</td>
                            <td class="px-6 py-4">janesmith@example.com</td>
                            <td class="px-6 py-4">(555) 234-5678</td>
                        </tr>
                        <tr class="bg-white">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900">Dr. Emily Johnson</th>
                            <td class="px-6 py-4">Pediatrics</td>
                            <td class="px-6 py-4">emilyjohnson@example.com</td>
                            <td class="px-6 py-4">(555) 345-6789</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-6 flex justify-end">
                    <button onclick="window.location.href='doctores/registrar_doctores'" type="button" class="text-white bg-gradient-to-r from-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5">
                        Registrar Pago
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
