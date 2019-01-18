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
        if ($request->database || $request->header('database')) {
            $database = $request->database ? $request->database : $request->header('database');
            config(['database.connections.mysql.database' => $database]);
            DB::reconnect('mysql');
        }
        return $next($request);
    }
}
