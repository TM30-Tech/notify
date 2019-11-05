<?php
namespace TM30\Notify\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GuzzleService extends Client
{
    private $client;
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    public function postRequest($url, $data = [], $header = [  'Accept' => 'application/json' ]) {
        try {
            $payload = $this->client->request('POST', $url, [
                'headers' => $header,
                'json' => $data
            ]);
            Log::info('Request was successful');
            return [
                "status" => $payload->getStatusCode(),
                "body" => json_decode($payload->getBody()->getContents(), true),
                "raw" => $payload->getBody()
            ];
        } catch (RequestException $e) {
            Log::error('There was an error with the POST Request');
            return response ()->json ([
                'status' => 'error',
                'data' =>  [],
                'message' => 'Error details: '.$e->getMessage(),
            ], 400);
        }
    }

    public function getRequest($url, $params = [], $header = [  'Accept' => 'application/json' ]) {
        try {
            $payload = $this->client->request('GET', $url, [
                'headers' => $header,
                'query' => $params
            ]);
            return [
                "status" => $payload->getStatusCode(),
                "body" => json_decode($payload->getBody()->getContents(), true),
                "raw" => $payload->getBody()
            ];
        } catch (RequestException $e) {
            Log::error('There was an error with the Get Request');
            return response ()->json ([
                'status' => 'error',
                'data' =>  [],
                'message' => 'Error details: '.$e->getMessage(),
            ], 400);
        }
    }

    public function patch($url, $body = []){
        try{
            $payload = [
                "headers" => $this->getHeader(),
                "json" => $body
            ];
            $payload = parent::patch($url,$payload);
            return [
                "status" => $payload->getStatusCode(),
                "body" => json_decode($payload->getBody()->getContents(), true)["data"],
                "raw" => $payload->getBody()
            ];
        }catch (\Exception $exception){
            return $this->handleException($exception);
        }
    }

    public function upload($url, $body = [], $header = []){
        try{
            $payload = $this->client->post($url,[
                'multipart' => [
                    $body
                ]
            ]);

            return [
                "status" => $payload->getStatusCode(),
                "body" => json_decode($payload->getBody()->getContents(), true)["data"],
                "raw" => $payload->getBody()
            ];
        }catch (\Exception $exception){
            return $this->handleException($exception);
        }
    }
}