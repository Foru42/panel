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
                return redirect()->route('panel')->with('success', '¡Bienvenido!');
            } else {
                $request->session()->put('username', $request->input('username'));
                return redirect()->route('panelNoadmin')->with('success', '¡Bienvenido!');
            }
        } else {
            return redirect()->route('login')->with('error', 'Credenciales incorrectas')->withInput();
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        // Eliminar la sesión
        $request->session()->forget('username');

        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente');
    }
}
