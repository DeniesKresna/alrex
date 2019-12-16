<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('app');
});

$router->get('/candle/latest/fiveminutes/signals/{limit}/{pair_id}', 'CandleController@getFiveMinutesData');
$router->get('candle/latest/fiveminutes/candle/eurusd', 'CandleController@curlFiveMinutesCandleEurUsd');
$router->get('/getHistoryAndLastSignal/{limit}/{pair_id}','CandleController@getHistoryAndLastSignal');

$router->group(['middleware' => 'login'], function() use ($router) {
	$router->get('/auth/session', 'AuthController@session');
});