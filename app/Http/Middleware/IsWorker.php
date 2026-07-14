<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsWorker
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !in_array($request->user()->role, ['admin', 'trabajador'])) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}
