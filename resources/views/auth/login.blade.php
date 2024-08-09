@extends('layouts.inicio-layout')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-white dark:bg-gray-800 dark:text-gray-400">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">Consultorio Vida y Bienestar</h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-white">
                Cuidamos tu salud con corazón
            </p>
        </div>
        <div class="w-full max-w-sm space-y-6">
            <form class="mt-8 space-y-4" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-900 dark:text-gray-400" />
                    <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                type="email" name="email" :value="old('email')" 
                                required autofocus autocomplete="username" 
                                placeholder="Correo electrónico"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="text-gray-900 dark:text-gray-400" />
                    <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                type="password"
                                name="password"
                                required autocomplete="current-password" 
                                placeholder="Contraseña" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 border-gray-300 dark:border-gray-700 rounded dark:bg-gray-700">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-white"> Recuérdame </label>
                    </div>

                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300"> ¿Olvidaste tu contraseña/usuario? </a>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 mx-auto block" style="width: 200px;">
                        Entrar
                    </button>
                    
                    
                </div>
            </form>

            <style>
            .custom-link {
                display: flex;
                align-items: center;
                text-sm;
                color: #4a5568; /* gray-600 */
                transition: color 0.2s ease;
                border-radius: 0.375rem; /* rounded-md */
                padding: 0.9rem; /* p-2 */
                text-decoration: none;
            }
            
            .custom-link:hover {
                color: #2b6cb0; /* hover:text-gray-900 (dark mode) */
            }
            
            .custom-content {
                display: flex;
                align-items: center;
            }
            
            .icon {
                width: 24px;
                height: 24px;
                margin-right: 0.5rem; /* mr-2 */
                filter: drop-shadow(0 0 3px rgb(255, 255, 255)); /* apply white glow */
            }
            
            .custom-link.dark-mode .icon {
                filter: drop-shadow(0 0 6px rgb(255, 255, 255)); /* more glow for dark mode */
            }
            
            .custom-link .custom-content {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .text-center {
                text-align: center;
            }
            
            </style>

            <div class="flex justify-between mt-8">
                <a href="" class="custom-link">
                    <div class="custom-content">
                        <img src="{{ asset('images/expedientes-icon.png') }}" alt="Expedientes Icon" class="icon">
                        <div class="text-center">
                            Soy Cliente <br> EXPEDIENTES
                        </div>
                    </div>
                </a>

                <a href="" class="custom-link">
                    <div class="custom-content">
                        <img src="{{ asset('images/cita-icon.png') }}" alt="Cita Icon" class="icon">
                        <div class="text-center">
                            Soy Nuevo <br> HACER CITA
                        </div>
                    </div>
                </a>
            </div>
            
        </div>
        <div class="absolute right-10 bottom-10">
        </div>
    </div>
@endsection
