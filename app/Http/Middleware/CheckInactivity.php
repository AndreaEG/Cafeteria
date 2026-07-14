<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInactivity
{
    public function handle(Request $request, Closure $next)
    {
        $maxInactivity = 1800; // 30 minutos en segundos

        if (Auth::check()) {
            $lastActivity = session('last_activity_time');

            if ($lastActivity && (time() - $lastActivity) > $maxInactivity) {
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')->with('error', 'Sesión expirada por inactividad.');
            }

            session(['last_activity_time' => time()]);
        }

        return $next($request);
    }
}
