<?php

namespace App\Http\Controllers;

use App\Models\SistemaOperativo;

class PanelController extends Controller
{
    public function index()
    {
        return view('panel');
    }
}
