<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use App\Models\Cita;
use App\Models\Paciente; 
use App\Models\User;
use App\Models\Medicamento;
use App\Models\Consulta;
use App\Models\Medicacion;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
use Dompdf\Options;



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
            'medicamentos' => 'array',
            'medicamentos.*.medicamento_id' => 'required|exists:medicamentos,id',
            'medicamentos.*.cantidad' => 'required|integer|min:1',
            'medicamentos.*.frecuencia' => 'required|string',
            'medicamentos.*.fecha_inicio' => 'required|date',
            'medicamentos.*.fecha_fin' => 'required|date|after_or_equal:medicamentos.*.fecha_inicio',
        ]);
    
        $citaExistente = Cita::where('doctor_id', $request->doctor_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();
    
        if ($citaExistente) {
            return redirect()->back()->withErrors(['hora' => 'Esta hora ya está ocupada para este doctor.']);
        }
    
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
    
        // Guardar los medicamentos
        $medicamentos = $request->input('medicamentos');
    
        if ($medicamentos && is_array($medicamentos)) {
            // Elimina medicamentos existentes relacionados con esta cita antes de agregar los nuevos
            Medicacion::where('cita_id', $cita->id)->delete();
    
            foreach ($medicamentos as $medicamento) {
                Medicacion::create([
                    'cita_id' => $cita->id,
                    'medicamento_id' => $medicamento['medicamento_id'],
                    'cantidad' => $medicamento['cantidad'],
                    'frecuencia' => $medicamento['frecuencia'],
                    'fecha_inicio' => $medicamento['fecha_inicio'],
                    'fecha_fin' => $medicamento['fecha_fin'],
                ]);
            }
        }
    
        return redirect()->route('cita.index')->with('success', 'Cita guardada exitosamente.');
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
    
        // Cargar la consulta relacionada, si existe
        $consulta = Consulta::where('cita_id', $id)->with('medicamentos')->first();
    
        if ($request->isMethod('post')) {
            $cita->update($request->all());
            return redirect()->route('cita.consulta', ['id' => $id])->with('success', 'Signos vitales actualizados');
        }
    
        return view('cita.consulta', compact('cita', 'medicamentos', 'consulta'));
    }



    public function updateStatus(Request $request, $id)
    {
        // Encuentra la cita por su ID
        $cita = Cita::findOrFail($id);
        
        // Cambia el estado de la cita
        $cita->estado = 'Terminada';
        $cita->save();
        
        // Redirige o devuelve una respuesta adecuada
        return redirect()->route('cita.index')->with('status', 'Cita terminada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
    
        // Validar la solicitud
        $request->validate([
            'talla' => 'nullable|numeric',
            'temperatura' => 'nullable|numeric',
            'peso' => 'nullable|numeric',
            'tension_arterial' => 'nullable|string',
            'saturacion_oxigeno' => 'nullable|numeric',
            'frecuencia_cardiaca' => 'nullable|numeric',
            'motivo' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'alergias' => 'nullable|string',
            'receta' => 'nullable|string',
        ]);
    
        // Actualizar la cita
        $cita->update($request->all());
    
        return redirect()->route('cita.index')->with('success', 'Cita actualizada exitosamente');
    }
    








// Función para generar el PDF
public function crear_pdf($id)
{
    // Obtener los datos de la cita por ID
    $cita = Cita::findOrFail($id);

    // Obtener el nombre del doctor autenticado
    $doctor = Auth::user()->name;

    // Configuración de opciones para Dompdf
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $options->set('isHtml5ParserEnabled', true);

    // Inicialización de Dompdf
    $dompdf = new Dompdf($options);

    // Contenido HTML para el PDF
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
        <title>Consulta PDF</title>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h1 { 
                font-size: 12px; 
                background-color: #bfdbfe; 
                color: black; 
                padding: 20px; 
                border-radius: 45px; 
                display: inline-block;
            }
            .content { text-align: center; margin-top: 20px; }
            .section-title {text-align: left; font-size: 12px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; }
            .section-content {text-align: left; font-size: 12px; margin-bottom: 20px; text-align: left; }
            .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; font-size: 12px; text-align: left; }
            .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Consultorio Vida y Bienestar</h1>
        </div>
        <div class="content">
            <h3 style="font-size: 13px;">'. $cita->paciente->nombre .' '. $cita->paciente->apellido_p .' '. $cita->paciente->apellido_m .'</h3>
            <p style="font-size: 12px;">Correo: '. $cita->paciente->correo .'</p>
            <p style="font-size: 12px;">Contacto: '. $cita->paciente->telefono .'</p>
            <p style="font-size: 12px;">Fecha de Nacimiento: '. $cita->paciente->fecha_nacimiento .'</p>
            <p style="font-size: 12px;">Género: '. $cita->paciente->genero_biologico .'</p>
            <p style="font-size: 12px;">Edad: '. $this->calculateAge($cita->paciente->fecha_nacimiento) .' años</p>

            <h3 class="section-title">Signos Vitales</h3>
            <div class="grid">
                <div><strong>Talla:</strong> '. $cita->talla .' cm</div>
                <div><strong>Peso:</strong> '. $cita->peso .' kg</div>
                <div><strong>Temperatura:</strong> '. $cita->temperatura .' °C</div>
                <div><strong>Tensión Arterial:</strong> '. $cita->tension_arterial .' mm/Hg</div>
                <div><strong>Saturación de Oxígeno:</strong> '. $cita->saturacion_oxigeno .' %</div>
                <div><strong>Frecuencia Cardíaca:</strong> '. $cita->frecuencia_cardiaca .' bpm</div>
            </div>

            <h3 class="section-title">Motivo de la Consulta</h3>
            <p class="section-content">'. $cita->motivo .'</p>

            <h3 class="section-title">Observaciones</h3>
            <p class="section-content">'. $cita->observaciones .'</p>

            <h3 class="section-title">Diagnóstico</h3>
            <p class="section-content">'. $cita->diagnostico .'</p>

            <h3 class="section-title">Alergias</h3>
            <p class="section-content">'. $cita->alergias .'</p>

            <h3 class="section-title">Medicamentos</h3>
            <p class="section-content">'. $cita->receta .'</p>
        </div>
        <div class="footer">
            <p>Atentamente, Dr. '. $doctor .'</p>
        </div>
    </body>
    </html>';

    // Cargar el contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // Renderizar el PDF
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Descargar el PDF
    return $dompdf->stream('consulta_cita_'.$cita->id.'.pdf');
}

// Función para calcular la edad
private function calculateAge($birthDate) {
    $birthDate = new \DateTime($birthDate);
    $today = new \DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}



}
