<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AgendaController extends Controller
{
    public function create()
    {
        $pacientes = Paciente::all();
        $doctores = User::where('tipo', 'doctor')->get();

        return view('cita.agendar', ['pacientes' => $pacientes, 'doctores' => $doctores]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'hora' => 'required', 
            'motivo' => 'required|string', 
            'monto' => 'required|numeric|min:0', 
        ]);
    
        $cita = Cita::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'motivo' => $request->motivo,
            'observaciones' => $request->observaciones,
            'monto' => $request->monto, 
            'pagada' => false,
        ]);


        return redirect()->route('cita.agendar')->with('success', 'Cita agendada exitosamente.');
    }
    public function agendar_cita()
    {
        if (auth()->user()->tipo === 'secretaria' || auth()->user()->tipo === 'doctor') {
            $citas = Cita::orderByDesc('created_at')->get();
            return view('agenda.index', compact('citas'));
        }

        return redirect()->route('dashboard')->with('error', 'No tiene permisos para acceder a esta función.');
    }   

    public function index()
    {
        $citas = Cita::orderByDesc('created_at')->get(); 
        return view('agenda.index', compact('citas'));
    }
}