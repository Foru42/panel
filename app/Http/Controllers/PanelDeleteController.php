<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PanelTek;

class PanelDeleteController extends Controller
{
    public function eliminar(Request $request)
    {
        $panelTekId = $request->input('panelTekId');
        // Buscar el registro de PanelTek por su ID
        $panelTek = PanelTek::find($panelTekId);



        if ($panelTek) {
            // Si se encuentra el registro, eliminarlo
            $panelTek->delete();
            return response()->json(['success' => true, 'message' => 'Registro de PanelTek eliminado correctamente']);
        } else {
            // Si no se encuentra el registro, devolver un mensaje de error
            return response()->json(['success' => false, 'message' => 'El registro de PanelTek no existe']);
        }
    }
}
