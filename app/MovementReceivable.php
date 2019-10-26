<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementReceivable extends Model {
    protected $table = 'cuentas_cobrar_mov';
    public $timestamps = false;
    protected $guarded = [];


    protected $primaryKey = 'idcobrosmov';
    public $incrementing = false;

    public function seller()
    {
        return $this->hasOne('App\Seller', 'idpersonal', 'idcobrador');
    }
}
