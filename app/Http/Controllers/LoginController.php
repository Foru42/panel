<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    protected $model = \App\Models\User::class;
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->administrador == 1) {
                $request->session()->put('username', $request->input('username'));
                return response()->json(['success' => true]); // Inicio de sesión exitoso para administrador
            } else {
                $request->session()->put('username', $request->input('username'));
                return response()->json(['success' => true]); // Inicio de sesión exitoso para usuario no administrador
            }
        } else {
            return response()->json(['error' => 'Credenciales incorrectas'], 401); // Credenciales incorrectas
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();

        // Eliminar la sesión
        $request->session()->forget('username');
        return response()->json(['message' => 'Has cerrado sesión correctamente'], 200);

    }

}
