<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
                $usuario->argazki = $imagePath;
                //var_dump($imagePath, 'g');
            } else {
                // Mover y guardar la imagen en el sistema de archivos con el nuevo nombre
                $imageNameWithSuffix = $imageName . '_profila.' . $extension;
                $request->file('irudi')->move(public_path('img'), $imageNameWithSuffix);
                $imagePath = 'img/' . $imageNameWithSuffix;
                //var_dump($imagePath, 'h');

                $usuario->argazki = $imagePath;
            }
        }

        // Verificar si se proporcionó un correo electrónico
        if ($request->filled('Ntek')) {
            $usuario->Ntek = $request->input('Ntek');
        }

        // Guardar los cambios en la base de datos
        $usuario->save();

        return response()->json(['message' => 'Datos actualizados correctamente']);
    }

}
