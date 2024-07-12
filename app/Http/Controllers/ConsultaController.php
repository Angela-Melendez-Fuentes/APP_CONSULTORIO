<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;

class ConsultaController extends Controller
{
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'alergias' => 'nullable|string',
            'receta' => 'nullable|string',
            'medicamentos' => 'nullable|array',
            'cantidades' => 'nullable|array',
            'frecuencias' => 'nullable|array',
        ]);

        foreach ($request->medicamentos as $index => $medicamento) {
            if ($medicamento) {
                Consulta::create([
                    'cita_id' => $id,
                    'alergias' => $request->alergias,
                    'receta' => $request->receta,
                    'medicamento' => $medicamento,
                    'cantidad' => $request->cantidades[$index],
                    'frecuencia' => $request->frecuencias[$index],
                ]);
            }
        }

        return redirect()->route('cita.show', $id)->with('success', 'Consulta guardada exitosamente.');
    }
}
