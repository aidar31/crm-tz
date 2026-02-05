<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

class CheckManagerRole
{
    public function handle($request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasRole('manager')) {
            return $next($request);
        }

        abort(403, 'У вас нет прав доступа');
    }
}