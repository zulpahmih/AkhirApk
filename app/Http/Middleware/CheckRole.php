<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (auth()->user()->roles_id === $roles  ) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->roles_id === 6) {
            abort(403, 'Unauthorized action.');
        }

        
        return $next($request);
    }
}
