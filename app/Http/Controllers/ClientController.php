<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;
        if($search) {
            return Client::where('cliente', 'like', "%$search%")
            ->select(['idcliente as id', 'cliente as text'])->get();
        }
        return Client::limit(10)->select(['idcliente as id', 'cliente as text'])->get();
    }
}
