<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Receivable;
use App\MovementReceivable;
use App\Box;
use DB;
use Exception;



class FinanceController extends Controller
{

    public function __construct()
    {
        // $this->user = session('user'); 
    }

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

    public function getDetailsCharges(Request $request){
       
        $user = session('user');        
        $idcobro = $request->idcobro;  
        
        $detailsCharges = MovementReceivable::where('idlocal','=',$user["idlocal"])
                                      ->where("idcobro","=",$idcobro)
                                      ->with(['seller'])
                                      ->orderByRaw('fecha_cob  DESC')
                                      ->get();
                                      
         return response()->json($detailsCharges);
    }

    public function getTypesBox(){

        $types = array(
                    "ING_EFE" => "Efectivo",
                    "ING_DEP" => "Transferencia",
                );
        return $types;
    }

    public function getConceptsBox(){

        $concepts = array(
                        "COBRANZA DE CLIENTE" => "BV",
                        "COBRANZA DE FACTURA" => "FAC",
                        "COBRANZA DE CUENTA" => "CR",
                    );
        return $concepts;
    }

    public function saveCharges(Request $request){

        $user = session('user');        

        /***************************** Validate field ***********************/
       $this->validate($request, [
            'idcobro' => 'required',
            'monto'   => 'required',
            'fecha_pago' => 'required',
            'hora_pago' => 'required',
            'forma_pago' => 'required',
            'cobrador' => 'required',
        ]);

        /***************************** Get receivable ***********************/
        //Get receivable
        $receivable = Receivable::where('idcobro',$request->idcobro)->first();
       
        if ($receivable == null){            
            throw new Exception("No se encontró la cuenta por cobrar");
        }

        /***************************** Validate monto to payment receivable ***********************/

        $monto = $request->monto;

        $thereIsDebt = $receivable->saldo  > 0;

        if(empty($thereIsDebt)){
             throw new Exception("El saldo deudor es 0.00");
        }
        
        $isMontoValid = $monto > 0;

        if(empty($isMontoValid)){
             throw new Exception("Ingrese un monto validó mayor a 0.00");
        }

        $isLessThanDebt =  $receivable->saldo >= $monto ;
        if(empty($isLessThanDebt)){
             throw new Exception("Ingrese un monto menor o igual a la deuda");
        }


        /*****************************Create box***********************/
        $maxIdBox = DB::select("(select max(`idcaja` * 1) as id  from caja)")[0]->id + 1;

        $conceptsBox  = $this->getConceptsBox();

        $fecha_pago =   $request->fecha_pago;

        $idcaja = Box::create([
            "idcaja" => $maxIdBox,
            "idventa" => $receivable->idventa,
            "idlocal" => $user["idlocal"],
            "tipo" => $request->forma_pago == "Efectivo" ? "ING_EFE" : "ING_DEP" ,
            "idcajero" => $request->cobrador,
            "documento" => $receivable->tipodoc.":".$receivable->documento,
            "fecha" => $request->fecha_pago,
            "hora" => $request->hora_pago,
            "forma_pago" => $request->forma_pago,
            "ref_pago" => $request->referencia_pago,
            "concepto" => array_search($receivable->tipodoc,$conceptsBox) ,
            "entrada" => $request->monto,
            "salida" => 0.00,
            "moneda" => $receivable->moneda,
            "turno" => 0,
            "num_caja" => 0,
            "usuario" => $user['name'],
            "orig_dest" => $request->cliente,
        ])->idcaja;

        /********************Create movement receivable*****************/

        $maxIdMovementReceivable = DB::select("(select max(`idcobromov` * 1) as id  from cuentas_cobrar_mov)")[0]->id + 1;

        MovementReceivable::create([
            "idcobromov" => $maxIdMovementReceivable,
            "idcobro" => $receivable->idcobro,
            "idlocal" => $user["idlocal"],
            "idcliente" => $receivable->idcliente,
            "documento_ref" => $receivable->tipodoc." ".$receivable->documento,
            "forma_pago" => $request->forma_pago,
            "ref_pago" => $request->referencia_pago,
            "moneda" => $receivable->moneda,
            "monto" => $monto,
            "interes" => 0.00,
            "fecha_cob" => $request->fecha_pago,
            "hora" => $request->hora_pago,
            "idcobrador" => $request->cobrador,
            "idcaja" => $idcaja,
            "usuario" => $user['name'],
            "observacion" => $request->observacion,
        ]);

        /************************ Update receivable ************************/
        $receivable->saldo -= $request->monto;
        
        if($receivable->saldo == 0){
         $receivable->estado = "C";
         Box::where('idcaja',$idcaja)->update(['concepto'=>'CANCELACION DE CUENTA']);
        }

        $receivable->update();

        return response()->json(['message' => "Cobro realizado con éxito"], 200);
    }


 


}
