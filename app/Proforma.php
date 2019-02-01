<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $table = 'proformas';
    public $timestamps = false;
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany('App\DetailProduct',  'idproforma', 'idproforma');
    }
   
    public function client()
    {
        return $this->hasOne('App\Client',  'idcliente', 'idcliente');
    }
}
