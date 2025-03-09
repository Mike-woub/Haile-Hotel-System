<?php

namespace Chapa;

require_once __DIR__ . '/../../../autoload.php';

use Chapa\Model\PostData;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Chapa\Model\ResponseData;
use InvalidArgumentException;
use RuntimeException;

/**
 * The Chapa class is responsible for making GET and POST request to Chapa API
 * to initialize payment and verify transactions.
 */
class Chapa
{

    const baseUrl = 'https://api.chapa.co/';
    const apiVersion = 'v1';

    private $client;
    private $headers;
    private $secreteKey;

    /**
     *
     * @param string  $secreteKey A secrete key provided from Chapa.
     */
    function __construct($secreteKey)
    {

        $this->secreteKey = $secreteKey;
        $this->client = new Client(['base_uri' => self::baseUrl]);
        $this->headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->secreteKey
        ];
    }

    /**
     * Return {@link ResponseData} object for a valid request.
     *
     * @param  PostData                              $postData An object that represents post fields.
     * @return ResponseData                                    An object that represents response data from Chapa API.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function initialize($postData)
    {
        Util::validate($postData);

        $request = new Request('POST', self::apiVersion . '/transaction/initialize');
        try{
            $response = $this->client->send($request, [
                'headers' => $this->headers,
                'form_params' => $postData->getAsKeyValue()
            ]);
        }catch (Exception $e){
            //  rethrow runtime exception for internal server errors
            if($e->getCode() >= 500){
                throw new RuntimeException($e->getMessage(), $e);
            }
            return new ResponseData($e->getResponse()->getBody(),  $e->getResponse()->getStatusCode());
        }

        return new ResponseData($response->getBody(), $response->getStatusCode());
    }

    /**
     * Return {@link ResponseData} object for a valid request.
     *
     * @param string                                                        $transactionRef Transaction reference that uniquely identifies
     *                                                                                      the transaction to be validated.
     * @return ResponseData                                                                 An object that represents response data from Chapa API.
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidArgumentException
     */
    public function verify($transactionRef)
    {
        if(empty($transactionRef)){
            throw new InvalidArgumentException("Transaction reference can't be null or empty");
        }

        $request = new Request('GET', self::apiVersion . '/transaction/verify/' . $transactionRef);
        try{
            $response = $this->client->send($request, [
                'headers' => $this->headers,
            ]);
        }catch(RequestException $e){
            // rethrow runtime exception for internal server errors
            if($e->getCode() >= 500){
                throw new RuntimeException($e->getMessage(), $e);
            }
             return new ResponseData($e->getResponse()->getBody(),  $e->getResponse()->getStatusCode());
        }
        return new ResponseData($response->getBody(), $response->getStatusCode());
    }
}
