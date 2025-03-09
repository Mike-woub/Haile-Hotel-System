<?php

namespace Chapa\Model;

require_once __DIR__ . '/../../../../autoload.php';

/**
 * The PostData class is an object representation of JSON data
 * returned from Chapa API.
 */
class ResponseData
{

    private $statusCode;
    private $message;
    private $status;
    private $data;

    /**
     * @param json  $response JSON data to be mapped to ResponseData object.
     */
    public function __construct($response, $statusCode)
    {
        $response = json_decode($response);

        $this->statusCode = $statusCode;
        $this->message = $response->message;
        $this->status = $response->status;
        $this->data = $response->data;
    }

    public function getStatusCode(){
        return $this->statusCode;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getData()
    {
        return $this->data;
    }
}
