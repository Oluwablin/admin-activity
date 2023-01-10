<?php

namespace App\Http\Middleware\API\Auth;

use Closure;
use Illuminate\Http\Request;

class UserCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        abort_unless(auth('user')->user(), 401, 'Unauthorized request');
        return $next($request);
    }
}
