<?php

namespace App\Http\Middleware;

use Closure;

class Datouware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session(['num'=>2345]);
        return $next($request);
    }
}
