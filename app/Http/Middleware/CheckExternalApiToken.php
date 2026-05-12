<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Valida que las peticiones al API externo incluyan el token correcto.
 *
 * El proyecto consumidor (Bolsa de Trabajo) debe enviar el token en
 * cualquiera de estas dos formas:
 *
 *   Authorization: Bearer <token>
 *   X-Api-Token: <token>
 *
 * El token se configura en .env como EXTERNAL_API_TOKEN.
 */
class CheckExternalApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = env('EXTERNAL_API_TOKEN');

        // Acepta Bearer token en Authorization header
        $token = null;

        $authHeader = $request->header('Authorization');
        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            $token = substr($authHeader, 7);
        }

        // Alternativamente, acepta X-Api-Token header
        if (!$token) {
            $token = $request->header('X-Api-Token');
        }

        if (!$token || !$expectedToken || !hash_equals($expectedToken, $token)) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado. Incluye un token válido en el header Authorization: Bearer <token>.',
            ], 401);
        }

        return $next($request);
    }
}
