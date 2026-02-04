<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated 
{
    public function handle($request, Closure $next): Response
    {
        if (auth()->check()) {
            return redirect()->route('welcome');    
        }
        return $next($request);
    }
}