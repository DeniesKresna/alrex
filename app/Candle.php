<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candle extends Model
{
    //
    protected $fillable = [
        'symbol_id','candle_open','candle_high','candle_low','candle_close','candle_time'
    ];

    //public $timestamps = false;
}
