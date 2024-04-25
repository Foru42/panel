<?php
namespace App\Http\Controllers;

use App\Models\PanelTek;
use Illuminate\Support\Facades\DB;

class ModController extends Controller
{
    public function obtenerInformacionPanelTekActualizado()
    {
        $panelAcInfo = PanelTek::whereNotNull('updated_at')
            ->with('panel.sistemaOperativo', 'teknologia', 'bertsioa')
            ->get();

        return response()->json($panelAcInfo);
    }

}