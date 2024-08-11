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

    public function create()
    {
        return view('medicamentos.create');
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
        ]);

        // Creación del medicamento
        Medicamento::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
        ]);

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento agregado exitosamente.');
    }

    public function edit($id)
    {
        $medicamento = Medicamento::findOrFail($id);
        return view('medicamentos.edit', compact('medicamento'));
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
        ]);

        // Actualización del medicamento
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->nombre = $request->input('nombre');
        $medicamento->descripcion = $request->input('descripcion');
        $medicamento->precio = $request->input('precio');
        $medicamento->cantidad = $request->input('cantidad');
        $medicamento->save();

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento actualizado exitosamente.');
    }

        public function destroy($id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->delete();

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento eliminado exitosamente.');
    }
}
