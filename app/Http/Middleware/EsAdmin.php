<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAdmin
{
    // solo deja pasar si el usuario está logueado y es admin
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->es_admin) {
            abort(403);
        }
        return $next($request);
    }
}
