<?php

namespace App\Http\Middleware;

use Closure;

class AccessReceivables
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
     $user = session('user');        
     if($user["cta_caja"] == 1){
        return $next($request);
      }
        return redirect('/');
    }
}
