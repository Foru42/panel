<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CambioContrasenaController extends Controller
{
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
            return back()->withErrors(['password_actual' => 'La contraseña actual no es válida.']);
        }

        // Si la contraseña actual es válida, procede a cambiarla
        $usuario->password = Hash::make($request->password_nueva);
        $usuario->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente'], 200);
    }
}
