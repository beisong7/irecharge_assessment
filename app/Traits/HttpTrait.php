<?php

namespace App\Traits;


use GuzzleHttp\Client;

trait HttpTrait{

    /**
     * This method makes http requests and returns an array of the response and a bool success result
     * @param $method
     * @param $url
     * @param null | $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeRequest($method, $url, $params=null){
        $secret = config('app.flutterwave.private_key');
        $header = [
            "Authorization"=>"Bearer {$secret}",
            'content-type' => 'application/json',
        ];
        try{
            $client = new Client(['timeout'  => 1300.0,]);
            $request = $client->request(strtoupper($method), $url, [
                'body'=>empty($params)?null:json_encode($params),
                'headers'=>$header,
            ]);

            $response = $request->getBody();
            $data = json_decode((string)$response, true);

            return ['success'=>true, 'data'=>$data];
        }catch (\Exception $e){
            //log error
            return ['success'=>false, "error"=>$e->getMessage(), "payload"=>$params];

        }

    }



}