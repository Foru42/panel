<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PanelTekController extends Controller
{
    public function obtenerInformacionPanelTek()
    {
        // Obtener información de panel_tek agrupada por panel_izena
        $panel_tek_info = DB::table('panel_tek')
            ->join('panelak', 'panel_tek.panel_id', '=', 'panelak.id')
            ->join('teknologiak', 'panel_tek.tek_id', '=', 'teknologiak.id')
            ->join('teknologia_bertsioa', 'panel_tek.tek_bertsioa', '=', 'teknologia_bertsioa.id')
            ->join('sistema_operativo', 'panelak.so_id', '=', 'sistema_operativo.id')
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
    // Obtener datos de tecnología para el campo de selección
    $teknologias = DB::table('teknologiak')->get();

    // Obtener versiones disponibles para bertsioa_izena
    $bertsioa_izenak = DB::table('teknologia_bertsioa')->get();

    $so_desk = DB::table('sistema_operativo')->get();

    // Agrupar la información por panel_izena
    $grouped_info = $panel_tek_info->groupBy('panel_izena');

    // Retornar la vista con la información agrupada, los datos de tecnología y las versiones de bertsioa_izena
    return view('panel', ['grouped_info' => $grouped_info, 'teknologias' => $teknologias, 'bertsioa_izenak' => $bertsioa_izenak , 'so_desk' => $so_desk]);
} 
}