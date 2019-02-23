<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;

class ProductController extends Controller
{
    public function index() {

        $params = DB::table('parametros')->first();
        $cond = $params->igv_inc == 1;
        
        $products = Product::where('estado', 'A')->get();
        $name_prices = ['precio','precio1','precio2','precio3','precio4'];
        foreach ($products as $product) {
            $prices = array();
            foreach ($name_prices as $name_price) {
                $price = $product[$name_price];
                if($price != null ) {
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

    public function calcIgv($cond, $price, $igv) {
        return number_format($cond ? $price * (1 + 18 / 100 ) : $price, 4);
    }
}

