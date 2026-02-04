<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

class IsAuthenticated 
{
    public function handle($request, Closure $next): Response
    {
        if (auth()->check()) {
            return $next($request);
        }

        return redirect()->route('login')->withErrors([
            'auth' => 'Необходимо войти в авторизоваться.'
        ]);
    }
}