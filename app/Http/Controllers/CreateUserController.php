<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class CreateUserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);
    
        // Verificar si ya existe un usuario con el mismo nombre de usuario
        $existingUser = User::where('username', $validatedData['username'])->first();
        if ($existingUser) {
            return redirect()->back()->with('error', '¡El nombre de usuario ya está en uso!');
        }
    
        // Crear un nuevo usuario en la base de datos
        $user = new User();
        $user->username = $validatedData['username'];
        $user->password = bcrypt($validatedData['password']);
        $user->administrador = '0';
        $user->save();
    
        // Redirigir a una página de éxito o mostrar un mensaje de éxito
        return redirect('/')->with('success', '¡Registro exitoso!');
    }
    
    
}
