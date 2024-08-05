<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente; 
use App\Models\User;
use App\Models\Medicamento;
use App\Models\Consulta;

class CitaController extends Controller
{
    public function create(Request $request)
    {
        $date = $request->query('date'); 
        $pacientes = Paciente::all();
        $doctores = User::where('tipo', 'doctor')->get();

        return view('cita.agendar', [
            'pacientes' => $pacientes,
            'doctores' => $doctores,
            'date' => $date
        ]);
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

        $citaExistente = Cita::where('doctor_id', $request->doctor_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($citaExistente) {
            return redirect()->back()->withErrors(['hora' => 'Esta hora ya está ocupada para este doctor.']);
        }

        Cita::create([
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
            return view('cita.index', compact('citas'));
        }

        return redirect()->route('dashboard')->with('error', 'No tiene permisos para acceder a esta función.');
    }

    public function index()
    {
        $citas = Cita::orderByDesc('created_at')->get(); 
        return view('cita.index', compact('citas'));
    }

    public function horasOcupadas($fecha, $doctor_id)
    {
        $citas = Cita::where('fecha', $fecha)
            ->where('doctor_id', $doctor_id)
            ->pluck('hora')
            ->toArray();
        return response()->json($citas);
    }

    public function consulta(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $medicamentos = Medicamento::all();

        if ($request->isMethod('post')) {
            $cita->update($request->all());
            return redirect()->route('cita.consulta', ['id' => $id])->with('success', 'Signos vitales actualizados');
        }

        return view('cita.consulta', compact('cita', 'medicamentos'));
    }

    public function storeConsulta(Request $request, $citaId)
    {
        $request->validate([
            'receta' => 'required',
            'medicamentos' => 'nullable|array',
            'cantidades' => 'nullable|array',
            'frecuencias' => 'nullable|array',
        ]);

        $consulta = Consulta::create([
            'cita_id' => $citaId,
            'receta' => $request->receta,
        ]);

        if ($request->medicamentos && $request->cantidades && $request->frecuencias) {
            foreach ($request->medicamentos as $index => $medicamentoId) {
                $consulta->medicamentos()->attach($medicamentoId, [
                    'cantidad' => $request->cantidades[$index],
                    'frecuencia' => $request->frecuencias[$index],
                ]);
            }
        }

        return redirect()->route('cita.consulta', $citaId)->with('success', 'Consulta guardada exitosamente.');
    }

    
}
