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
                if($price != null ){
                    array_push($prices, $price);
                }
            }
            $product->prices = $prices;
            $product->cantidad = 1;
        }

        return $products;
    }
}

