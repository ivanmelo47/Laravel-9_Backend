<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseHelper; // Importar la clase Helper

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Verifica si el usuario está autenticado y tiene el rol requerido
        if (!$user || $user->role !== $role) {
            return ResponseHelper::jsonResponse(
                false,
                false,
                403,
                'Tu nivel de usuario no esta autorizado para realizar esta accion.',
                ['Tu nivel de usuario no esta autorizado para realizar esta accion.']
            );
        }

        return $next($request);
    }
}
