<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\UserOther;

class SellerController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;
        $fields = ['idpersonal', 'nombre'];
        if($search) {
            return Seller::where('nombre', 'like', "%$search%")->limit(10)
                ->select($fields)->get();
        }
        return Seller::limit(10)->select($fields)->get();
    }

    public function users(Request $request) {
        $search = $request->search;
        if($search) {
            return UserOther::where('usuario', 'like', "%$search%")
                ->select(['idpersonal as id', 'usuario as text', 'idlocal'])->get();
        }
        return UserOther::limit(10)->select(['idpersonal as id', 'usuario as text','idlocal'])->get();
    }

    public function findSeller(Request $request) {
        $user = session('user');
        return Seller::where('idpersonal', $user['idpersonal'])->first();
    }
}
