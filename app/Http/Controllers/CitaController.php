<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
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
    
        DB::transaction(function () use ($request) {
            $cita = Cita::create([
                'paciente_id' => $request->paciente_id,
                'doctor_id' => $request->doctor_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'pagada' => false,
            ]);

            Pago::create([
                'cita_id' => $cita->id,
                'tipo_pago' => 'cita',
                'monto' => $request->monto,  
                'fecha_pago' => null,
                'metodo_pago' => null,
                'usuario_id' => auth()->id(), 
                'estado' => 'pendiente',
            ]);
        });

        return redirect()->route('cita.agendar')->with('success', 'Cita agendada exitosamente.');
    }

    public function agendar_cita(){
        if (auth()->user()->tipo === 'secretaria') {
            $pacientes = Paciente::all();
            $doctores = User::where('tipo', 'doctor')->get();
            return view('cita.agendar', compact('pacientes', 'doctores'));
        }

        if (auth()->user()->tipo === 'doctor') {
            $pacientes = Paciente::all();
            $doctores = User::where('tipo', 'doctor')->get();
            return view('cita.agendar', compact('pacientes', 'doctores'));
        }
    }   

    public function index()
    {
        $citas = Cita::all(); // Obtener todas las citas
        return view('cita.index', compact('citas'));
    }


}

