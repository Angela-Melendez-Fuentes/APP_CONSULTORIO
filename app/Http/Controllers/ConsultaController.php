<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Medicamento;

class ConsultaController extends Controller
{ public function store(Request $request, $citaId)
    {
        $request->validate([
            'medicamentos.*' => 'required|exists:medicamentos,id',
            'cantidades.*' => 'required|integer|min:1',
            'frecuencias.*' => 'required|string',
        ]);
    
        // Encuentra o crea la consulta
        $consulta = Consulta::firstOrCreate(
            ['cita_id' => $citaId],
            [
                'motivo' => $request->input('motivo'),
                'diagnostico' => $request->input('diagnostico'),
                'receta' => $request->input('receta'),
                'alergias' => $request->input('alergias'),
            ]
        );
    
        // Verificar si la consulta fue creada o encontrada
        if (!$consulta) {
            return redirect()->back()->withErrors(['error' => 'No se pudo crear la consulta.']);
        }
    
        // Sincronizar medicamentos
        $medicamentosData = [];
        $medicamentos = $request->input('medicamentos', []);
        $cantidades = $request->input('cantidades', []);
        $frecuencias = $request->input('frecuencias', []);
    
        foreach ($medicamentos as $index => $medicamentoId) {
            if (!empty($medicamentoId)) {
                $medicamentosData[$medicamentoId] = [
                    'cantidad' => $cantidades[$index],
                    'frecuencia' => $frecuencias[$index],
                ];
            }
        }
    
        $consulta->medicamentos()->sync($medicamentosData);
    
        // Asegúrate de que la sincronización se realizó correctamente
        if (!$consulta->wasRecentlyCreated && !$consulta->medicamentos()->exists()) {
            return redirect()->back()->withErrors(['error' => 'No se pudieron asociar los medicamentos a la consulta.']);
        }
    
        // Finalmente, redirigir a la vista de consulta
        return redirect()->route('consulta.show', $consulta->id)->with('success', 'Consulta guardada exitosamente.');
    }
    
    
}

