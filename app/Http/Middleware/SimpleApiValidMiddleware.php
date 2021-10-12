<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class SimpleApiValidMiddleware
{
    
    use ResponseTrait;


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user_id) {
            return $this->response(false,Response::HTTP_UNAUTHORIZED, "Unauthorized", null);
        }
        return $next($request);
    }
}
