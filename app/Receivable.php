<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receivable extends Model {
    protected $table = 'cuentas_cobrar';
    protected $primaryKey = 'idcobro';
    public $timestamps = false;
    protected $guarded = [];

    public function client()
    {
        return $this->hasOne('App\Client', 'idcliente', 'idcliente');
    }
    
    public function seller()
    {
        return $this->hasOne('App\Seller', 'idpersonal', 'idencargado');
    }

}
