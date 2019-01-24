<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'productos';
    public $timestamps = false;
    protected $guarded = [];

    // protected $prices = [45,6,5];

    // public function getPricesAttribute() {
    //     return $this->prices;
    // }

    // public function setPricesAttribute($value) {
    //     $this->prices= $value;
    // }


}
