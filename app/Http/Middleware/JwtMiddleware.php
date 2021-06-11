<?php

namespace App\Http\Middleware;

use App\Services\Core\ResponseService;
use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
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
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $exception) {
            if ($exception instanceof TokenInvalidException){
                return ResponseService::unauthorized('Token is Invalid');
            }else if ($exception instanceof TokenExpiredException){
                return ResponseService::unauthorized('Token is Expired');
            }else{
                return ResponseService::unauthorized('Authorization Token not found');
            }
        }
        return $next($request);
    }
}
