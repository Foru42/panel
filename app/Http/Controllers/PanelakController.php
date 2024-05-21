<?php

namespace App\Http\Controllers;

use App\Models\Panelak;
use App\Models\Teknologiak;
use App\Models\TeknologiaBertsioa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\PanelTek;

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
            'irudi' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Obtener el nombre del archivo original enviado desde el cliente
        $imageName = $request->file('irudi')->getClientOriginalName();

        // Verificar si ya existe un archivo con el mismo nombre
        $existingImage = Panelak::where('irudi', 'like', '%' . $imageName . '%')->first();

        if ($existingImage) {
            // Si existe, utilizar la ruta existente
            $imagePath = $existingImage->irudi;
        } else {
            // Si no existe, generar un nombre único para el archivo

            // Mover y guardar la imagen en el sistema de archivos con el nombre único
            $request->file('irudi')->move(public_path('img'), $imageName);
            $imagePath = 'img/' . $imageName;
        }

        // Crear un nuevo panel en paneInser
        $panel = Panelak::create([
            'izena' => $request->izenapane,
            'desk' => $request->desk,
            'irudi' => $imagePath, // Guardar la ruta de la imagen
            'so_id' => $request->So_id,
        ]);

        // Crear un nuevo registro en Tekinser y obtener su ID
        $tekinser = Teknologiak::create([
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
            'name' => $request->usuario,
            'updated_at' => now(),
            'created_at' => now()
        ]);

        // Redireccionar a la vista del formulario con un mensaje de éxito
        return response()->json(['message' => 'Los datos se han guardado correctamente'], 200);
    }

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
