<?php

namespace App\Http\Middleware;

use Closure;

class AccessEditProforma
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
    if ($user["ven_emision_modifica"] == 1) {
      return $next($request);
    }
    return redirect('/');
  }
}
