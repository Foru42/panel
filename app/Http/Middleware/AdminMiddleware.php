<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->administrador) {
            return redirect()->route('panelNoadmin')->with('error', 'No tienes permisos para acceder a esta página');
        }

        return $next($request);
    }
}
