<?php

namespace App\Http\Controllers;

use App\Models\PanelTek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->get(['id', 'username', 'mail', 'argazki']);
        return response()->json($usuarios);
    }

    public function crear(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['success' => true], 200);
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
        $panelId = $request->input('panelId');
        $roles = $request->input('roles');

        // Buscar el usuario por su ID
        $usuario = User::findOrFail($panelId);

        $nameOld = $usuario->username;

        // Buscar todos los registros de PanelTek asociados al usuario
        $paneTek = PanelTek::where('name', $nameOld)->get();

        // Iterar sobre cada registro y actualizar el nombre
        foreach ($paneTek as $panel) {
            $panel->name = $username;
            $panel->save();
        }

        // Actualizar los datos del usuario
        $usuario->username = $username;
        $usuario->save();

        if ($roles) {
            // Si hay roles, asignar el rol "admin" al usuario
            $usuario->assignRole('admin');
        } else {
            // Si no hay roles asignados, eliminar cualquier asignación previa del rol "admin"
            $usuario->removeRole('admin');
        }

        // Devolver un mensaje al frontend
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

    public function asignarRol(Request $request)
    {
        // Obtener el usuario Kepa
        $user = User::where('username', 'kepa')->first();
        $user->assignRole('admin');
        $user = User::where('username', 'antxon')->first();
        $user->assignRole('admin');

        // Devolver una respuesta
        return 'Rol asignado correctamente a Kepa';
    }
}
