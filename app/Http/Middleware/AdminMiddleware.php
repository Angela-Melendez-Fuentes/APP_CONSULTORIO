<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado y es administrador
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Redireccionar a la página de inicio o login si no es administrador
        return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
    }
}
