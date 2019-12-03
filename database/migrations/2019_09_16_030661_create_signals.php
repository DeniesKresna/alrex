<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('signal_rsi14',20);
            $table->string('signal_stoch9_6',20);
            $table->string('signal_stochrsi14',20);
            $table->string('signal_macd12_26',20);
            $table->string('signal_williamsr',20);
            $table->string('signal_cci14',20);
            $table->string('signal_atr14',20);
            $table->string('signal_ultimateoscillator',20);
            $table->string('signal_roc',20);
            $table->string('signal_sma5',20);
            $table->string('signal_sma10',20);
            $table->string('signal_sma20',20);
            $table->string('signal_sma50',20);
            $table->string('signal_sma100',20);
            $table->string('signal_sma200',20);
            $table->string('signal_ema5',20);
            $table->string('signal_ema10',20);
            $table->string('signal_ema20',20);
            $table->string('signal_ema50',20);
            $table->string('signal_ema100',20);
            $table->string('signal_ema200',20);
            $table->integer('candle_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signals');
    }
}
