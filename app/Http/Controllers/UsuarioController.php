<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all(['id', 'username', 'password', 'administrador', 'mail', 'argazki']);
        return response()->json($usuarios);
    }
    public function eliminar(Request $request)
    {
        // Obtener el ID del usuario a eliminar desde la solicitud
        $usuarioId = $request->input('id');
        // Buscar el usuario por su ID y eliminarlo
        $usuario = User::find($usuarioId);
        if ($usuario) {
            $usuario->delete();
            return response()->json(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No se pudo encontrar el usuario']);
        }
    }
    public function cambiar(Request $request)
    {
        // Obtener los datos del formulario
        $username = $request->input('username');
        $administrador = $request->input('administrador');
        $panelId = $request->input('panelId');

        // Buscar el usuario por su ID
        $usuario = User::findOrFail($panelId);

        // Actualizar los datos del usuario
        $usuario->username = $username;
        $usuario->administrador = $administrador;
        $usuario->save();

        // Si necesitas devolver algún mensaje o datos al frontend, puedes hacerlo aquí
        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }
    public function cambiarContraseña(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password_nueva' => 'required|string|confirmed',
        ]);

        $usuario = Auth::user();

        // Hashear la contraseña actual proporcionada en el formulario
        $password_actual_input = $request->password_actual;

        if (!Hash::check($password_actual_input, $usuario->password)) {
            return response()->json(['error' => 'La contraseña actual no es válida.'], 403);
        }

        // Si la contraseña actual es válida, procede a cambiarla
        $usuario->password = Hash::make($request->password_nueva);
        $usuario->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente'], 200);
    }
    public function mostrarPorNombre(Request $request)
    {
        $nombre = $request->input('userId');
        $usuarios = User::where('username', $nombre)->get();
        return response()->json($usuarios);
    }
}
