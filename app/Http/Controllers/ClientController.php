<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use DB;



class ClientController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;
        $fields = ['idcliente as id', DB::raw('CONCAT(cliente," - ",ruc) as text') , 'direccion', 'celular', 'correo'];
        if($search) {
            return Client::where('cliente', 'like', "%$search%")
                ->limit(10)
                ->orWhere('ruc', 'like', "%$search%")
                ->select($fields)->get();
        }
        return Client::limit(10)->select($fields)->get();
    }
}
