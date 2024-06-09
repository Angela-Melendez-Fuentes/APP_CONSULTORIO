<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            $usuarios = User::where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->get();
        } else {
            $usuarios = User::all();
        }
        
        return view('admin.administrar', compact('usuarios'));
    }
    

    // Método para mostrar el formulario de edición de usuario
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.editar', compact('usuario'));
    }

    // Método para actualizar un usuario en la base de datos
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'rol' => 'required|string|max:255',
        ]);

        // Buscar al usuario por su ID
        $usuario = User::findOrFail($id);

        // Actualizar los datos del usuario con los datos del formulario
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
        ]);

        // Redirigir a la lista de usuarios
        return redirect()->route('admin.administrar')->with('success', 'Usuario actualizado correctamente.');
    }

    // Método para eliminar un usuario de la base de datos
    public function destroy($id)
    {
        // Buscar al usuario por su ID
        $usuario = User::findOrFail($id);

        // Eliminar el usuario
        $usuario->delete();

        // Redirigir a la lista de usuarios
        return redirect()->route('admin.administrar')->with('success', 'Usuario eliminado correctamente.');
    }
}
