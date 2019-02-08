<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index() {

        $products = Product::all();
        $name_prices = ['precio','precio1','precio2','precio3','precio4'];
        foreach ($products as $product) {
            $prices = array();
            foreach ($name_prices as $name_price) {
                $price = $product[$name_price];
                if($price != null ) {
                    $label = $name_price != 'precio' ? str_replace('precio', 'P', $name_price) : 'P0'; 
                    array_push($prices, [
                        'label' => $label,
                        'price' => $this->calcIgv($product['tipo'], $price, $product['igv']),
                    ]);
                }
            }
            $product->prices = $prices;
            $product->precio = $this->calcIgv($product['tipo'], $product['precio'], $product['igv']);
            $product->cantidad = 1;
            $product->num_um = 1;
        }

        return $products;
    }

    public function calcIgv($tipo, $price, $igv) {
        return $tipo == 'G' ? $price * (1 + $igv / 100 ) : $price;
    }
}

