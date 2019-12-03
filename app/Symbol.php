<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    //
    protected $fillable = [
        'symbol_name','symbol_code','symbol_decimal'
    ];

    //public $timestamps = false;
}
