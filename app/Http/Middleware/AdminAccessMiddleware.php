<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isAn('admin')) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
} 