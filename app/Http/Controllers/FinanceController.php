<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Receivable;
use DB;



class FinanceController extends Controller
{
    public function receivable(Request $request) {

        return view('cuentas-por-cobrar.index');
    
    }

      public function getReceivables(Request $request) {

        $search = $request->search;       
        $user = session('user');

        if($search) {
            $receivables = Receivable::where('cuentas_cobrar.idlocal','=',$user["idlocal"])
                ->where("cuentas_cobrar.estado" , "=","P")
                ->whereHas("client", function($q) use ($search){
                    $q->where('clientes.ruc', 'like', "%$search%")
                      ->orWhere('clientes.dni', 'like', "%$search%")
                      ->orWhere('clientes.cliente', 'like', "%$search%");
                })
            
                ->with(['client', 'seller'])
                ->orderByRaw('cuentas_cobrar.fecha  DESC')
                ->paginate(10);

            return response()->json($receivables);

        }
        
        $receivables = Receivable::where('idlocal','=',$user["idlocal"])
                                   ->where("estado" ,"=","P")
                                   ->with(['client', 'seller'])
                                    ->orderByRaw('fecha  DESC')
                                   ->paginate(10);

        return response()->json($receivables);
    }

 

 




}
