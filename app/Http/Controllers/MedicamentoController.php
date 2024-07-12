<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicamento;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::all();
        return view('medicamentos.index', compact('medicamentos'));
    }
    
    public function mostrarFormulario()
    {
        $medicamentos = Medicamento::all(); // Medicamentos desde la base de datos JALAAAA COSAAAA
        return view('cita/consulta', compact('medicamentos'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'medicamento' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'frecuencia' => 'required|string|max:255',
        ]);

        Medicamento::create([
            'medicamento' => $request->medicamento,
            'cantidad' => $request->cantidad,
            'frecuencia' => $request->frecuencia,
        ]);

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento agregado exitosamente.');
    }
}


