<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('symbol_id');
            $table->string('candle_open',10);
            $table->string('candle_high',10);
            $table->string('candle_low',10);
            $table->string('candle_close',10);
            $table->datetime('candle_time');
            $table->string('candle_from_before',10)->nullable();
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
        Schema::dropIfExists('candles');
    }
}
