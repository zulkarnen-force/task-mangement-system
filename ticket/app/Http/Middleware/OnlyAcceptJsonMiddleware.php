<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class OnlyAcceptJsonMiddleware
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
        $contentType = $request->header('Content-Type');
        
        if (is_null($contentType) || $contentType !== 'application/json') {
            return Redirect::to('login');
        } else {
            return $next($request);
        }
        
        
    }
}
