<?php

namespace App\Http\Middleware;

use Closure;

class ApiKeyValidate
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
       $type = $request->header('content-type');
       $token = $request->header('token');
       $tok = "sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt";
       if($type == "application/json" && $token==$tok)
        return $next($request);
        return  redirect('/api/denied');
    }
}
