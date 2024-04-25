<?php

namespace App\Http\Controllers;

use App\Models\PanelTek;
use Illuminate\Http\Request;

class PanelFavStarContoller extends Controller
{
    // En tu controlador
    public function anadirFavorito(Request $request)
    {
        // Valida los datos recibidos en la solicitud

        // Obtiene la ID del panel y el estado de la estrella desde la solicitud
        $panelId = $request->input('id');
        $starred = $request->input('fav');

        // Deshabilita temporalmente las características de actualización de timestamps para el modelo PanelTek
        PanelTek::disableTimestamps();

        try {
            // Encuentra el panel por su ID
            $panelTek = PanelTek::findOrFail($panelId);

            // Actualiza el estado de la estrella del panel
            if ($starred) {
                $panelTek->fav = 'true';
            } else {
                $panelTek->fav = 'false';
            }

            // Guarda los cambios en la base de datos
            $panelTek->save();
            PanelTek::enableTimestamps();
            // Retorna una respuesta indicando que el estado de la estrella ha sido actualizado con éxito
            return response()->json(['message' => 'Estado de la estrella actualizado con éxito']);
        } finally {
            // Vuelve a habilitar las características de actualización de timestamps después de la operación
            PanelTek::enableTimestamps();
        }
    }
    public function showFav(Request $request)
    {



        $panelAcInfo = PanelTek::where('fav', 'true')
            ->with('panel.sistemaOperativo', 'teknologia', 'bertsioa')
            ->get();

        return response()->json($panelAcInfo);

    }

}