<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {

        // $products = Product::where('estado', 'A')->orderBy('descripcion', 'asc')
        //                                          ->get();
        $user = session('user');
        $products = DB::select("SELECT
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
                                        WHERE (productos.idlocal=1 OR productos.idlocal=0) AND (kardex.idlocal='" . $user["idlocal"] . "' or kardex.idlocal IS NULL) AND productos.estado='A' AND (YEAR(kardex.fecha)=2021 OR YEAR(kardex.fecha) IS NULL)

                                        GROUP BY productos.idproducto
                                         ORDER BY productos.descripcion");


        $products_convert = $this->objectConvert($products);

        return $products_convert;
    }

    public function search(Request $request)
    {

        $search = $request->search;
        $products = Product::where('estado', 'A')
            ->where('descripcion', 'like', '%' . $search . '%')
            ->orderBy('descripcion', 'asc')
            ->paginate(5);

        $products_convert = $this->convert($products);

        return response()->json($products_convert);
    }

    public function convert($products)
    {
        $params = DB::table('parametros')->first();
        $cond = $params->igv_inc == 1;
        $exchange_rate = $params->tcambio;

        $name_prices = ['precio', 'precio1', 'precio2', 'precio3', 'precio4'];
        foreach ($products as $product) {
            $prices = array();
            foreach ($name_prices as $name_price) {
                $price = $product[$name_price];
                if ($price != null) {
                    $label = $name_price != 'precio' ? str_replace('precio', 'P', $name_price) : 'P0';

                    array_push($prices, [
                        'label' => $label,
                        'price' => $this->calcIgv($cond, $price, $product['igv']),
                    ]);
                }
            }
            $product->prices = $prices;
            $product->precio = $this->calcIgv($cond, $product['precio'], $product['igv']);
            $product->precio_fra = $this->calcIgv($cond, $product['precio_fra'], $product['igv']);
            $product->cantidad = 1;
            $product->num_um = 1;
        }
        return $products;
    }

    public function objectConvert($products)
    {
        //Este metodo se usa debido a la consulta descrita
        $params = DB::table('parametros')->first();
        $cond = $params->igv_inc == 1;
        $name_prices = ['precio', 'precio1', 'precio2', 'precio3', 'precio4'];
        $exchange_rate = $params->tcambio;

        foreach ($products as $product) {
            $prices = array();
            foreach ($name_prices as $name_price) {
                $price = $product->$name_price;
                if ($price != null) {
                    $label = $name_price != 'precio' ? str_replace('precio', 'P', $name_price) : 'P0';
                    $new_price = $product->moneda == "US$" ? $price * $exchange_rate : $price;
                    array_push($prices, [
                        'label' => $label,
                        'price' => $this->calcIgv($cond, $new_price, $product->igv),
                    ]);
                }
            }
            $new_price = $product->moneda == "US$" ? $product->precio * $exchange_rate : $product->precio;
            $new_price_fra = $product->moneda == "US$" ? $product->precio_fra * $exchange_rate : $product->precio_fra;


            $product->prices = $prices;
            $product->precio = $this->calcIgv($cond, $new_price, $product->igv);
            $product->precio_fra = $this->calcIgv($cond, $new_price_fra, $product->igv);
            $product->cantidad = 1;
            $product->num_um = 1;
        }
        return $products;
    }

    public function calcIgv($cond, $price, $igv)
    {
        return number_format($cond ? $price * (1 + 18 / 100) : $price, 4);
    }
}
