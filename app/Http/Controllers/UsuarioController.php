<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all(['id','username', 'password', 'administrador']); // Incluye el campo 'password'
        return response()->json($usuarios);
    }
    public function eliminar(Request $request)
    {
        // Obtener el ID del usuario a eliminar desde la solicitud
        $usuarioId = $request->input('id');
        print_r($usuarioId);
        // Buscar el usuario por su ID y eliminarlo
        $usuario = User::find($usuarioId);
        if ($usuario) {
            $usuario->delete();
            return response()->json(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No se pudo encontrar el usuario']);
        }
    }
}
