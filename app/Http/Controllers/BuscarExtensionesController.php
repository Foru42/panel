<?php

namespace App\Http\Controllers;

use App\Models\PanelTek;
use App\Models\Tekinser;
use Illuminate\Http\Request;
use App\Models\Tecnologia;

class BuscarExtensionesController extends Controller
{
    public function searchExtensions(Request $request)
    {

        $searchTerm = $request->input('searchTerm');

        // Realizar la búsqueda en la base de datos
        $results = Tekinser::where('izena', 'LIKE', '%' . $searchTerm . '%')->with('paneles')->get();

        // Retornar los resultados como JSON
        return response()->json($results);
    }
}
