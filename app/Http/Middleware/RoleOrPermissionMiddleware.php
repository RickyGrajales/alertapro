<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleOrPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $roleOrPermission): Response
    {
        if (! $request->user() || 
            (! $request->user()->hasRole($roleOrPermission) && 
             ! $request->user()->can($roleOrPermission))) {
            abort(403, 'Acceso denegado.');
        }

        return $next($request);
    }
}
