<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserOther;
use App\User;

class SessionController extends Controller
{
    public function login(Request $request)
    {
        $basedata = $request->basedata;
        config(['database.connections.mysql.database' => $basedata]);
        DB::reconnect('mysql');


        $user = UserOther::where([['usuario', '=', $request->user], ['contraseña', '=', $request->password], ['tipo', '=', 'PEDIDOS']])->first();

        //  $user = UserOther::where('usuario', $request->user)->where('contraseña', $request->password)->first();

        if ($user) {
            session(['user' => [
                'name' => $user->usuario,
                'idpersonal' => $user->idpersonal,
                'idlocal' => $user->idlocal,
                'cta_caja' => $user->cta_caja,
                'ven_emision_modifica' => $user->ven_emision_modifica,
                'basedata' => $basedata,
            ]]);
            return response()->json(['message' => "Inicio de sesión exitoso"], 200);
        } else {

            return response()->json(['message' => "Usuario no habillitado"], 404);
        }
    }
}
