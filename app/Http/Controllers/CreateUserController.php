<?php
namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = '6LdKa-spAAAAAOAKDlCGAKcdHT3V_Q2aMxwoP06F';

        if (!$secretKey) {
            return response()->json(['error' => 'Clave secreta de reCAPTCHA no encontrada en el archivo .env'], 500);

        }

        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $responseKeys = json_decode($response, true);

        if (!isset($responseKeys["success"])) {
            return response()->json(['error' => 'No se pudo verificar la respuesta del reCAPTCHA', 'response' => $responseKeys], 500);
        }

        if (intval($responseKeys["success"]) !== 1) {
            return response()->json(['error' => 'La verificación reCAPTCHA falló', 'details' => $responseKeys], 422);
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->gmail = $request->gmail;
        $user->save();

        Mail::to($user->gmail)->send(new WelcomeMail($user));

        return response()->json(['success' => true], 200);
    }
}
