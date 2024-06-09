<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Cita;

class PacienteController extends Controller
{
    // Registra nuevo paciente
    public function registro_paciente(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_p' => 'required|string|max:255',
            'apellido_m' => 'required|string|max:255',
            'age' => 'required|integer',
            'correo' => 'required|email|unique:pacientes|max:255',
            'telefono' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero_biologico' => 'required|in:Masculino,Femenino',
        ]);

        Paciente::create($validatedData);
        return redirect()->route('paciente');
    }

    // Muestra el formulario para editar a los pacientes solo si está logueado como secretaria o admin
    public function edit($id) {
        if (auth()->user()->tipo === 'secretaria' || auth()->user()->tipo === 'admin') {
            $paciente = Paciente::findOrFail($id);
            return view('paciente.edit', compact('paciente'));        
        }
        return abort(403, 'No tienes permiso para acceder a esta página.');
    }

    // Actualiza en la base de datos lo que se cambie en la vista de editar pacientes
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_p' => 'required|string|max:255',
            'apellido_m' => 'required|string|max:255',
            'age' => 'required|integer',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:15',
            'fecha_nacimiento' => 'required|date',
            'genero_biologico' => 'required|string|max:255',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('paciente')->with('success', 'Paciente actualizado correctamente');
    }

    // Muestra la lista de los pacientes solo si está logueado
    public function paciente(Request $request) {
        $query = Paciente::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido_p', 'like', "%{$search}%")
                  ->orWhere('apellido_m', 'like', "%{$search}%")
                  ->orWhere('correo', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        $pacientes = $query->get();

        if (auth()->user()->tipo === 'secretaria' || auth()->user()->tipo === 'doctor') {
            return view('paciente.dashboard', ['pacientes' => $pacientes]);
        } elseif (auth()->user()->tipo === 'admin') {
            return view('paciente.dashboardADMIN', ['pacientes' => $pacientes]);
        }

        return abort(403, 'No tienes permiso para acceder a esta página.');
    }

    // Muestra el formulario de registrar nuevos pacientes
    public function registrar_paciente() {
        if (in_array(auth()->user()->tipo, ['secretaria', 'doctor', 'admin'])) {
            return view('paciente.registrar');
        }
        return abort(403, 'No tienes permiso para acceder a esta página.');
    }

    // Elimina un paciente
    public function destroy($id) {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return redirect()->route('paciente')->with('success', 'Paciente eliminado correctamente');
    }

    // Muestra los detalles de un paciente y sus citas
    public function show($id) {
        if (in_array(auth()->user()->tipo, ['doctor', 'secretaria', 'admin'])) {
            $paciente = Paciente::findOrFail($id);
            $citas = Cita::where('paciente_id', $paciente->id)->get();

            return view('paciente.show', compact('paciente', 'citas'));
        }
        return abort(403, 'No tienes permiso para acceder a esta página.');
    }
}
