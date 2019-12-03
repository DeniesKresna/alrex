<?php

namespace App\Http\Controllers;
use Ixudra\Curl\Facades\Curl;
use App\Candle;
use App\Symbol;
use Datetime;

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

    public function getData($pair){
        $symbol = Symbol::where('symbol_code',$pair)->first();
        if($symbol){
            $response = json_decode(Curl::to('http://localhost/skripsikita/public/jsonresponse')->get());
            foreach($response->response as $candle){
                $candle_new = new Candle;
                $candle_new->candle_open = $candle->o;
                $candle_new->candle_high = $candle->h;
                $candle_new->candle_low = $candle->l;
                $candle_new->candle_close = $candle->c;
                $candle_new->symbol_id = $symbol->id;
                $candle_new->candle_time = date("Y-m-d H:i:s");
                $candle_new->save();
            }
            return response()->json(["message"=>"success","candles"=>Candle::all()]);
        }
        else{
            return response()->json(["message"=>"tidak ada symbol pair itu"]);
        }
    }

    public function getFiveMinutesSignals($pair_id){
        $waktuawal = new DateTime('20:00');
        $waktuakhir = new DateTime('22:00');
        $waktusekarang = new Datetime("now");
        if($waktusekarang <= $waktuakhir && $waktusekarang >= $waktuawal){
            $symbol = Symbol::findOrFail($pair_id)->first();
            $response = json_decode(Curl::to('https://fcsapi.com/api/forex/candle?id='.$pair_id.'&period=5m&access_key=NieUEXJJgr7aLY6Gp0ZWYk7klZxCkTesWUvJwsXcHtQhbM5OLY')->get());
            $candle = $response->response;
            $candleexist = Candle::where('symbol_id',$pair_id)->where('candle_time',$candle[0]->tm)->first();
            if(!$candleexist){
                $candle_new = new Candle;
                $candle_new->candle_open = $candle[0]->o;
                $candle_new->candle_high = $candle[0]->h;
                $candle_new->candle_low = $candle[0]->l;
                $candle_new->candle_close = $candle[0]->c;
                $candle_new->symbol_id = $symbol->id;
                $candle_new->candle_time = $candle[0]->tm;
                $candle_new->save();
            }
            else{
                $candle_new = $candleexist;
            }

            
            return response()->json(['waktuawal'=>$waktuawal,'waktuakhir'=>$waktuakhir,'waktusekarang'=>$waktusekarang, 'candle'=>$candle_new]);
        }
        else
            return response()->json(['pesan'=>"Tidak diijinkan waktu ini"]);
        /*
        if()
        $symbol = Symbol::where('symbol_code',$pair)->first();
        if($symbol){

        }*/
    }
}
