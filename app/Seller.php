<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model {
    protected $table = 'personal';
    public $timestamps = false;
    protected $guarded = [];
}
