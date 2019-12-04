<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    //
    protected $guarded = [
        'id','created_at','updated_at','candle_id'
    ];

    //public $timestamps = false;
}
