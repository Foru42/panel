<?php

namespace App\Http\Controllers;

use App\Models\PanelTek;
use App\Models\User;
use App\Models\UsuarioPanelFavorito;
use Illuminate\Http\Request;

class PanelFavStarContoller extends Controller
{
    // En tu controlador
    public function anadirFavorito(Request $request)
    {
        // Valida los datos recibidos en la solicitud

        // Obtiene la ID del panel y el estado de la estrella desde la solicitud
        $panelId = $request->input('id');
        $userName = $request->input('userID');

        // Encuentra al usuario por su nombre de usuario
        $user = User::where('username', $userName)->first();

        // Verifica si el usuario existe
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Verifica si el panel ya está marcado como favorito por el usuario
        $panelFav = UsuarioPanelFavorito::where('usuario_id', $user->id)
            ->where('panel_id', $panelId)
            ->first();

        // Si el panel ya está marcado como favorito, no hace nada
        if ($panelFav) {
            $panelFav->delete();
            return response()->json(['message' => 'Panel eliminado de los favoritos del usuario'], 200);
        }

        // Crea una nueva entrada en la tabla de relación para marcar el panel como favorito del usuario
        $nuevoPanelFav = new UsuarioPanelFavorito();
        $nuevoPanelFav->usuario_id = $user->id;
        $nuevoPanelFav->panel_id = $panelId;
        $nuevoPanelFav->save();

        return response()->json([
            'message' => 'Panel marcado como favorito correctamente'
        ], 200);
    }

}