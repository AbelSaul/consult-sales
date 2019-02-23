<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $table = 'proformas';
    public $timestamps = false;
    protected $guarded = [];

    protected $primaryKey = 'idproforma';
    public $incrementing = false;

    public function details()
    {
        return $this->hasMany('App\DetailProduct', 'idproforma', 'idproforma');
    }
   
    public function client()
    {
        return $this->hasOne('App\Client', 'idcliente', 'idcliente');
    }
    
    public function seller()
    {
        return $this->hasOne('App\Seller', 'idpersonal', 'idvendedor');
    }

    public function products()
    {
        return $this->hasManyThrough(
            'App\Product',
            'App\DetailProduct',
            'idproforma', // Foreign key on users table...
            'idproducto', // Foreign key on posts table...
            'idproforma', // Local key on countries table...
            'idproducto' // Local key on users table...
        );
    }
}
