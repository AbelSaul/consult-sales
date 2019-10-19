<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Proforma;
use App\Product;
use App\DetailProduct;
use App\Mail\SendProforma;
use App\Http\Controllers\OtherController;
use View;


class ProformaController extends Controller
{
    public function index() {
        $user = session('user');
       // $proformas = Proforma::where('fecha', '>=' ,Carbon::now()->format('Y-m-d'))->where('idlocal','=',$user["idlocal"])
		$proformas = Proforma::where('fecha', '>=' ,Carbon::now())->where('idlocal','=',$user["idlocal"])
        ->where('idvendedor','=',$user["idpersonal"])
            ->orderByRaw('idproforma * 1 DESC')->paginate(10);

        return view('proformas.index', compact('proformas'));
    }

    public function search(Request $request) {
        $user = session('user');

       // $startDate = $request->startDate ? $request->startDate : Carbon::now()->format('Y-m-d');
		$startDate = $request->startDate ? $request->startDate : Carbon::now()->format('Y-m-d');
        $endDate = $request->endDate ?
            $request->endDate :
            ($request->startDate ? $request->startDate : Carbon::now()->format('Y-m-d') );

        $proformas = Proforma::whereBetween('fecha', [$startDate, $endDate])->where('idlocal','=',$user["idlocal"])
        ->where('idvendedor','=',$user["idpersonal"])
            ->orderByRaw('idproforma * 1 DESC')->with(['client', 'seller'])->paginate(10);

        return response()->json($proformas);
    }

    public function edit($id) {


        $proforma = Proforma::where('idproforma', $id)->with(['client', 'details'])->first();
        $details = $proforma->details->toArray();

        $ids = array_map(function($element) {
                 return $element['idproducto'];
            },
            $details
        );
        $user = session('user');
       $selected_products = DB::select("SELECT
        productos.idproducto, productos.codigo, productos.codigo2, productos.moneda ,productos.tipo ,productos.tipo_imp,productos.descripcion , productos.precio, productos.precio1, productos.precio2, productos.precio3, productos.precio4,productos.precio_fra ,productos.medida, productos.medida_fra,productos.fraccion, productos.igv, productos.marca  , productos.codigo, productos.descripcion,
        kardex.idlocal, SUM(entrada)-SUM(salida) as stock,
            (SELECT SUM(cantidad)-SUM(canjeado) as reserva
            FROM det_pro
            WHERE det_pro.idproducto=productos.idproducto
            GROUP BY det_pro.idproducto) as reserva,
        ((SUM(entrada)-SUM(salida)) - ((
                                        SELECT SUM(cantidad)-SUM(canjeado) as reserva
                                        FROM det_pro
                                        WHERE det_pro.idproducto=productos.idproducto GROUP BY det_pro.idproducto))) as disponible
                                        FROM productos
                                        LEFT JOIN kardex ON productos.idproducto=kardex.idproducto
                                        LEFT JOIN det_pro ON productos.idproducto=det_pro.idproducto
                                        WHERE (productos.idlocal=1 OR productos.idlocal=0) AND (kardex.idlocal='".$user["idlocal"]."' or kardex.idlocal IS NULL) AND productos.estado='A'  AND productos.idproducto IN (".implode(',',$ids).")
                                        AND (YEAR(kardex.fecha)=2019 OR YEAR(kardex.fecha) IS NULL)

                                        GROUP BY productos.idproducto
                                         ORDER BY productos.descripcion");


       foreach ($selected_products as  $product) {
           foreach ($details as  $detail) {
               if ($detail['idproducto'] === $product->idproducto){
               $product->num_um = $detail['num_um'];
               $product->precio = $detail['precio'];
               $product->cantidad = $detail['cantidad'];
               }
            }
        }

       $selected_detail = json_encode($this->objectConvert($selected_products));

        return view('proformas.edit', compact('proforma','selected_detail'));

    }

    public function objectConvert($selected){
        $params = DB::table('parametros')->first();
        $cond = $params->igv_inc == 1;
        $name_prices = ['precio','precio1','precio2','precio3','precio4'];
        foreach ($selected as $product) {
            $prices = array();
            foreach ($name_prices as $name_price) {
                $price = $product->$name_price;
                if($price != null ) {
                    $label = $name_price != 'precio' ? str_replace('precio', 'P', $name_price) : 'P0';
                    array_push($prices, [
                        'label' => $label,
                        'price' => $product->$name_price,
                        // 'price' => $this->calcIgv($cond, $price, $product->igv),
                    ]);
                }
            }
            $product->prices = $prices;
            // $product->precio = $this->calcIgv($cond, $product->precio, $product->igv);
            // $product->precio_fra = $this->calcIgv($cond, $product->precio_fra, $product->igv);
            // $product->cantidad = 1;
            // $product->num_um = 1;
        }
        return $selected;
    }

    // public function edit($id) {

    //     $proforma = Proforma::where('idproforma', $id)->with(['client', 'details'])->first();
    //     return view('proformas.edit', compact('proforma'));
    // }

    public function create(Request $request) {

        $this->validate($request, [
            'clientId' => 'required',
            'sellerId' => 'required',
            'condition' => 'required',
        ]);

        $productos = $request->products;


        $user = session('user');
        $maxIdProforma1 = DB::select("(select max(`idproforma` * 1) as pro from proformas where idlocal='".$user["idlocal"]."' )")[0]->pro + 1;
        $maxIdProforma = DB::select("(select max(`idproforma` * 1) as pro from proformas)")[0]->pro + 1;

        // cond_impuesto
        $params = DB::table('parametros')->first();
        $cond = $params->igv_inc == 1 ? 'IGV Incluido' : 'IGV no Incluido';
        $subTotal = $params->igv_inc == 1 ? $request->total / 1.18 : $request->total;
        $proforma = Proforma::create([
            "idproforma" => $maxIdProforma,
            "idlocal" => $user["idlocal"],
            "idcliente" => $request->clientId,
            "documento" => $this->createDocument($user["idlocal"],$maxIdProforma1),
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
			$tipo_imp = $producto["tipo_imp"] == 'G' ? "10" : "20";
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
                "moneda" => "S/",
                "igv" => $producto["igv"],
                "precio" => $price,
                "desc_cad" => null,
                "descuento" => 0.00,
                "precio_neto" => $price,
                "importe" => $price * $producto["cantidad"],
                "tipo" => "P",
				"marca" => $producto["marca"],
			    "tipo_afecta" => $tipo_imp,
				//"tipo_afecta" => $producto["tipo_imp"],
                "no_stock" => 0,
                "canjeado" => 0.00,
            ]);
        }

        if (request('email')) {
          //  $user = (object) ["email" => request('email') ];
          //  \Mail::to($user)->send(new SendProforma($user, $proforma));
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
        $cond = $params->igv_inc == 1 ? 'IGV Incluido' : 'IGV no Incluido';
        $subTotal = $params->igv_inc == 1 ? $request->total / 1.18 : $request->total;

        $proforma = Proforma::where('idproforma', $request->idproforma)->first();

        $proforma->update([
            "idcliente" => $request->clientId,
            "fecha" => date("Y-m-d"),
            "hora" => date("h:i:s A"),
			"bruto" => $request->total,
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
			$tipo_imp = $producto["tipo_imp"] == 'G' ? "10" : "20";
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
                "moneda" => "S/",
                "igv" => $producto["igv"],
                "precio" => $price,
                "desc_cad" => null,
                "descuento" => 0.00,
                "precio_neto" => $price,
                "importe" => $price * $producto["cantidad"],
                "tipo" => "P",
				"marca" => $producto["marca"],
                "tipo_afecta" => $tipo_imp,
				//"tipo_afecta" => $producto["tipo_imp"],
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

	//Aqui se crea el documento con 0001 tendriamos que pasar la serie
    public function createDocument($idLocal,$pro_max_num) {
        return "000{$idLocal}-" . str_pad($pro_max_num, 9, "0", STR_PAD_LEFT);
    }

    public function getTotalProformas(Request $request){
         $user = session('user');

		$startDate = $request->startDate ? $request->startDate : Carbon::now()->format('Y-m-d');
        $endDate = $request->endDate ?
            $request->endDate :
            ($request->startDate ? $request->startDate : Carbon::now()->format('Y-m-d') );

        $proformas = Proforma::whereBetween('fecha', [$startDate, $endDate])
        ->where('idlocal','=',$user["idlocal"])
        ->where('idvendedor','=',$user["idpersonal"])
        ->get();

        $total = 0;
        foreach ($proformas as $proforma) {
            $total += $proforma->total;
        }

        return $total;
        
            
    }




}
