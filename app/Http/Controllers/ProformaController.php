<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Proforma;
use App\Product;
use App\DetailProduct;

class ProformaController extends Controller
{
    public function create(Request $request) {

        $this->validate($request, [
            'clientId' => 'required',
            'sellerId' => 'required',
            'condition' => 'required',
            'observation' => 'required'
        ]);

        $productos = $request->products;


        $maxIdProforma = DB::select("(select max(`idproforma` * 1) as pro from proformas)")[0]->pro + 1;
        $proforma = Proforma::Create([
            "idproforma" => $maxIdProforma,
            "idlocal" => 1,
            "idcliente" => $request->clientId,
            "documento" => $this->createDocument($maxIdProforma),
            "fecha" => date("Y-m-d"),
            "hora" => date("h:i:s A"),
            "lista_prec" => 0,
            "moneda" => "S/",
            "cambio" => 3,
            "bruto" => $request->total,
            "descuento" => 0.00,
            "subtotal" => $request->total,
            "igv" => 0.00,
            "total" => $request->total,
            "idvendedor" => $request->sellerId,
            "condicion" => strtoupper($request->condition),
            "observac" => $request->observation,
            "estado" => "PE",
        ]);

        // save products_items
        foreach ($productos as $producto) {
            DetailProduct::Create([
                "idproforma" => $proforma->idproforma,
                "idlocal" => 1,
                "idproducto" => Product::where("codigo", $producto["codigo"])->first()->idproducto,
                "codigo" => $producto["codigo"],
                "descripcion" => $producto["descripcion"],
                "medida" => $producto["medida"],
                "cantidad" => $producto["cantidad"],
                "num_um" => 1,
                "moneda" => "S/",
                "igv" => 0.00,
                "precio" => $producto["precio"],
                "descuento" => 0.00,
                "precio_neto" => $producto["precio"],
                "importe" => $producto["precio"],
                "tipo" => "P",
                "no_stock" => 0,
                "canjeado" => 0.00,
            ]);
        }

        return response()->json(['message' => "Proforma creada"], 200);
    }

    public function createDocument($pro_max_num)   {
        return "0001-" . str_pad($pro_max_num, 9, "0", STR_PAD_LEFT);
    }

    public function conditions(){
        $conditions = [['id' => 01 , 'text' => 'Al contado'],['id' => 02 , 'text' => 'Al crédito'],['id' => 03 , 'text' => 'Otros']];
        return $conditions;
    }
}
