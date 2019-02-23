<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model {
    protected $table = 'det_pro';
    public $timestamps = false;
    protected $guarded = [];

    public function product() {
        return $this->hasOne('App\Product', 'idproducto', 'idproducto');
    }
}
