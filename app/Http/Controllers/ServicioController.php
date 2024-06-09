<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ServicioController extends Controller
{
    // Método para mostrar todos los servicios
    public function index()
    {
        $servicios = Servicio::all();
        return view('doctor.servicios', compact('servicios'));
    }

    // Método para mostrar el formulario de creación de servicio
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric', 
        ]);
    
        // Crear un nuevo servicio en la base de datos
        Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio, 
        ]);
    
        // Redirigir a la lista de servicios 
        return redirect()->route('servicios.index')->with('success', 'Servicio creado correctamente.');
    }

    // Método para mostrar el formulario de edición de servicio
    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    // Método para actualizar un servicio en la base de datos
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        // Buscar el servicio por su ID
        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        // Redirigir a la lista de servicios
        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    // Método para eliminar un servicio de la base de datos
    public function destroy($id)
    {
        // Buscar el servicio por su ID
        $servicio = Servicio::findOrFail($id);

        // Eliminar el servicio
        $servicio->delete();

        // Redirigir a la lista de servicios 
        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}
