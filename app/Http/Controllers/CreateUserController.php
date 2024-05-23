<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateUserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required',
            'gmail' => 'required',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Verificar si el nombre de usuario ya existe
        $existingUser = User::where('username', $request->username)->first();
        if ($existingUser) {
            return response()->json(['error' => 'El nombre de usuario ya está registrado'], 422);
        }

        // Crear un nuevo usuario en la base de datos
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->Gmail = $request->gmail;
        $user->save();

        // Retornar una respuesta JSON para indicar que el registro fue exitoso
        return response()->json(['success' => true], 200);
    }

}
