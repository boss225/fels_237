<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == config('settings.role_admin')) {
            return $next($request);
        }

        return redirect('/');
    }
}
