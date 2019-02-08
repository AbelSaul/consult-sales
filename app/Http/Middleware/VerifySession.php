<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class VerifySession
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
        if ($user) {
            config(['database.connections.mysql.database' => $user['basedata']]);
            DB::reconnect('mysql');
            return $next($request);
        }
        return redirect('/login');
    }
}
