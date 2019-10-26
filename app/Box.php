<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model {
    protected $table = 'caja';
    public $timestamps = false;
    protected $guarded = [];

    protected $primaryKey = 'idcaja';
    public $incrementing = false;
}
