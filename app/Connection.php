<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'ruc', 'basedata'
    ];
}
