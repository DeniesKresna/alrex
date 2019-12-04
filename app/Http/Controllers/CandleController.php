<?php

namespace App\Http\Controllers;
use App\Candle;
use Illuminate\Support\Facades\DB;

class CandleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        
    }

    public function getFiveMinutesData($limit, $pair_id){
        $candles = DB::table('candles as c')->join('signals as s','c.id','=','s.candle_id')
                ->where('c.candle_time','not like','% 19:55%')
                ->where('c.symbol_id',$pair_id)->orderBy('c.id','desc')->take($limit)->get();
        return response()->json(['candles'=>$candles]);
    }
}
