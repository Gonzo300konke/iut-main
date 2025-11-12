<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirigirPorRol
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = \Illuminate\Support\Facades\Auth::user();

        if (! $usuario) {
            return redirect('/login');
        }

        $routeName = $request->route()?->getName() ?? '';

        // Administrador: acceso total
        if ($usuario->isAdmin()) {
            return $next($request);
        }

        // Usuario normal: restringir solo rutas de gestión de usuarios
        if (str_starts_with($routeName, 'usuarios.')) {
            return redirect()->route('bienes.index')->with('error', 'No tienes permisos para acceder a Usuarios');
        }

        return $next($request);
    }
}
