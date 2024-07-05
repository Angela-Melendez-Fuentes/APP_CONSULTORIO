<x-app-layout>
    
    <header class="bg-blue dark:bg-blue-200 shadow">
        <div class="bg-blue-200 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center bg-blue-200">
                <img src="{{ asset('images/pacientesregistro.png') }}" alt="Registro" style="width: 283px; max-width: 100%;">
            </div>
        </div>
    </header>
    
        <div class="relative max-w-1xl mx-auto p-6 -mt-24">
            <div class="text-center mb-8">           
            </div>
            <form method="POST" action="{{ route('admin.register') }}" class="bg-white max-w-xl w-full mx-auto shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-6 rounded-md">
                @csrf
                <div class="grid sm:grid-cols-2 gap-y-7 gap-x-12">
                <h4 class="text-center -mb-2 -mt-2 text-base font-semibold mt-10 sm:col-span-2">Registrar nuevo personal</h4>
                    <!-- Name -->
                    <div>
                        <label class="text-sm mt-1 mb-1 block">{{ __('Nombre') }}</label>
                        <x-text-input id="name" class="bg-gray-100 w-full text-sm px-4 py-3.5 rounded-md outline-blue-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nombre" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Email Address -->
                    <div>
                        <label class="text-sm mt-1 mb-1 block">{{ __('Correo electrónico') }}</label>
                        <x-text-input id="email" class="bg-gray-100 w-full text-sm px-4 py-3.5 rounded-md outline-blue-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Correo electrónico" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Password -->
                    <div>
                        <label class="text-sm mt-1 mb-1 block">{{ __('Contraseña') }}</label>
                        <x-text-input id="password" class="bg-gray-100 w-full text-sm px-4 py-3.5 rounded-md outline-blue-500" type="password" name="password" required autocomplete="new-password" placeholder="Contraseña" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Confirm Password -->
                    <div>
                        <label class="text-sm mt-1 mb-1 block">{{ __('Confirmar contraseña') }}</label>
                        <x-text-input id="password_confirmation" class="bg-gray-100 w-full text-sm px-4 py-3.5 rounded-md outline-blue-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirma contraseña" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <!-- Tipo -->
                    <div class="sm:col-span-2">
                        <label class="text-sm mt-1 mb-1 block">{{ __('Tipo de Empleado') }}</label>
                        <select id="tipo" name="tipo" class="bg-gray-100 w-full text-sm px-4 py-3.5 rounded-md outline-blue-500" required>
                            <option value="">{{ __('Seleccione el tipo de personal') }}</option>
                            <option value="secretaria">{{ __('Secretaria (o)') }}</option>
                            <option value="doctor">{{ __('Médico') }}</option>
                            <option value="doctor">{{ __('Médico Colaborador') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                    </div>
                </div>

                
                <div class="mt-8 flex items-center justify-between">
                    <a href="{{ route('welcome') }}" class="text-blue-600 hover:underline">{{ __('Volver') }}</a>
                    <button type="submit" class="min-w-[150px] py-3 px-4 text-sm font-semibold rounded text-white" style="background-color: #12229d; hover:bg-[#0f1b81]; focus:outline-none;">
                        {{ __('Registrar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
