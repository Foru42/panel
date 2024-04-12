<?php   
namespace App\Http\Controllers;

use App\Models\PanelTek;
use Illuminate\Support\Facades\DB;
class ModController extends Controller
{
    public function ultimasModificacionesPanelTek()
    {
        // Obtener las últimas modificaciones de PanelTek que no sean null en updated_at

    
        // Obtener toda la información de PanelTek agrupada por panel_izena
        $panel_tek_info = DB::table('panel_tek')
            ->join('panelak', 'panel_tek.panel_id', '=', 'panelak.id')
            ->join('teknologiak', 'panel_tek.tek_id', '=', 'teknologiak.id')
            ->join('teknologia_bertsioa', 'panel_tek.tek_bertsioa', '=', 'teknologia_bertsioa.id')
            ->join('sistema_operativo', 'panelak.so_id', '=', 'sistema_operativo.id')
            ->whereNotNull('panel_tek.updated_at') // Filtrar por updated_at no null
            ->select('panelak.izena as panel_izena',
                    'panel_tek.id as pt_id',
                     'panelak.desk as panel_deskripzioa',
                     'panelak.irudi as panel_irudia',
                     'teknologiak.izena as teknologia_izena',
                     'teknologiak.desk as teknologia_desk',
                     'teknologia_bertsioa.izena as bertsioa_izena',
                     'sistema_operativo.izena as so_izena',
                     'sistema_operativo.desk as so_desk')
            ->get();
    
        // Agrupar la información por panel_izena
        $grouped_info = $panel_tek_info->groupBy('panel_izena');
    
        // Retornar los datos en formato JSON
        return response()->json($grouped_info);
    }
    
}