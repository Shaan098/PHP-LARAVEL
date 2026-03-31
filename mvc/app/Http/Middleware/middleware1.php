<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class middleware1
{
    /*
     * Handle an incoming request
     *
     * @param  Closure(Request): (Response)  $nex
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
