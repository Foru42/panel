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

            return response()->json(['success' => true]); // Inicio de sesión exitoso
        } else {
            return response()->json(['error' => 'Credenciales incorrectas'], 401); // Credenciales incorrectas
        }
    }

    public function checkAdminStatus(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        return response()->json(['isAdmin' => $isAdmin]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Eliminar la sesión
        $request->session()->forget('username');
        return response()->json(['message' => 'Has cerrado sesión correctamente'], 200);

    }

}
