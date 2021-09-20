<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\MainClass;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class RolUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      if (auth()->check()) {
        $permission = new MainClass();
        $permission = $permission->getUrl();

        if($permission == false){
          return redirect()->back()->withErrors('You do not have the required permission');
        }
        return $next($request);
      }
    }
}
