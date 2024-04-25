<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Crear un nuevo usuario en la base de datos
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->administrador = '0';
        $user->save();

        // Retornar una respuesta JSON para indicar que el registro fue exitoso
        return response()->json(['success' => true], 200);
    }


}
