<?php

namespace App\Http\Controllers;

use App\Models\Panelak;
use App\Models\TeknologiaBertsioa;
use Illuminate\Support\Facades\DB;
use App\Models\PanelTek;
use App\Models\Teknologiak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PanelTekController extends Controller
{

    public function obtenerInformacionPanelTek()
    {
        // Obtén el ID del usuario actual
        $userId = Auth::id();

        // Obtiene la información del panel Tek
        $panelTekInfo = PanelTek::with([
            'panel.sistemaOperativo',
            'teknologia',
            'bertsioa',
            'usuariosQueLoFavoritan' => function ($query) use ($userId) {
                // Filtra los usuarios que han marcado este panel como favorito
                $query->where('usuario_id', $userId);
            }
        ])->get();

        return $panelTekInfo;
    }


    public function showPaneladmin()
    {
        // Obtener la información de PanelTek
        $panelTekInfo = $this->obtenerInformacionPanelTek();

        // Verificar si se obtuvo la información correctamente
        if ($panelTekInfo->isNotEmpty()) {

            return response()->json(
                $panelTekInfo,
                200
            );
        } else {
            // Devolver un JSON con un mensaje de error y un status 500 (Internal Server Error)
            return response()->json([
                'message' => 'Error al obtener la información del panel'
            ], 500);
        }
    }


    public function anadir(Request $request)
    {

        $info = $request->input('teknologiaIzena');
        $Datubertsioa = $request->input('teknologiaBertsioa');
        $ize = $request->input('izenapanela');
        $kant = $request->input('cantidad');

        $infoParts = explode('-', $info);
        $izena = trim($infoParts[0]);
        $desk = trim($infoParts[1]);

        $teknologia = Teknologiak::where('izena', $izena)->where('desk', $desk)->first();

        $pane = Panelak::where('izena', $ize)->first();

        if ($pane) {
            $id = $pane->id;
        }

        if ($teknologia) {

            $bertsioa = TeknologiaBertsioa::where('izena', $Datubertsioa)->first();
            if ($bertsioa) {
                for ($i = 0; $i < $kant; $i++) {
                    $nuevoPanelTek = new PanelTek();
                    $nuevoPanelTek->panel_id = $id;
                    $nuevoPanelTek->tek_id = $teknologia->id;
                    $nuevoPanelTek->tek_bertsioa = $bertsioa->id;

                    $nuevoPanelTek->save();
                }
                return response()->json(['message' => 'Paneles Tek añadidos correctamente'], 200);
            } else {
                return response()->json(['message' => 'No se encontró la bertsioa correspondiente'], 404);
            }
        } else {
            // Devolver un mensaje de error si no se encontró la tecnología
            return response()->json(['message' => 'No se encontró la tecnología correspondiente'], 404);
        }
    }

}
