<?php

namespace App\Http\Controllers;

use App\Models\UserKoloreak;
use App\Models\User;
use App\Models\PanelTek;

use Illuminate\Http\Request;

class KoloreakController extends Controller
{
    public function sartuKoloreak(Request $request)
    {
        $color = $request->input('color');
        $userName = $request->input('login_id');
        $tipo = $request->input('tipo');

        // Encuentra al usuario por su nombre de usuario
        $user = User::where('username', $userName)->first();

        // Verifica si el usuario existe
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Obtener el ID del usuario encontrado
        $loginId = $user->id;

        // Buscar si ya existe un registro para este usuario en la tabla User_koloreak
        $userKoloreak = UserKoloreak::where('login_id', $loginId)->first();

        if ($userKoloreak) {
            // Si ya existe, actualiza el color correspondiente
            if ($tipo === 'sidebar') {
                $userKoloreak->sidebar = $color;
            } elseif ($tipo === 'panel') {
                $userKoloreak->panel = $color;
            }
            $userKoloreak->save();
        }

        // Devolver una respuesta JSON
        return response()->json(['message' => 'Color actualizado correctamente']);
    }
    public function KargatuKoloreak(Request $request)
    {
        $userName = $request->input('login_id');

        // Encuentra al usuario por su nombre de usuario
        $user = User::where('username', $userName)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Obtener el ID del usuario encontrado
        $loginId = $user->id;

        // Buscar los datos de UserKoloreak para este usuario
        $userKoloreak = UserKoloreak::where('login_id', $loginId)->first();

        if (!$userKoloreak) {
            $userKoloreak = new UserKoloreak();
            $userKoloreak->login_id = $loginId;
            $userKoloreak->sidebar = '#3584e4';
            $userKoloreak->panel = "#f6f5f4";
        }
        $userKoloreak->save();
        // Devolver los datos de UserKoloreak como respuesta JSON
        return response()->json($userKoloreak);
    }
}