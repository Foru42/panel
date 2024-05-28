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
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required',
            'gmail' => 'required|email',
            'g-recaptcha-response' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Verifica la respuesta del reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY'); // Asegúrate de tener esta clave en tu archivo .env
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            return response()->json(['error' => 'La verificación reCAPTCHA falló'], 422);
        }

        // Crea el nuevo usuario
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->Gmail = $request->gmail;
        $user->save();

        return response()->json(['success' => true], 200);
    }

}
