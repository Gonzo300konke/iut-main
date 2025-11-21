<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Verifica que el usuario autenticado sea administrador.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            return response()->json([
                'message' => 'No tienes permisos para realizar esta acción. Solo administradores pueden acceder.',
                'error' => 'Unauthorized',
            ], 403);
        }

        return $next($request);
    }
}
