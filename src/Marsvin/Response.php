<?php
namespace Marsvin;

use Marsvin\ResponseInterface;

class Response implements ResponseInterface
{

    private $response;

    public function __construct($response)
    {
        $this->set($response);
    }

    public function set($response)
    {
        $this->response = $response;
    }

    public function get()
    {
        return $this->response;
    }

}
