<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards): Response
    {
        if ($this->auth->guard($guards[0] ?? null)->guest()) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido o ausente',
            ], 401);
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        return null;
    }
}
