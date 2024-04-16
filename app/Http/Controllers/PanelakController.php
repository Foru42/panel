<?php

namespace App\Http\Controllers;

use App\Models\paneInser;
use App\Models\Tekinser;
use App\Models\TeknologiaBertsioa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanelakController extends Controller
{
    public function index()
    {
        return view('panelak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'izenapane' => 'required|string',
            'desk' => 'required|string',
            'So_id' => 'required|exists:sistema_operativo,id',
            'izenatek' => 'required|string',
            'desktek' => 'required|string',
            'vertek' => 'required|string',
            'irudi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
        ]);

        // Procesar y guardar la imagen
        $imageName = time() . '.' . $request->irudi->extension();
        $request->irudi->move(public_path('img'), $imageName);
        $imagePath = 'img/' . $imageName;

        // Crear un nuevo panel en paneInser
        $panel = paneInser::create([
            'izena' => $request->izenapane,
            'desk' => $request->desk,
            'irudi' => $imagePath, // Guardar la ruta de la imagen
            'so_id' => $request->So_id,
        ]);

        // Crear un nuevo registro en Tekinser y obtener su ID
        $tekinser = Tekinser::create([
            'izena' => $request->izenatek,
            'desk' => $request->desktek,
        ]);

        // Crear un nuevo registro en TeknologiaBertsioa y establecer su relación con Tekinser
        $teknologiaBertsioa = TeknologiaBertsioa::create([
            'izena' => $request->vertek,
            'teknologia_id' => $tekinser->id,
        ]);

        // Crear un nuevo registro en panel_tek y establecer su relación con el panel y la tecnología recién creados
        DB::table('panel_tek')->insert([
            'panel_id' => $panel->id,
            'tek_id' => $tekinser->id,
            'tek_bertsioa' => $teknologiaBertsioa->id,
            'updated_at' => now(),
            'created_at' => now()
        ]);

        // Redireccionar de vuelta con mensaje de éxito
        return redirect()->back()->with('success', 'Los datos se han guardado correctamente.');
    }
}
