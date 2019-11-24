<?php

namespace App\Http\Controllers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

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

    public function test(){
        $client = new Client();
        $request = $client->get('http://localhost/skripsikita/public/jsonresponse');
        $response = $request->getBody();
       
        return response()->json(['response'=>$response]);
    }
/*
    public function getGuzzleRequest()
{
    $client = new \GuzzleHttp\Client();
    $request = $client->get('http://myexample.com');
    $response = $request->getBody();
   
    dd($response);
}

public function postGuzzleRequest()
{
    $client = new \GuzzleHttp\Client();
    $url = "http://myexample.com/api/posts";
   
    $myBody['name'] = "Demo";
    $request = $client->post($url,  ['body'=>$myBody]);
    $response = $request->send();
  
    dd($response);
}

public function putGuzzleRequest()
{
    $client = new \GuzzleHttp\Client();
    $url = "http://myexample.com/api/posts/1";
    $myBody['name'] = "Demo";
    $request = $client->put($url,  ['body'=>$myBody]);
    $response = $request->send();
   
    dd($response);
}

public function deleteGuzzleRequest()
{
    $client = new \GuzzleHttp\Client();
    $url = "http://myexample.com/api/posts/1";
    $request = $client->delete($url);
    $response = $request->send();
  
    dd($response);
}
*/

    //
}
