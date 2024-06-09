@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="font-bold text-2xl text-blue-700 leading-tight mb-4">
        {{ __('Panel de Administración') }}
    </h2>

    <div class="flex space-x-4">
        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('Registro de Personal') }}
        </a>
        <a href="{{ route('pacientes.registrar_pacientes') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            {{ __('Registro de Pacientes') }}
        </a>
    </div>
</div>
@endsection