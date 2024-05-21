<?php
namespace App\Http\Controllers;

use App\Models\PanelTek;
use App\Models\Panelak;
use App\Models\Teknologiak;
use App\Models\TeknologiaBertsioa;
use Illuminate\Http\Request;

class PanelUpdateController extends Controller
{
    public function actualizarPanel(Request $request)
    {
        $panelId = $request->input('panelId');
        $nuevosValores = $request->input('nuevosValores');
        $sisOpe = $request->input('soId');
        $usuario = $request->input('userID');

        // Buscar o crear una nueva entrada en la tabla TeknologiaBertsioa
        $nuevaTeknologiaBertsioa = TeknologiaBertsioa::firstOrCreate(
            ['izena' => $nuevosValores['bertsioa']['izena']]
        );

        $nuevaTeknologia = Teknologiak::where('izena', $nuevosValores['teknologia']['izena'])->first();

        if ($nuevaTeknologia && ($nuevaTeknologia->desk == $nuevosValores['teknologia']['desk'])) {
            // Si la tecnología ya existe, actualiza el campo 'desk'
            $nuevaTeknologia->desk = $nuevosValores['teknologia']['desk'];
            $nuevaTeknologia->save();
        } else {
            // Si no existe, crea una nueva entrada en la tabla Tekinser
            $nuevaTeknologia = Teknologiak::create([
                'izena' => $nuevosValores['teknologia']['izena'],
                'desk' => $nuevosValores['teknologia']['desk']
            ]);
        }

        $panelIMG = Panelak::where('izena', $nuevosValores['panel']['izena'])
            ->first();

        if ($panelIMG) {
            $imagen = $panelIMG->irudi;
        }
        // Verificar si el panel ya existe en la tabla paneInser
        $panel = Panelak::where('izena', $nuevosValores['panel']['izena'])
            ->where('desk', $nuevosValores['panel']['desk'])
            ->first();

        if (!$panel) {
            // Si no existe, crear un nuevo registro en paneInser
            $panel = new Panelak();
            $panel->izena = $nuevosValores['panel']['izena'];
            $panel->desk = $nuevosValores['panel']['desk'];
            $panel->irudi = $imagen;
            $panel->so_id = $sisOpe;
            $panel->save();
        } else {
            // Si existe, actualizar el registro existente
            $panel->izena = $nuevosValores['panel']['izena'];
            $panel->desk = $nuevosValores['panel']['desk'];
            $panel->so_id = $sisOpe;
            $panel->save();
        }

        // Actualizar o crear el registro en la tabla PanelTek
        $panelTek = PanelTek::find($panelId);

        if ($panelTek) {
            // Asignar las nuevas IDs
            $panelTek->tek_bertsioa = $nuevaTeknologiaBertsioa->id;
            $panelTek->tek_id = $nuevaTeknologia->id;
            $panelTek->panel_id = $panel->id;
            $panelTek->name = $usuario;

            $panelTek->save();

            return response()->json(['message' => 'Panel actualizado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Panel no encontrado en la relación panel_tek'], 404);
        }
    }
}
