<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicamento;

class MedicamentoController extends Controller
{
    public function index()
    {
        $Medicamento = Medicamento::all();
        return view('medicamentos.index', compact('Medicamento'));
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
            'precio' => 'required|string|max:255',
        ]);

        Medicamento::create([
            'Medicamento' => $request->medicamento,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
        ]);

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento agregado exitosamente.');
    }
}


