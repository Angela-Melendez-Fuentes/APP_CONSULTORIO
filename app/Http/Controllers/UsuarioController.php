<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $usuarios = User::where('tipo', '!=', 'admin')->get();
        }
        
        return view('admin.administrar', compact('usuarios'));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.editar', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'tipo' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'rfc' => 'required|string|max:13',
            'cedula_profesional' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:100',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'tipo' => $request->tipo,
            'telefono' => $request->telefono,
            'rfc' => $request->rfc,
            'cedula_profesional' => $request->cedula_profesional,
            'especialidad' => $request->especialidad,
        ]);

        return redirect()->route('admin.administrar')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.administrar')->with('success', 'Usuario eliminado correctamente.');
    }
}
