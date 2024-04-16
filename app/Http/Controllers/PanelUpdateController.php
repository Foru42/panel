<?php
namespace App\Http\Controllers;

use App\Models\PanelTek;
use App\Models\paneInser; // Importa el modelo de panelak
use Illuminate\Http\Request;

class PanelUpdateController extends Controller
{
    public function actualizarPanel(Request $request)
    {
        $panelId = $request->input('panelId');
        $nuevosValores = $request->input('nuevosValores');

        // Buscar el registro en la tabla panel_tek utilizando el ID proporcionado
        $panelTek = PanelTek::find($panelId);

        if ($panelTek) {
            // Obtener el panel asociado utilizando el panel_id del registro de panel_tek
            $panel = paneInser::find($panelTek->panel_id);
            $panelTek->tek_id = $nuevosValores['teknologia_desk'];
            $panelTek->tek_bertsioa = $nuevosValores['bertsioa_izena'];

            $panelTek->save();
            if ($panel) {
                // Actualizar el campo desk en el registro de panelak
                $panel->desk = $nuevosValores['panel_deskripzioa'];
                $panel->so_id = $nuevosValores['so_desk'];
                $panel->save();

                return response()->json(['message' => 'Panel actualizado correctamente'], 200);
            } else {
                return response()->json(['message' => 'Panel no encontrado en la tabla panelak'], 404);
            }
        } else {
            return response()->json(['message' => 'Panel no encontrado en la relación panel_tek'], 404);
        }
    }
}