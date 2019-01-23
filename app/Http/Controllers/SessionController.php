<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserOther;
use App\User;

class SessionController extends Controller
{
    public function login(Request $request) {
        $database = $request->database;
        config(['database.connections.mysql.database' => $database]);
        DB::reconnect('mysql');
        $user = UserOther::where('usuario', $request->user)->where('contraseña', $request->password)->first(['usuario']);
        
        if($user) {
          session(['user' => [
            'name' => $user->usario,
            'database' => $database,
          ]]);
          return response()->json(['message' => "Inicio de sesion exitoso"], 200);
        } else {
          return response()->json(['message' => "Usuario no encontrado"], 404);
        }
    }
}
