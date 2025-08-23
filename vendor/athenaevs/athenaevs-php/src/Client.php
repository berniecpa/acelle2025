<?php

namespace AthenaEVS;

use GuzzleHttp\Client as GuzzleClient;
use Exception;

class Client
{
    protected $apiKey;
    protected $client;
    protected $enpoint;

    // const DEFAULT_ENPOINT = 'http://em.com/api/v1/'; // local
    const DEFAULT_ENPOINT = 'https://app.emailevs.com/api/v1/';

    public function __construct($apiKey, $enpoint=null)
    {
        $this->apiKey = $apiKey;

        if ($enpoint) {
            $this->enpoint = $enpoint;
        } else {
            $this->enpoint = static::DEFAULT_ENPOINT;
        }
    }

    private function getClient()
    {
        if (!$this->client) {
            $this->client = new GuzzleClient([
                'base_uri' => $this->enpoint,
                'verify' => false,
                'headers' => [
                    // 'Content-Type' => 'application/json',
                    // 'Authorization' => "Bearer {$this->apiKey}",
                ],
            ]);
        }

        return $this->client;
    }

    private function makeRequest($method, $uri, $params = [])
    {
        $client = $this->getClient();

        // API key
        $params = array_merge($params, [
            'api_key' => $this->apiKey,
        ]);

        //
        try {
            $options = [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Accept' => 'application/json',
                ],
            ];

            // If the method is POST, add form_params
            if (strtoupper($method) == 'POST') {
                $options['form_params'] = $params;
            } else if (strtoupper($method) == 'GET') {
                $options['query'] = $params;
            }

            $response = $client->request($method, $uri, $options);

            // Get the status code of the response
            $statusCode = $response->getStatusCode();

            // Get the response body
            $body = $response->getBody();

            // Decode the JSON response if necessary
            $data = json_decode($body, true);

            // Output the data
            return [$statusCode, $data];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // // Handle client exceptions
            // echo 'ClientException: ' . $e->getMessage() . "\n";
            // echo 'Response: ' . $e->getResponse()->getBody()->getContents() . "\n";
            // echo 'Stack Trace: ' . $e->getTraceAsString() . "\n";

            // return $e->getResponse();

            throw new \Exception($e->getResponse()->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // // Handle request exceptions
            // echo 'RequestException: ' . $e->getMessage() . "\n";
            // if ($e->hasResponse()) {
            //     echo 'Response: ' . $e->getResponse()->getBody()->getContents() . "\n";
            // }
            // echo 'Stack Trace: ' . $e->getTraceAsString() . "\n";

            // return $e->getResponse();
            throw new \Exception($e->getResponse()->getBody()->getContents());
            
        } catch (Exception $e) {
            // // Handle all other exceptions
            // echo 'Exception: ' . $e->getMessage() . "\n";
            // echo 'Stack Trace: ' . $e->getTraceAsString() . "\n";

            throw new \Exception($e->getMessage());
        }
    }

    public function testApi()
    {
        list($statusCode, $data) = $this->makeRequest('GET', 'test', []);

        return $statusCode;
    }

    public function verify($email)
    {
        list($statusCode, $data) = $this->makeRequest('POST', 'verify', [
            'email' => $email,
        ]);

        return $data;
    }

    public function batchVerify(array $emails)
    {
        list($statusCode, $data) = $this->makeRequest('POST', 'batch-verify', [
            'emails' => $emails,
        ]);

        return $data;
    }
    
    public function getBatchStatus($batchId)
    {
        list($statusCode, $data) = $this->makeRequest('POST', 'batch-status', [
            'batch_id' => $batchId,
        ]);

        return $data;
    }

    public function getBatchResult($batchId)
    {
        list($statusCode, $data) = $this->makeRequest('POST', 'batch-result', [
            'batch_id' => $batchId,
        ]);

        return $data;
    }

    public function getCredits()
    {
        list($statusCode, $data) = $this->makeRequest('GET', 'get-credits');

        return $data;
    }
}
