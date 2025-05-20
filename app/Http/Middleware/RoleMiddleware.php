<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Comprueba que el usuario autenticado tenga el role dado.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $role  (p.ej. 'cliente' o 'empresa')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Si no está autenticado o su role no coincide, aborta con 403
        if (! $request->user() || $request->user()->role->nombre !== $role) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
