<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Proforma;
use App\Product;
use App\DetailProduct;
use App\Mail\SendProforma;

class ProformaController extends Controller
{
    public function index() {
        $proformas = Proforma::where('fecha', '>=' ,Carbon::now()->subDays(30)->format('Y-m-d'))
            ->orderByRaw('idproforma * 1 DESC')->paginate(10);
        return view('proformas.index', compact('proformas'));
    }
   
    public function search(Request $request) {

        $startDate = $request->startDate ? $request->startDate : Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = $request->endDate ? 
            $request->endDate : 
            ($request->startDate ? $request->startDate : Carbon::now()->format('Y-m-d') );
                
        $proformas = Proforma::whereBetween('fecha', [$startDate, $endDate])
            ->orderByRaw('idproforma * 1 DESC')->with(['client', 'seller'])->paginate(10);

        return response()->json($proformas);
    }

    public function edit($id) {
        $proforma = Proforma::where('idproforma', $id)->with(['client', 'details'])->first();
        return view('proformas.edit', compact('proforma'));
    }

    public function create(Request $request) {

        $this->validate($request, [
            'clientId' => 'required',
            'sellerId' => 'required',
            'condition' => 'required',
        ]);

        $productos = $request->products;
        
        
        $user = session('user');
        $maxIdProforma = DB::select("(select max(`idproforma` * 1) as pro from proformas)")[0]->pro + 1;
        
        // cond_impuesto
        $params = DB::table('parametros')->first();
        $cond = $params->igv_inc == 1 ? 'IGV incluido' : 'IGV no incluido';
        $subTotal = $params->igv_inc == 1 ? $request->total / 1.18 : $request->total;
        $proforma = Proforma::create([
            "idproforma" => $maxIdProforma,
            "idlocal" => $user["idlocal"],
            "idcliente" => $request->clientId,
            "documento" => $this->createDocument($maxIdProforma),
            "fecha" => date("Y-m-d"),
            "hora" => date("h:i:s A"),
            "lista_prec" => 0,
            "moneda" => $params->moneda,
            "cambio" => $params->tcambio,
            "bruto" => $request->total,
            "descuento" => 0.00,
            "subtotal" => $subTotal,
            "igv" => $request->total - $subTotal,
            "total" => $request->total,
            "idvendedor" => $request->sellerId,
            "condicion" => strtoupper($request->condition),
            "cond_impuesto" => $cond,
            "observac" => $request->observation,
            "atencion" => $request->attention,
            "estado" => "PE",
            "usuario" => $user["name"],
            "correo" => $request->email,
            "telefonos" => $request->phone,
        ]);

        // save products_items
        foreach ($productos as $producto) {
            $price = $producto["tipo"] == 'G' ? $producto["precio"] / (1 +  $producto["igv"] / 100) : $producto["precio"];   
            DetailProduct::create([
                "idproforma" => $proforma->idproforma,
                "idlocal" => $user["idlocal"],
                "idproducto" => Product::where("codigo", $producto["codigo"])->first()->idproducto,
                "codigo" => $producto["codigo"],
                "codigo2" => $producto["codigo2"],
                "descripcion" => $producto["descripcion"],
                "medida" => $producto["num_um"] == 2 ? $producto["medida_fra"] : $producto["medida"],
                "cantidad" => $producto["cantidad"],
                "num_um" => $producto["num_um"],
                "moneda" => $producto["moneda"],
                "igv" => $producto["igv"],
                "precio" => $price,
                "desc_cad" => null,
                "descuento" => 0.00,
                "precio_neto" => $price,
                "importe" => $price,
                "tipo" => "P",
                "tipo_afecta" => $producto["tipo_imp"],
                "no_stock" => 0,
                "canjeado" => 0.00,
            ]);
        }

        if (request('email')) {
            $user = (object) ["email" => request('email') ];
            \Mail::to($user)->send(new SendProforma($user, $proforma));
        }
        
        return response()->json(['message' => "Proforma creada"], 200);
    }
    
    public function update(Request $request) {

        $this->validate($request, [
            'clientId' => 'required',
            'sellerId' => 'required',
            'condition' => 'required',
        ]);

        $productos = $request->products;
        
        $user = session('user');
        
        // cond_impuesto
        $params = DB::table('parametros')->first();
        $cond = $params->igv_inc == 1 ? 'IGV incluido' : 'IGV no incluido';
        $subTotal = $params->igv_inc == 1 ? $request->total / 1.18 : $request->total;

        $proforma = Proforma::where('idproforma', $request->idproforma)->first();  

        $proforma->update([
            "idcliente" => $request->clientId,
            "fecha" => date("Y-m-d"),
            "hora" => date("h:i:s A"),
            "subtotal" => $subTotal,
            "igv" => $request->total - $subTotal,
            "total" => $request->total,
            "condicion" => strtoupper($request->condition),
            "cond_impuesto" => $cond,
            "observac" => $request->observation,
            "atencion" => $request->attention,
            "correo" => $request->email,
            "telefonos" => $request->phone,
        ]);

        $proforma->details()->delete();
        
        foreach ($productos as $producto) {
            $price = $producto["tipo"] == 'G' ? $producto["precio"] / (1 +  $producto["igv"] / 100) : $producto["precio"];   
            DetailProduct::create([
                "idproforma" => $proforma->idproforma,
                "idlocal" => $user["idlocal"],
                "idproducto" => Product::where("codigo", $producto["codigo"])->first()->idproducto,
                "codigo" => $producto["codigo"],
                "codigo2" => $producto["codigo2"],
                "descripcion" => $producto["descripcion"],
                "medida" => $producto["num_um"] == 2 ? $producto["medida_fra"] : $producto["medida"],
                "cantidad" => $producto["cantidad"],
                "num_um" => $producto["num_um"],
                "moneda" => $producto["moneda"],
                "igv" => $producto["igv"],
                "precio" => $price,
                "desc_cad" => null,
                "descuento" => 0.00,
                "precio_neto" => $price,
                "importe" => $price,
                "tipo" => "P",
                "tipo_afecta" => $producto["tipo_imp"],
                "no_stock" => 0,
                "canjeado" => 0.00,
            ]);
        }

        if (request('email')) {
            // $user = (object) ["email" => request('email') ];
            // \Mail::to($user)->send(new SendProforma($user, $proforma));
        }

        return response()->json(['message' => "Proforma actualizada"], 200);
    }

    public function createDocument($pro_max_num) {
        return "0001-" . str_pad($pro_max_num, 9, "0", STR_PAD_LEFT);
    }

}
