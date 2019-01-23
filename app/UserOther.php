<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOther extends Model {
    protected $table = 'usuarios';
    public $timestamps = false;
    protected $guarded = [];
}
