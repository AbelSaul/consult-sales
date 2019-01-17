<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ChangeDatabase
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
        if ($request->database) {
            config(['database.connections.mysql.database' => $request->database]);
            DB::reconnect('mysql');
        }
        return $next($request);
    }
}
