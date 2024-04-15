<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->administrador) {
            return $next($request);
        }

        return redirect()->route('panel')->with('error', 'No tienes permisos para acceder a esta página');
    }
}
