<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfilaController extends Controller
{
    public function GordeDatuak(Request $request)
    {
        // Obtener el usuario actual
        $usuario = User::findOrFail(auth()->user()->id);

        if ($request->hasFile('irudi')) {
            $originalName = $request->file('irudi')->getClientOriginalName();
            $extension = $request->file('irudi')->getClientOriginalExtension();
            $imageName = pathinfo($originalName, PATHINFO_FILENAME);

            // Verificar si ya existe un archivo con el sufijo _profila agregado al nombre original
            $existingImage = User::where('argazki', 'like', '%' . $imageName . '_profila.%')->first();

            if ($existingImage) {
                // Si existe, utilizar la ruta existente
                $imagePath = $existingImage->argazki;
            } else {
                // Mover y guardar la imagen en el sistema de archivos con el nuevo nombre
                $imageNameWithSuffix = $imageName . '_profila.' . $extension;
                $request->file('irudi')->move(public_path('img'), $imageNameWithSuffix);
                $imagePath = 'img/' . $imageNameWithSuffix;
                $usuario->argazki = $imagePath;
            }
        }

        // Verificar si se proporcionó un correo electrónico
        if ($request->filled('gmail')) {
            $usuario->mail = $request->input('gmail');
        }

        // Guardar los cambios en la base de datos
        $usuario->save();

        return response()->json(['message' => 'Datos actualizados correctamente']);
    }

}
