<?php

namespace App\Console\Commands;

use App\Post;
use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;
use App\Candle;
use App\Symbol;
use App\Signal;
use Datetime;

class FiveMinutesCurl extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "candle:latest {pair_id}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get Latest Candle Price, MA and Indicators of specific pair";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $fcsapikey = env('FCSAPI_KEY','wow');
            $waktuawal = new DateTime('19:55');
            $waktuakhir = new DateTime('22:01');
            $waktusekarang = new Datetime("now");
            $ignoredtime = '19:55';
            $pair_id = $this->argument('pair_id');
            if($waktusekarang <= $waktuakhir && $waktusekarang >= $waktuawal && $waktusekarang->format('N') < 6){
                $symbol = Symbol::findOrFail($pair_id)->first();

                //get latest candle
                $response = json_decode(Curl::to('https://fcsapi.com/api/forex/candle?id='.$pair_id.'&period=5m&access_key='.$fcsapikey)->get());
                //$response = json_decode(Curl::to('http://localhost/share/candletest.json')->get());
                $candle = $response->response;
                $ct = date("Y-m-d H:i:s", strtotime('+7 hours',strtotime($candle[0]->tm)));
                $candleexist = Candle::where('symbol_id',$pair_id)->where('candle_time',$ct)->first();
                if(!$candleexist){
                    $last_candle = Candle::orderBy('id','desc')->first();
                    $candle_new = new Candle;
                    $candle_new->candle_open = $candle[0]->o;
                    $candle_new->candle_high = $candle[0]->h;
                    $candle_new->candle_low = $candle[0]->l;
                    $candle_new->candle_close = $candle[0]->c;
                    $candle_new->symbol_id = $symbol->id;
                    $candle_new->candle_time = $ct;

                    if(substr($candle_new->candle_time,11,5) == $ignoredtime){
                        $candle_new->candle_from_before = null;
                    }
                    else{
                        if(floatval($candle_new->candle_open) > floatval($last_candle->candle_open))
                            $candle_new->candle_from_before = 'up';
                        else if(floatval($candle_new->candle_open) < floatval($last_candle->candle_open))
                            $candle_new->candle_from_before = 'down';
                        else
                            $candle_new->candle_from_before = 'neutral';
                    }

                    $candle_new->save();
                }
                else{
                    $candle_new = $candleexist;
                }

                //get latest indicator
                if(substr($candle_new->candle_time,11,5) != $ignoredtime){
                    $response = json_decode(Curl::to('https://fcsapi.com/api/forex/indicators?id='.$pair_id.'&period=5m&access_key='.$fcsapikey)->get());
                    //$response = json_decode(Curl::to('http://localhost/share/m5indicatorjson.json')->get());
                    $signal = $response->response->indicators;
                    $signalexist = Signal::where('candle_id',$candle_new->id)->first();

                    //get latest moving average
                    $response = json_decode(Curl::to('https://fcsapi.com/api/forex/ma_avg?id='.$pair_id.'&period=5m&access_key='.$fcsapikey)->get());
                    //$response = json_decode(Curl::to('http://localhost/share/m5majson.json')->get());
                    $ma = $response->response->ma_avg;

                    if(!$signalexist){
                        $signal_new = new Signal;
                        $signal_new->signal_rsi14 = $signal->RSI14->s;
                        $signal_new->signal_stoch9_6 = $signal->STOCH9_6->s;
                        $signal_new->signal_stochrsi14 = $signal->STOCHRSI14->s;
                        $signal_new->signal_macd12_26 = $signal->MACD12_26->s;
                        $signal_new->signal_williamsr = $signal->WilliamsR->s;
                        $signal_new->signal_cci14 = $signal->CCI14->s;
                        $signal_new->signal_atr14 = $signal->ATR14->s;
                        $signal_new->signal_ultimateoscillator = $signal->UltimateOscillator->s;
                        $signal_new->signal_roc = $signal->ROC->s;

                        $signal_new->signal_sma5 = $ma->SMA->MA5->s;
                        $signal_new->signal_sma10 = $ma->SMA->MA10->s;
                        $signal_new->signal_sma20 = $ma->SMA->MA20->s;
                        $signal_new->signal_sma50 = $ma->SMA->MA50->s;
                        $signal_new->signal_sma100 = $ma->SMA->MA100->s;
                        $signal_new->signal_sma200 = $ma->SMA->MA200->s;
                        $signal_new->signal_ema5 = $ma->EMA->MA5->s;
                        $signal_new->signal_ema10 = $ma->EMA->MA10->s;
                        $signal_new->signal_ema20 = $ma->EMA->MA20->s;
                        $signal_new->signal_ema50 = $ma->EMA->MA50->s;
                        $signal_new->signal_ema100 = $ma->EMA->MA100->s;
                        $signal_new->signal_ema200 = $ma->EMA->MA200->s;

                        $signal_new->candle_id = $candle_new->id;
                        $signal_new->save();
                    }
                    else{
                        $signal_new = $signalexist;
                    }
                }
                $this->info("Candle added successfully");
            }
            else
                $this->info("No Candle on this time");
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}