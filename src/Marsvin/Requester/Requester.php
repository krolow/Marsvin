<?php
namespace Marsvin\Requester;

use Marsvin\ResponseInterface;

class Requester extends AbstractRequester implements RequesterInterface
{

    private $handle;

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function request(ResponseInterface $response)
    {
        $this->handle($this, $response);
    }

}
