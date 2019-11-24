<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSymbols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symbols', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('symbol_name');
            $table->string('symbol_code');
            $table->smallInteger('symbol_decimal');
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
        Schema::dropIfExists('symbols');
    }
}
