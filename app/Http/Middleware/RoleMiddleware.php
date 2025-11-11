<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole($role)) {
            abort(403, 'Acceso denegado: no tienes el rol requerido.');
        }

        return $next($request);
    }
}
